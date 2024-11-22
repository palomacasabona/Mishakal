<?php

use App\Http\Controllers\IncidenciaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api/incidencias', [IncidenciaController::class, 'index']);
Route::post('/api/incidencias', [IncidenciaController::class, 'store']);
Route::put('/api/incidencias/{id}', [IncidenciaController::class, 'update']);
Route::delete('/api/incidencias/{id}', [IncidenciaController::class, 'destroy']);
