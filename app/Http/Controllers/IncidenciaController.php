<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    /**
     * Muestra una lista de todas las incidencias con búsqueda.
     */
    public function index(Request $request)
    {
        $query = Incidencia::query();

        $search = $request->input('search', ''); // Asignar un valor predeterminado a $search

        if (!empty($search)) {
            $query->where('id_incidencia', 'LIKE', "%{$search}%")
                ->orWhere('titulo', 'LIKE', "%{$search}%");
        }

        $incidencias = $query->orderBy('created_at', 'desc')->paginate(14);

        return view('incidencias.index', compact('incidencias', 'search'));
    }

    /**
     * Muestra el formulario para crear una nueva incidencia.
     */
    public function create()
    {
        return view('incidencias.create');
    }

    /**
     * Almacena una nueva incidencia en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string',
            'prioridad' => 'required|string',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Inicializar ruta de archivo como null
        $rutaArchivo = null;

        // Subir archivo si corresponde
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $rutaArchivo = $archivo->store('archivos', 'public'); // Guardar archivo en el sistema de almacenamiento
        }

        // Crear la nueva incidencia con los datos validados y la ruta del archivo
        $incidencia = Incidencia::create([
            'titulo' => $validatedData['titulo'],
            'descripcion' => $validatedData['descripcion'],
            'categoria' => $validatedData['categoria'],
            'prioridad' => $validatedData['prioridad'],
            'estado' => 'en proceso', // Estado inicial definido como 'en proceso'
            'usuario_id' => auth()->id(),
            'archivo' => $rutaArchivo, // Guardar la ruta del archivo
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('perfil')->with('success', 'Incidencia registrada correctamente.');
    }

    /**
     * Muestra los detalles de una incidencia específica.
     */
    public function show($id_incidencia)
    {
        // Cargar la incidencia junto con sus archivos relacionados
        $incidencia = Incidencia::with('archivos')->findOrFail($id_incidencia);

        // Devolver la vista con los detalles de la incidencia
        return view('verIncidencia', compact('incidencia'));    }

    /**
     * Actualiza una incidencia existente.
     */
    public function update(Request $request, $id_incidencia)
    {
        // Validar los datos enviados
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
            'prioridad' => 'required|string',
        ]);

        // Buscar y actualizar la incidencia
        $incidencia = Incidencia::findOrFail($id_incidencia);
        $incidencia->update($validatedData);

        return redirect()->route('incidencias.show', $id_incidencia)->with('success', 'Incidencia actualizada correctamente.');
    }
}
