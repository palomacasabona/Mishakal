<?php

// Importamos los controladores necesarios
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

//////////////////////////
// RUTA TEST CACHE
//////////////////////////
Route::get('/cache-test', function () {
    $value = Cache::get('prueba');
    return $value ? "El valor de la caché es: $value" : "No se encontró el valor en la caché.";
})->name('cache.test');

//////////////////////////
// RUTAS LOGIN / REGISTER
//////////////////////////
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//////////////////////////
// INCIDENCIAS - PÚBLICAS
//////////////////////////
Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');

//////////////////////////
// INCIDENCIAS - PRIVADAS
//////////////////////////
Route::middleware(['auth'])->group(function () {
    Route::post('/incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store');
    Route::get('/incidencias/{id_incidencia}', [IncidenciaController::class, 'show'])->name('incidencias.show');
});

//////////////////////////
// PERFIL Y USUARIOS
//////////////////////////
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');
    Route::get('/perfil/editar', [UsuarioController::class, 'edit'])->name('perfil.editar');
    Route::put('/perfil/{id}', [UsuarioController::class, 'update'])->name('usuario.update');
    Route::resource('usuarios', UsuarioController::class);
});

//////////////////////////
// CRUD Comentarios / Archivos / Mensajes
//////////////////////////
Route::middleware(['auth'])->group(function () {
    Route::resource('comentarios', ComentarioController::class);
    Route::resource('archivos', ArchivoController::class);
    Route::resource('mensajes', MensajeController::class);
});

//////////////////////////
// DASHBOARD (OPCIONAL)
//////////////////////////
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [IncidenciaController::class, 'dashboard'])->name('dashboard');
});

//////////////////////////
// MODAL - No mostrar otra vez
//////////////////////////
Route::post('/no-mostrar-modal', function () {
    session(['ocultar_modal' => true]);
    return redirect()->back();
})->name('noMostrarModal');

//////////////////////////
// USUARIOS LISTADO + DETALLE
//////////////////////////
Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
});

// Doble definición de noMostrarModal pero sin middleware auth
Route::post('/noMostrarModal', [UsuarioController::class, 'noMostrarModal'])->name('noMostrarModal')->withoutMiddleware('auth');

// Doble definición de usuarios.show
Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');

//////////////////////////
// GUARDAR MENSAJES
//////////////////////////
Route::post('/mensajes', [MensajeController::class, 'store'])->name('mensajes.store');

//////////////////////////
// AUTOASIGNAR INCIDENCIA
//////////////////////////
Route::post('/incidencias/{id}/autoasignar', [IncidenciaController::class, 'autoasignar'])->name('incidencias.autoasignar');
