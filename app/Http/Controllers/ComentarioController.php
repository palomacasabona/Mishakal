<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ComentarioController extends Controller
{
    /**
     * Muestra una lista de todos los comentarios.
     */
    public function index()
    {
        // Obtiene todos los comentarios de la base de datos
        $comentarios = Comentario::all();
        // Retorna la vista 'comentarios.index' con los datos de los comentarios
        return view('comentarios.index', compact('comentarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo comentario.
     */
    public function create()
    {
        // Retorna la vista 'comentarios.create' para mostrar el formulario
        return view('comentarios.create');
    }

    /**
     * Almacena un nuevo comentario en la base de datos.
     */
    public function store(Request $request)
    {
        // Valida los datos recibidos del formulario
        $validated = $request->validate([
            'contenido' => 'required|string|max:1000', // Contenido es obligatorio y no mayor a 1000 caracteres
            'usuario_id' => 'required|exists:usuarios,id_usuario', // ID del usuario debe existir en la tabla usuarios
            'incidencia_id' => 'required|exists:incidencias,id_incidencia', // ID de la incidencia debe existir en la tabla incidencias
        ]);

        // Crea el nuevo comentario en la base de datos
        Comentario::create($validated);

        // Redirige a la lista de comentarios con un mensaje de éxito
        return redirect()->route('comentarios.index')->with('success', 'Comentario creado exitosamente.');
    }

    /**
     * Muestra los detalles de un comentario específico.
     */
    public function show($id)
    {
        // Busca el comentario por su ID, si no existe lanza un error 404
        $comentario = Comentario::findOrFail($id);

        // Retorna la vista 'comentarios.show' con los datos del comentario
        return view('comentarios.show', compact('comentario'));
    }

    /**
     * Muestra el formulario para editar un comentario existente.
     */
    public function edit($id)
    {
        // Busca el comentario por su ID
        $comentario = Comentario::findOrFail($id);

        // Retorna la vista 'comentarios.edit' con los datos del comentario
        return view('comentarios.edit', compact('comentario'));
    }

    /**
     * Actualiza un comentario existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Valida los datos recibidos del formulario
        $validated = $request->validate([
            'contenido' => 'required|string|max:1000', // Contenido es obligatorio y no mayor a 1000 caracteres
            'usuario_id' => 'required|exists:usuarios,id_usuario', // ID del usuario debe existir en la tabla usuarios
            'incidencia_id' => 'required|exists:incidencias,id_incidencia', // ID de la incidencia debe existir en la tabla incidencias
        ]);

        // Busca el comentario por su ID
        $comentario = Comentario::findOrFail($id);

        // Actualiza los datos del comentario en la base de datos
        $comentario->update($validated);

        // Redirige a la lista de comentarios con un mensaje de éxito
        return redirect()->route('comentarios.index')->with('success', 'Comentario actualizado exitosamente.');
    }

    /**
     * Elimina un comentario de la base de datos.
     */
    public function destroy($id)
    {
        // Busca el comentario por su ID
        $comentario = Comentario::findOrFail($id);

        // Elimina el comentario de la base de datos
        $comentario->delete();

        // Redirige a la lista de comentarios con un mensaje de éxito
        return redirect()->route('comentarios.index')->with('success', 'Comentario eliminado exitosamente.');
    }
}
