<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Incidencia;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra el perfil del usuario autenticado.
     */
    public function perfil()
    {
        $usuario = auth()->user(); // Obtiene el usuario actualmente autenticado.
        $incidencias = Incidencia::with('archivo')->where('usuario_id', auth()->id())->get(); // Obtiene todas las incidencias creadas por el usuario.

        // Contar incidencias totales y clasificarlas por estado
        $totalIncidencias = $incidencias->count();
        $incidenciasAbiertas = $incidencias->where('estado', 'abierta')->count();
        $incidenciasEnProceso = $incidencias->where('estado', 'en proceso')->count();
        $incidenciasCerradas = $incidencias->where('estado', 'cerrada')->count();

        // Calcular porcentajes de incidencias por estado
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

        //dd($incidenciasPorCategoria->toArray());
        // Retornar la vista con todos los datos necesarios
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

    /**
     * Lista todos los usuarios registrados.
     */
    public function index()
    {
        $usuarios = Usuario::all(); // Obtiene todos los usuarios.
        return view('usuarios', compact('usuarios')); // Muestra una vista con la lista de usuarios.
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('usuarios.create'); // Retorna la vista para registrar un usuario.
    }

    /**
     * Muestra el perfil de un usuario específico.
     */
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id); // Busca al usuario por su ID o lanza un error si no existe.
        return view('usuarios.show', compact('usuario')); // Retorna la vista con los datos del usuario.
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email', // El correo debe ser único.
            'contraseña' => [
                'required',
                'string',
                'min:8', // Al menos 8 caracteres.
                'regex:/[A-Z]/', // Al menos una mayúscula.
                'regex:/[a-z]/', // Al menos una minúscula.
                'regex:/[@$!%*?&#]/', // Al menos un carácter especial.
                'confirmed', // La contraseña debe coincidir con su confirmación.
            ],
        ]);

        // Crear el usuario en la base de datos
        Usuario::create([
            'nombre' => $validatedData['nombre'],
            'email' => $validatedData['email'],
            'contraseña' => bcrypt($validatedData['contraseña']), // Encripta la contraseña.
            'rol' => 'user', // Asigna el rol de usuario por defecto.
        ]);

        // Redirige con un mensaje de éxito
        return redirect()->route('incidencias.index')->with('success', 'Usuario registrado exitosamente.');
    }

    /**
     * Muestra el formulario para editar el perfil del usuario autenticado.
     */
    public function edit()
    {
        $usuario = auth()->user(); // Obtiene el usuario autenticado.
        return view('perfil.editar', compact('usuario')); // Retorna la vista para editar el perfil.
    }

    /**
     * Actualiza los datos del usuario en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'foto' => 'nullable|image|max:2048', // Valida que sea una imagen válida.
        ]);

        $usuario = Usuario::findOrFail($id); // Busca al usuario por su ID.

        // Actualiza los datos del usuario.
        $usuario->nombre = $validatedData['nombre'];
        $usuario->apellido = $validatedData['apellido'] ?? $usuario->apellido;
        $usuario->telefono = $validatedData['telefono'] ?? $usuario->telefono;

        // Verifica si se subió una foto.
        if ($request->hasFile('foto')) {
            // Elimina la foto anterior si existe.
            if ($usuario->foto_perfil && Storage::exists('public/' . $usuario->foto_perfil)) {
                Storage::delete('public/' . $usuario->foto_perfil);
            }

            // Guarda la nueva foto.
            $path = $request->file('foto')->store('fotos', 'public');
            $usuario->foto_perfil = $path;
        }

        $usuario->save(); // Guarda los cambios en la base de datos.

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id); // Busca al usuario por su ID.
        $usuario->delete(); // Elimina al usuario.
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
    //METODO PARA EL MODAL DE "NO SE PUEDE MODIFICAR INCIDENCIA"
    public function noMostrarModal(Request $request)
    {
        dd("hola");
        session(['ocultar_modal' => true]);

        return response()->json([
            'message' => 'El modal no se mostrará más durante esta sesión.'

        ], 200);

    }
}

