<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Incidencia;
use App\Models\Usuario;
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
            $query->where('id', 'LIKE', "%{$search}%")
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
        $incidencia->estado = 'en proceso'; // Estado inicial definido como 'en proceso'
        $incidencia->save();

        // Subir archivo, si corresponde
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $ruta = $archivo->store('archivos', 'public');

            Archivo::create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta_archivo' => $ruta,
                'incidencia_id' => $incidencia->id,
            ]);
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('perfil')->with('success', 'Incidencia registrada correctamente.');
    }
    /**
     * Muestra los detalles de una incidencia específica.
     */
    public function show($id)
    {
        $incidencia = Incidencia::with('archivos')->findOrFail($id);

        return view('incidencias.show', compact('incidencia'));
    }

    /**
     * Actualiza una incidencia existente.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'telefono' => 'nullable|string|max:15',
            'foto' => 'nullable|image|max:2048',
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->nombre = $validatedData['nombre'];
        $usuario->apellido = $validatedData['apellido'] ?? $usuario->apellido;
        $usuario->email = $validatedData['email'];
        $usuario->telefono = $validatedData['telefono'];

        if ($request->hasFile('foto')) {
            if ($usuario->foto_perfil && \Storage::exists('public/' . $usuario->foto_perfil)) {
                \Storage::delete('public/' . $usuario->foto_perfil);
            }

            $path = $request->file('foto')->store('fotos_perfil', 'public');
            $usuario->foto_perfil = $path;
        }

        $usuario->save();

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
