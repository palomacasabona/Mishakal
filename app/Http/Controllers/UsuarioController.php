<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Incidencia;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function perfil()
    {
        // Recuperar las incidencias del usuario autenticado con la relación 'archivo'
        $incidencias = Incidencia::with('archivo')->where('usuario_id', auth()->id())->get();        // Contar incidencias totales, abiertas y cerradas
        $totalIncidencias = $incidencias->count();
        $incidenciasAbiertas = $incidencias->where('estado', 'en proceso')->count();
        $incidenciasCerradas = $incidencias->where('estado', 'cerrada')->count();

        // Calcular el porcentaje de incidencias abiertas
        $porcentajeAbiertas = $totalIncidencias > 0
            ? round(($incidenciasAbiertas / $totalIncidencias) * 100, 2)
            : 0;

        // Retornar la vista con todos los datos necesarios
        return view('perfil', compact(
            'incidencias',
            'totalIncidencias',
            'incidenciasAbiertas',
            'incidenciasCerradas',
            'porcentajeAbiertas'
        ));
    }

    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'contraseña' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[@$!%*?&#]/',
                'confirmed',
            ],
        ]);

        Usuario::create([
            'nombre' => $validatedData['nombre'],
            'email' => $validatedData['email'],
            'contraseña' => bcrypt($validatedData['contraseña']),
            'rol' => 'user',
        ]);

        return redirect()->route('incidencias.index')->with('success', 'Usuario registrado exitosamente.');
    }

    public function edit()
    {
        $usuario = auth()->user(); // Obtén el usuario autenticado
        return view('perfil.editar', compact('usuario')); // Retorna una vista con los datos del usuario
    }

    public function update(Request $request, $id)
    {
        // Validar los datos enviados en el formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Buscar al usuario por ID
        $usuario = Usuario::findOrFail($id);

        // Actualizar los datos del usuario
        $usuario->nombre = $validatedData['nombre'];
        $usuario->apellido = $validatedData['apellido'] ?? $usuario->apellido;
        $usuario->telefono = $validatedData['telefono'] ?? $usuario->telefono;

        // Verificar si se ha subido una foto
        if ($request->hasFile('foto')) {
            // Eliminar la foto anterior si existe
            if ($usuario->foto_perfil && Storage::exists('public/' . $usuario->foto_perfil)) {
                Storage::delete('public/' . $usuario->foto_perfil);
            }

            // Guardar la nueva foto en el almacenamiento público
            $path = $request->file('foto')->store('fotos_perfil', 'public');
            $usuario->foto_perfil = $path;
        }

        // Guardar los cambios en la base de datos
        $usuario->save();

        // Redirigir al perfil con un mensaje de éxito
        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
