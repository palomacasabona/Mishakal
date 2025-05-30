<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario'); // ID del usuario
            $table->string('nombre'); // Nombre del usuario
            $table->string('apellido', 250)->nullable(); // Campo nuevo
            $table->string('email')->unique(); // Email único
            $table->string('contraseña'); // Contraseña del usuario
            $table->string('telefono', 15)->nullable(); // Teléfono (puede ser nulo)
            $table->string('foto_perfil')->nullable(); // Foto de perfil (ruta)
            $table->enum('rol', ['admin', 'superadmin', 'usuario'])->default('usuario'); // Campo nuevo
            $table->timestamp('fecha_registro'); // Fecha de registro
            $table->timestamps(); // created_at y updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
