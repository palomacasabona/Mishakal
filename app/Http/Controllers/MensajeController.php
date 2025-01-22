<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    /**
     * Muestra una lista de todos los mensajes.
     */
    public function index()
    {
        // Obtener todos los mensajes y pasarlos a la vista.
        $mensajes = Mensaje::all();
        return view('mensajes.index', compact('mensajes'));
    }

    /**
     * Muestra el formulario para crear un nuevo mensaje.
     */
    public function create()
    {
        // Retorna una vista con el formulario para crear un nuevo mensaje.
        return view('mensajes.create');
    }

    /**
     * Almacena un nuevo mensaje en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenido' => 'required|string|max:1000',
            'incidencia_id' => 'required|exists:incidencias,id_incidencia',
        ]);

        Mensaje::create([
            'contenido' => $validated['contenido'],
            'incidencia_id' => $validated['incidencia_id'],
            'remitente_id' => auth()->id(),
        ]);

        return redirect()->route('incidencias.show', $validated['incidencia_id'])->with('success', 'Mensaje enviado correctamente.');
    }

    /**
     * Muestra un mensaje específico.
     */
    public function show($id)
    {
        // Buscar el mensaje por ID.
        $mensaje = Mensaje::findOrFail($id);

        // Retornar la vista con el mensaje específico.
        return view('mensajes.show', compact('mensaje'));
    }

    /**
     * Muestra el formulario para editar un mensaje.
     */
    public function edit($id)
    {
        // Buscar el mensaje por ID.
        $mensaje = Mensaje::findOrFail($id);

        // Retornar la vista con el formulario para editar el mensaje.
        return view('mensajes.edit', compact('mensaje'));
    }

    /**
     * Actualiza un mensaje existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario.
        $validated = $request->validate([
            'contenido' => 'required|string|max:1000',
            'remitente_id' => 'required|exists:usuarios,id_usuario',
            'destinatario_id' => 'required|exists:usuarios,id_usuario',
            'incidencia_id' => 'required|exists:incidencias,id_incidencia',
        ]);

        // Buscar el mensaje por ID y actualizarlo.
        $mensaje = Mensaje::findOrFail($id);
        $mensaje->update($validated);

        return redirect()->route('mensajes.index')->with('success', 'Mensaje actualizado exitosamente.');
    }

    /**
     * Elimina un mensaje específico de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el mensaje por ID y eliminarlo.
        $mensaje = Mensaje::findOrFail($id);
        $mensaje->delete();

        return redirect()->route('mensajes.index')->with('success', 'Mensaje eliminado exitosamente.');
    }

    public function remitente()
    {
        return $this->belongsTo(User::class, 'remitente_id');
    }
}
