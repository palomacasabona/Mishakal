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
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id('id_mensaje'); // ID del mensaje
            $table->text('contenido'); // Contenido del mensaje
            $table->unsignedBigInteger('incidencia_id'); // Relación con incidencias
            $table->unsignedBigInteger('remitente_id'); // Relación con usuario remitente
            $table->unsignedBigInteger('destinatario_id'); // Relación con usuario destinatario
            $table->timestamp('fecha_envio')->useCurrent(); // Fecha de envío
            $table->foreign('incidencia_id')->references('id_incidencia')->on('incidencias')->onDelete('cascade');
            $table->foreign('remitente_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('destinatario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
