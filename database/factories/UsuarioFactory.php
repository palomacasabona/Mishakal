<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'contraseña' => bcrypt('password'), // Contraseña encriptada
            'telefono' => $this->faker->phoneNumber,
            'foto_perfil' => null, // Puedes usar $this->faker->imageUrl() para una URL falsa
            'rol' => $this->faker->randomElement(['user', 'admin']),
            'fecha_registro' => now(),
        ];
    }
}
