<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function login(Request $request)

    {
        dd("hola");
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('incidencias.index'); // Redirige a una ruta existente
        }
        //dd("hola");

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ]);
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => [
                'required',
                'string',
                'min:8', // Mínimo 8 caracteres
                'regex:/[A-Z]/', // Al menos una mayúscula
                'regex:/[@$!%*?&#]/', // Al menos un carácter especial
                'confirmed',
            ],
        ]);


        Usuario::create([
            'nombre' => $request->name,
            'email' => $request->email,
            'contraseña' => bcrypt($request->password), // Cambiar a 'password' si es necesario
            'rol' => 'user',
        ]);


        return redirect()->route('incidencias.index')->with('success', 'Registro exitoso, ahora puedes iniciar sesión.');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function hola(){
        dd("hola");
    }
}
