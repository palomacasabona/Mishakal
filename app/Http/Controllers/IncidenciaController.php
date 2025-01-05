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

        // Crear la nueva incidencia
        $incidencia = new Incidencia();
        $incidencia->titulo = $validatedData['titulo'];
        $incidencia->descripcion = $validatedData['descripcion'];
        $incidencia->usuario_id = auth()->id();
        $incidencia->prioridad = $validatedData['prioridad'];
        $incidencia->categoria = $validatedData['categoria'];
        $incidencia->estado = 'en proceso';

        // Guarda la incidencia en la base de datos
        $incidencia->save(); // Ahora ya tiene un ID

        // Si se sube un archivo, guardarlo
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombre = time() . '_' . $archivo->getClientOriginalName();
            $ruta_archivo = $archivo->storeAs('archivos', $nombre, 'public');

            // Actualiza la incidencia con la ruta del archivo
            $incidencia->archivo = $ruta_archivo;
            $incidencia->save(); // Actualiza la incidencia para guardar la ruta
        }

        // Redirige con mensaje de éxito
        return redirect()->route('perfil')->with('success', 'Incidencia registrada correctamente.');
    }
    /**
     * Muestra los detalles de una incidencia específica.
     */
    public function show($id)
    {
        $incidencia = Incidencia::with('archivo')->find($id);

        // Agrega un log para depurar
        logger()->info('Archivo relacionado:', ['archivo' => $incidencia->archivo]);

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
