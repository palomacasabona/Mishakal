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
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Validación para el archivo
        ]);

        // Crear la nueva incidencia
        $incidencia = new Incidencia();
        $incidencia->titulo = $validatedData['titulo'];
        $incidencia->descripcion = $validatedData['descripcion'];
        $incidencia->usuario_id = auth()->id();
        $incidencia->prioridad = $validatedData['prioridad'];
        $incidencia->categoria = $validatedData['categoria'];
        $incidencia->estado = 'en proceso'; // Estado inicial definido como 'en proceso'
        $incidencia->save();

        // Subir archivo, si corresponde
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $ruta = $archivo->storeAs('archivos', $nombreArchivo, 'public');

            // Crear el registro en la tabla 'archivos'
            Archivo::create([
                'nombre' => $nombreArchivo, // Ajustado para que coincida con el archivo subido
                'ruta_archivo' => $ruta, // Ruta del archivo en el almacenamiento
                'incidencia_id' => $incidencia->id_incidencia, // Relacionar con la incidencia recién creada
            ]);
        }

        return redirect()->route('perfil')->with('success', 'Incidencia registrada correctamente.');
    }
    /**
     * Muestra los detalles de una incidencia específica.
     */
    public function show($id_incidencia)
    {
        // Cargar la incidencia junto con su archivo relacionado
        $incidencia = Incidencia::with('archivo')->findOrFail($id_incidencia);

        // Devolver la vista con los detalles de la incidencia
        return view('verIncidencia', compact('incidencia'));
    }

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
