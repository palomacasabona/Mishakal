<?php

namespace App\Http\Controllers;

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
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'contraseña' => 'nullable|string|min:8',
            'telefono' => 'nullable|string|max:20',
            'rol' => ['required', Rule::in(Usuario::getRoles())],
        ]);

        if ($request->filled('contraseña')) {
            $validated['contraseña'] = bcrypt($validated['contraseña']); // Encriptar nueva contraseña
        }

        $usuario = Usuario::findOrFail($id);
        $usuario->update($validated); // Actualizar usuario
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
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
}
