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
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id('id_incidencia'); // ID de la incidencia
            $table->string('titulo'); // Título de la incidencia
            $table->text('descripcion'); // Descripción de la incidencia
            $table->string('estado')->default('en proceso');
            $table->string('categoria'); // Categoría de la incidencia
            $table->string('prioridad'); // Prioridad de la incidencia
            $table->timestamp('fecha_creacion'); // Fecha de creación
            $table->foreignId('usuario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->timestamps(); // created_at y updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
