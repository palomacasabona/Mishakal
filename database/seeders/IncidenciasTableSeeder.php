<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Usuario::all()->each(function ($usuario) {
            \App\Models\Incidencia::factory(rand(1, 5))->create(['usuario_id' => $usuario->id_usuario]);
        });    }
}
