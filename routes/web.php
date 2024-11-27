<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Route;

//-----------------------------------------------------------------------------------------
// RUTA PARA EL INDEX INCIDENCIAS
Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');



// RUTAS PARA LOGIN Y REGISTRO
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rutas para el registro
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);



// Ruta para la vista de autenticación (auth.blade.php)
// Esta ruta devuelve la vista 'auth', que incluye los formularios
// para iniciar sesión y registrarse en una misma página.
// El nombre de la ruta es 'auth', lo que facilita su uso en enlaces
// como {{ route('auth') }} en las vistas.

Route::get('/auth', function () {
    return view('auth');
})->name('auth');


// RUTAS PARA API INCIDENCIAS
Route::get('/api/incidencias', [IncidenciaController::class, 'index']);
Route::post('/api/incidencias', [IncidenciaController::class, 'store']);
Route::put('/api/incidencias/{id}', [IncidenciaController::class, 'update']);
Route::delete('/api/incidencias/{id}', [IncidenciaController::class, 'destroy']);

// RUTAS MENU LATERAL
Route::resource('usuarios', UsuarioController::class);
Route::resource('comentarios', ComentarioController::class);
Route::resource('archivos', ArchivoController::class);
Route::resource('mensajes', MensajeController::class);
