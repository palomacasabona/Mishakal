<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

Route::get('/cache-test', function () {
    $value = Cache::get('prueba');
    return $value ? "El valor de la caché es: $value" : "No se encontró el valor en la caché.";
});


//-----------------------------------------------------------------------------------------
// RUTA PARA EL INDEX INCIDENCIAS
Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');


// RUTAS PARA LOGIN Y REGISTRO (GENERAL)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('inicio');


// Rutas para el form de registro
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//REGISTRO DE UN USUARIO NORMAL :

Route::post('/register', [AuthController::class, 'register'])->name('register');



// Ruta para la vista de autenticación (auth.blade.php)
// Esta ruta devuelve la vista 'auth', que incluye los formularios
// para iniciar sesión y registrarse en una misma página.
// El nombre de la ruta es 'auth', lo que facilita su uso en enlaces
// como {{ route('auth') }} en las vistas.

Route::get('/auth', function () {
    return view('auth');
})->name('auth');




// RUTAS MENU LATERAL
Route::resource('usuarios', UsuarioController::class);
Route::resource('comentarios', ComentarioController::class);
Route::resource('archivos', ArchivoController::class);
Route::resource('mensajes', MensajeController::class);
