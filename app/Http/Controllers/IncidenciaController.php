<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class IncidenciaController extends Controller
{
    /**
     * Muestra una lista de todas las incidencias.
     * GET /incidencias
     */
    public function index()
    {
        $incidencias = Incidencia::all(); // Obtiene todas las incidencias de la base de datos
        return view('Incidencias.index', compact('incidencias')); // Pasa los datos a la vista
    }
    /**
     * Muestra el formulario para crear una nueva incidencia.
     * GET /incidencias/create
     */
    public function create()
    {
        // Devolver la vista para crear una nueva incidencia
        return view('incidencias.create');
    }

    /**
     * Almacena una nueva incidencia en la base de datos.
     * POST /incidencias
     */
    public function store(Request $request)
    {
        // Validar los datos enviados desde el formulario
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
            'categoria' => 'required|string',
            'prioridad' => 'required|string',
            'usuario_id' => 'required|exists:usuarios,id_usuario', // Validar que el usuario existe
        ]);

        // Crear la incidencia con los datos validados
        Incidencia::create($validated);

        // Redirigir al listado con un mensaje de éxito
        return redirect()->route('incidencias.index')->with('success', 'Incidencia creada exitosamente.');
    }

    /**
     * Muestra los detalles de una incidencia específica.
     * GET /incidencias/{id}
     */
    public function show($id)
    {
        // Buscar la incidencia en la base de datos
        $incidencia = Incidencia::findOrFail($id);

        // Pasar la incidencia a la vista de detalle
        return view('incidencias.show', compact('incidencia'));
    }

    /**
     * Muestra el formulario para editar una incidencia existente.
     * GET /incidencias/{id}/edit
     */
    public function edit($id)
    {
        // Buscar la incidencia que se va a editar
        $incidencia = Incidencia::findOrFail($id);

        // Pasar la incidencia a la vista de edición
        return view('incidencias.edit', compact('incidencia'));
    }

    /**
     * Actualiza una incidencia existente en la base de datos.
     * PUT /incidencias/{id}
     */
    public function update(Request $request, $id)
    {
        // Validar los datos enviados desde el formulario
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
            'categoria' => 'required|string',
            'prioridad' => 'required|string',
            'usuario_id' => 'required|exists:usuarios,id_usuario', // Validar que el usuario existe
        ]);

        // Buscar la incidencia a actualizar
        $incidencia = Incidencia::findOrFail($id);

        // Actualizar los datos de la incidencia
        $incidencia->update($validated);

        // Redirigir al listado con un mensaje de éxito
        return redirect()->route('incidencias.index')->with('success', 'Incidencia actualizada exitosamente.');
    }

    /**
     * Elimina una incidencia de la base de datos.
     * DELETE /incidencias/{id}
     */
    public function destroy($id)
    {
        // Buscar la incidencia a eliminar
        $incidencia = Incidencia::findOrFail($id);

        // Eliminar la incidencia de la base de datos
        $incidencia->delete();

        // Redirigir al listado con un mensaje de éxito
        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada exitosamente.');
    }
}
