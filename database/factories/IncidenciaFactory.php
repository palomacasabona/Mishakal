<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incidencia>
 */
class IncidenciaFactory extends Factory
{
    protected $model = \App\Models\Incidencia::class;

    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence, // Título de la incidencia
            'descripcion' => $this->faker->paragraph, // Descripción
            'estado' => $this->faker->randomElement(['abierta', 'en proceso', 'cerrada']), // Estado aleatorio
            'categoria' => $this->faker->randomElement(['Hardware', 'Software', 'Redes', 'Correo electrónico', 'Accesos', 'Seguridad', 'Otros']), // Categoría
            'prioridad' => $this->faker->randomElement(['alta', 'media', 'baja']), // Prioridad
            'fecha_creacion' => now(), // Fecha actual
            'usuario_id' => \App\Models\Usuario::factory(), // Relación con Usuario
        ];
    }
}
