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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id('id_comentario'); // ID del comentario
            $table->text('contenido'); // Contenido del comentario
            $table->timestamp('fecha_comentario'); // Fecha del comentario
            $table->unsignedBigInteger('usuario_id')->nullable(); // Relación con Usuarios
            $table->unsignedBigInteger('incidencia_id')->nullable(); // Relación con Incidencias
            $table->timestamps(); // Campos created_at y updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
