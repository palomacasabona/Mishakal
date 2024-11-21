<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incidencia>
 */
class IncidenciaFactory extends Factory
{
    protected $model = \App\Models\Incidencia::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence,
            'descripcion' => $this->faker->paragraph,
            'estado' => $this->faker->randomElement(['abierta', 'en proceso', 'cerrada']),
            'categoria' => $this->faker->randomElement(['Hardware', 'Software', 'Redes', 'Correo electrónico', 'Accesos', 'Seguridad', 'Otros']),
            'prioridad' => $this->faker->randomElement(['alta', 'media', 'baja']),
            'fecha_creacion' => now(),
            'usuario_id' => \App\Models\Usuario::factory(), // Relación con Usuario
        ];
    }
}
