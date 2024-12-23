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
})->name('cache.test');

// Ruta para el índice de incidencias
Route::get('/incidencias', [IncidenciaController::class, 'index'])
    ->name('incidencias.index');

// ** Rutas de autenticación **
// Formulario de login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Procesar login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Formulario de registro
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// Procesar registro
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta para vista auth (ejemplo simple)
Route::get('/auth', function () {
    return view('auth');
})->name('auth.view');

// Ruta para login desde el auth view
Route::post('/auth', [AuthController::class, 'login'])->name('auth.post');

// ** Rutas relacionadas con el usuario **
// CRUD para usuarios
Route::resource('usuarios', UsuarioController::class)->middleware('auth');

// Ruta para mostrar el perfil de usuario (dashboard)
Route::get('/perfil', [UsuarioController::class, 'perfil'])
    ->middleware('auth')
    ->name('perfil');

// Ruta para actualizar el perfil del usuario
Route::put('/usuario/{id}', [UsuarioController::class, 'update'])
    ->middleware('auth')
    ->name('usuario.update');

// ** Rutas para incidencias **
// Registrar una nueva incidencia
Route::middleware(['auth'])->group(function () {
    Route::post('/incidencias', [IncidenciaController::class, 'store'])
        ->name('incidencias.store');
});

// ** Recursos del menú lateral **
// CRUD para comentarios
Route::resource('comentarios', ComentarioController::class)->middleware('auth');
// CRUD para archivos
Route::resource('archivos', ArchivoController::class)->middleware('auth');
// CRUD para mensajes
Route::resource('mensajes', MensajeController::class)->middleware('auth');

// Middleware de autenticación para garantizar que las rutas protegidas solo estén disponibles para usuarios autenticados
Route::middleware(['auth'])->group(function () {
    // Ejemplo de dashboard (si lo necesitas)
    Route::get('/dashboard', [IncidenciaController::class, 'userDashboard'])->name('dashboard');
});

// ** Comentarios importantes **
// - `auth` middleware garantiza que solo usuarios autenticados puedan acceder a las rutas.
// - He organizado las rutas por secciones: autenticación, usuario, incidencias, etc.
// - Utiliza `resource` para rutas CRUD completas donde aplique, simplificando la definición de las rutas.

Route::get('/auth', function () {
    return view('auth');
})->name('auth');
