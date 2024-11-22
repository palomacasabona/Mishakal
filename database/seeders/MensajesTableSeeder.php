<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MensajesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $usuarios = \App\Models\Usuario::pluck('id_usuario')->toArray();
        $incidencias = \App\Models\Incidencia::pluck('id_incidencia')->toArray();

        foreach (range(1, 50) as $index) {
            \App\Models\Mensaje::create([
                'contenido' => fake()->sentence,
                'incidencia_id' => fake()->randomElement($incidencias),
                'remitente_id' => fake()->randomElement($usuarios),
                'destinatario_id' => fake()->randomElement($usuarios),
                'fecha_envio' => now(),
            ]);
        }
    }

}
