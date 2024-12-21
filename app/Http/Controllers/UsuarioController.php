<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Mostrar lista de usuarios.
     */
    public function index()
    {
        $usuarios = Usuario::all(); // Obtener todos los usuarios
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Mostrar el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Almacenar un usuario recién registrado.
     */
    public function store(Request $request)
    {
        // Escuchar y registrar consultas SQL
        DB::listen(function ($query) {
            logger($query->sql, $query->bindings, $query->time);
        });

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'contraseña' => [
                'required',
                'string',
                'min:8', // Mínimo 8 caracteres
                'regex:/[A-Z]/', // Al menos una mayúscula
                'regex:/[a-z]/', // Al menos una minúscula
                'regex:/[@$!%*?&#]/', // Al menos un símbolo
                'confirmed',
            ],
        ]);

        // Crear el usuario
        Usuario::create([
            'nombre' => $validatedData['nombre'],
            'email' => $validatedData['email'],
            'contraseña' => bcrypt($validatedData['contraseña']),
            'rol' => 'user', // Asignar el rol "user" por defecto
        ]);

        // Redirigir después del registro
        return redirect()->route('incidencias.index')->with('success', 'Usuario registrado exitosamente.');
    }

    /**
     * Mostrar los detalles de un usuario específico.
     */
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id); // Buscar usuario por ID
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Mostrar el formulario para editar un usuario.
     */
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id); // Buscar usuario
        $roles = Usuario::getRoles(); // Obtener roles disponibles
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar información de un usuario (incluyendo rol).
     */
    public function update(Request $request, $id)
    {
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048', // Validar que la imagen sea válida
        ]);

        // Encuentra al usuario por su ID
        $usuario = Usuario::findOrFail($id);

        // Actualiza los datos
        $usuario->nombre = $validatedData['nombre'];
        $usuario->apellido = $validatedData['apellido'] ?? $usuario->apellido;

        // Si se subió una foto, guárdala
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('fotos_perfil', 'public');
            $usuario->foto_perfil = $path;
        }

        $usuario->save();

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete(); // Eliminar usuario
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function perfil()
    {
        // Obtenemos las incidencias del usuario autenticado
        $incidencias = Incidencia::with('archivos')->where('usuario_id', auth()->id())->get();

        // Contadores para el dashboard
        $totalIncidencias = $incidencias->count();
        $incidenciasAbiertas = $incidencias->where('estado', 'abierta')->count();
        $incidenciasCerradas = $incidencias->where('estado', 'cerrada')->count();

        // Pasamos las variables a la vista
        return view('perfil', compact('incidencias', 'totalIncidencias', 'incidenciasAbiertas', 'incidenciasCerradas'));
    }
}
