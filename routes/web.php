<?php

use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Route;

// RUTA PARA EL INDEX INCIDENCIAS

Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');


Route::get('/', function () {
    return view('welcome');

});
Route::get('/api/incidencias', [IncidenciaController::class, 'index']);
Route::post('/api/incidencias', [IncidenciaController::class, 'store']);
Route::put('/api/incidencias/{id}', [IncidenciaController::class, 'update']);
Route::delete('/api/incidencias/{id}', [IncidenciaController::class, 'destroy']);


Route::resource('usuarios', UsuarioController::class);


Route::resource('comentarios', ComentarioController::class);
Route::resource('archivos', ArchivoController::class);
Route::resource('mensajes', MensajeController::class);
