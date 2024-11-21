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
        Schema::create('archivos', function (Blueprint $table) {
            $table->id('id_archivo'); // ID del archivo
            $table->string('nombre'); // Nombre del archivo
            $table->string('ruta_archivo'); // Ruta del archivo
            $table->unsignedBigInteger('incidencia_id')->nullable(); // Relación con incidencias
            $table->foreign('incidencia_id')->references('id_incidencia')->on('incidencias')->onDelete('cascade');
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
