<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IncidenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Para cada usuario, crea entre 1 y 5 incidencias
        \App\Models\Usuario::all()->each(function ($usuario) {
            \App\Models\Incidencia::factory(rand(1, 5))->create([
                'usuario_id' => $usuario->id_usuario, // Relación con la clave primaria del usuario
            ]);
        });
    }
}
