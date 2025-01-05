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
        $usuario = auth()->user(); // Usuario autenticado
        $incidencias = Incidencia::with('archivo')->where('usuario_id', auth()->id())->get();

        // Contar incidencias totales y clasificarlas por estado
        $totalIncidencias = $incidencias->count();
        $incidenciasAbiertas = $incidencias->where('estado', 'abierta')->count();
        $incidenciasEnProceso = $incidencias->where('estado', 'en proceso')->count();
        $incidenciasCerradas = $incidencias->where('estado', 'cerrada')->count();

        // Calcular porcentajes de estados
        $porcentajeAbiertas = $totalIncidencias > 0
            ? round(($incidenciasAbiertas / $totalIncidencias) * 100, 2)
            : 0;
        $porcentajeEnProceso = $totalIncidencias > 0
            ? round(($incidenciasEnProceso / $totalIncidencias) * 100, 2)
            : 0;
        $porcentajeCerradas = $totalIncidencias > 0
            ? round(($incidenciasCerradas / $totalIncidencias) * 100, 2)
            : 0;

        // Agrupar incidencias por categoría y calcular porcentajes
        $incidenciasPorCategoria = $incidencias->groupBy('categoria')->map(function ($group) use ($totalIncidencias) {
            $count = $group->count();
            $percentage = $totalIncidencias > 0 ? round(($count / $totalIncidencias) * 100, 2) : 0;
            return [
                'count' => $count,
                'percentage' => $percentage,
            ];
        });

        // Retornar la vista con los datos necesarios
        return view('perfil', compact(
            'usuario',
            'incidencias',
            'totalIncidencias',
            'incidenciasAbiertas',
            'incidenciasEnProceso',
            'incidenciasCerradas',
            'porcentajeAbiertas',
            'porcentajeEnProceso',
            'porcentajeCerradas',
            'incidenciasPorCategoria'
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

        // Depurar antes de verificar si la foto existe


        // Verificar si se ha subido una foto
        if ($request->hasFile('foto')) {
            // Eliminar la foto anterior si existe
            if ($usuario->foto_perfil && Storage::exists('public/' . $usuario->foto_perfil)) {
                Storage::delete('public/' . $usuario->foto_perfil);
            }

            // Guardar la nueva foto en el almacenamiento público
            $path = $request->file('foto')->store('fotos', 'public');
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
