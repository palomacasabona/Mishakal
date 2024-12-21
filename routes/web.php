<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

// Ruta para probar la caché
Route::get('/cache-test', function () {
    $value = Cache::get('prueba');
    return $value ? "El valor de la caché es: $value" : "No se encontró el valor en la caché.";
});

// Ruta para el índice de incidencias
Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');

// Rutas para login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Rutas para registro
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Ruta para logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta para vista auth
Route::get('/auth', function () {
    return view('auth');
})->name('auth');


Route::post('/auth', [AuthController::class,
    'login'])->name('auth');

// Rutas del menú lateral
Route::resource('usuarios', UsuarioController::class);
Route::resource('comentarios', ComentarioController::class);
Route::resource('archivos', ArchivoController::class);
Route::resource('mensajes', MensajeController::class);

//RUTAS DEL USUARIO
//Route::get('/dashboard', [IncidenciaController::class, 'userDashboard'])->middleware('auth')->name('dashboard');

//RUTA PARA VER EL PERFIL DE USUARIO
Route::get('/perfil', [IncidenciaController::class, 'dashboard'])->middleware('auth')->name('perfil');

//RUTA REGISTRO DE INCIDENCIA:

Route::middleware(['auth'])->group(function () {
    Route::post('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');
});

///GUARDAR INCIDENCIA????

Route::post('/incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store');

/// RUTA PERFIL PARA EDITAR PERFIL (FORM)
Route::put('/usuario/{id}', [UsuarioController::class, 'update'])->name('usuario.update');
