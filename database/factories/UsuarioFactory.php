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
            'nombre' => $this->faker->firstName, // Nombre
            'apellido' => $this->faker->lastName, // Apellido
            'email' => $this->faker->unique()->safeEmail, // Email único
            'contraseña' => bcrypt('password'), // Contraseña encriptada
            'telefono' => $this->faker->regexify('[0-9]{3}-[0-9]{3}-[0-9]{4}'), // Teléfono con un formato más corto            'foto_perfil' => null, // Puedes usar $this->faker->imageUrl() para una URL falsa
            'rol' => $this->faker->randomElement(['user', 'admin', 'superadmin']), // Rol aleatorio
            'fecha_registro' => now(), // Fecha de registro actual
        ];
    }
}
