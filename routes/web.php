<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

// ** Ruta para probar la caché **
Route::get('/cache-test', function () {
    $value = Cache::get('prueba');
    return $value ? "El valor de la caché es: $value" : "No se encontró el valor en la caché.";
})->name('cache.test');

// ** Rutas de autenticación **
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Vista de autenticación adicional
Route::get('/auth', function () {
    return view('auth');
})->name('auth.view');

Route::post('/auth', [AuthController::class, 'login'])->name('auth.post');

// ** Rutas relacionadas con el usuario **
Route::middleware(['auth'])->group(function () {
    // Ruta para el perfil del usuario
    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');

    // Actualizar el perfil del usuario
    Route::put('/usuario/{id}', [UsuarioController::class, 'update'])->name('usuario.update');

    // CRUD para usuarios
    Route::resource('usuarios', UsuarioController::class);
});

// ** Rutas para incidencias **
Route::middleware(['auth'])->group(function () {
    // Listar incidencias
    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');

    // Registrar una incidencia
    Route::post('/incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store');
});

// ** Rutas para recursos adicionales **
Route::middleware(['auth'])->group(function () {
    // CRUD para comentarios
    Route::resource('comentarios', ComentarioController::class);

    // CRUD para archivos
    Route::resource('archivos', ArchivoController::class);

    // CRUD para mensajes
    Route::resource('mensajes', MensajeController::class);
});

// ** Dashboard (si es necesario) **
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [IncidenciaController::class, 'userDashboard'])->name('dashboard');
});

// ** Notas importantes **
// - El middleware `auth` protege las rutas privadas.
// - Se usa `Route::resource` para simplificar los CRUD (usuarios, comentarios, archivos, mensajes).
// - Se evita duplicar rutas como `usuario.update` al consolidarlas en un solo lugar.
