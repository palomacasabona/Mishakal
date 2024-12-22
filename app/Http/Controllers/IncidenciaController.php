<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class IncidenciaController extends Controller
{
    /**
     * Muestra una lista de todas las incidencias.
     * GET /incidencias
     */
    public function index(Request $request)
    {
        // Inicializamos la consulta base
        $query = Incidencia::query();

        // Aplicamos el filtro de búsqueda si el campo 'search' tiene algún valor
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('id_incidencia', 'LIKE', "%{$search}%")
                ->orWhere('titulo', 'LIKE', "%{$search}%");
        }

        // Ordenamos las incidencias y aplicamos la paginación
        $incidencias = $query->orderBy('fecha_creacion', 'desc')->paginate(14);

        // Retornamos la vista con los datos necesarios
        return view('incidencias.index', [
            'incidencias' => $incidencias,
            'search' => $request->input('search'), // Por si necesitas mostrar el valor actual del input en la vista
        ]);
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
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string',
            'prioridad' => 'required|string', // Valida el campo prioridad
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $incidencia = new Incidencia();
        $incidencia->titulo = $validatedData['titulo'];
        $incidencia->descripcion = $validatedData['descripcion'];
        $incidencia->usuario_id = auth()->id(); // Asocia la incidencia con el usuario autenticado
        $incidencia->prioridad = $validatedData['prioridad'];
        $incidencia->categoria = $validatedData['categoria'];
        $incidencia->save();

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $ruta = $archivo->store('archivos', 'public');

            Archivo::create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta_archivo' => $ruta,
                'incidencia_id' => $incidencia->id,
            ]);
        }

        return redirect()->route('perfil')->with('success', 'Incidencia registrada correctamente.');
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

    public function dashboard()
    {
        $userId = auth()->id(); // ID del usuario autenticado

        // Obtener estadísticas
        $totalIncidencias = Incidencia::where('usuario_id', $userId)->count();
        $incidenciasAbiertas = Incidencia::where('usuario_id', $userId)->where('estado', 'abierta')->count();
        $incidenciasCerradas = Incidencia::where('usuario_id', $userId)->where('estado', 'cerrada')->count();

        // Obtener listado de incidencias
        $incidencias = Incidencia::where('usuario_id', $userId)->get();

        // Retornar la vista con las variables
        return view('perfil', [
            'totalIncidencias' => $totalIncidencias,
            'incidenciasAbiertas' => $incidenciasAbiertas,
            'incidenciasCerradas' => $incidenciasCerradas,
            'incidencias' => $incidencias
        ]);
    }


}


