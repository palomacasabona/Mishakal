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
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Mostrar formulario de login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');  // Procesar login
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register'); // Mostrar formulario de registro
Route::post('/register', [AuthController::class, 'register'])->name('register.post');   // Procesar registro
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  // Cerrar sesión

// ** Rutas públicas para incidencias **
Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index'); // Listar incidencias (sin autenticación)

// ** Rutas protegidas para incidencias **
Route::middleware(['auth'])->group(function () {
    Route::post('/incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store'); // Crear una nueva incidencia
    Route::get('/incidencias/{id_incidencia}', [IncidenciaController::class, 'show'])->name('incidencias.show'); // Mostrar detalles de una incidencia
});

// ** Rutas relacionadas con el usuario **
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil'); // Mostrar perfil de usuario
    Route::get('/perfil/editar', [UsuarioController::class, 'edit'])->name('perfil.editar'); // Mostrar formulario de edición
    Route::put('/perfil/{id}', [UsuarioController::class, 'update'])->name('usuario.update');
    Route::resource('usuarios', UsuarioController::class); // CRUD completo para usuarios
});

// ** Rutas para recursos adicionales (protegidas) **
Route::middleware(['auth'])->group(function () {
    Route::resource('comentarios', ComentarioController::class); // CRUD para comentarios
    Route::resource('archivos', ArchivoController::class); // CRUD para archivos
    Route::resource('mensajes', MensajeController::class); // CRUD para mensajes
});

// ** Dashboard (opcional) **
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [IncidenciaController::class, 'dashboard'])->name('dashboard'); // Dashboard del usuario
});

// ** Ruta para cargar incidencias con sus archivos en el perfil **
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');
});

// ** RUTA MODAL DE AVISO AL GRABAR INCIDENCIA **
Route::post('/no-mostrar-modal', function () {
    session(['ocultar_modal' => true]); // Guarda en la sesión la preferencia
    return redirect()->back(); // Redirige de vuelta a la página anterior
})->name('noMostrarModal');

// ** RUTA PARA VER USUARIOS **
Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
});

//RUTA PARA ****MODAL**** DE SI INFO PARA GRABAR INCIDENCIA NO SE PUEDE MODIFICAR

Route::post('/noMostrarModal', [UsuarioController::class, 'noMostrarModal'])->name('noMostrarModal')->withoutMiddleware('auth');

// RUTA PARA QUE EL ADMIN VEA EL PERFIL DEL USUARIO

Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');

//Ruta para manejar el almacenamiento de mensajes:
Route::post('/mensajes', [MensajeController::class, 'store'])->name('mensajes.store');


//ROUTA PARA INCIDENCIAS PARA VER ASIGNACIÓN
Route::post('/incidencias/{id}/autoasignar', [IncidenciaController::class, 'autoasignar'])->name('incidencias.autoasignar');
