<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->unsignedBigInteger('respuesta_a_id')->nullable()->after('fecha_envio');
            $table->foreign('respuesta_a_id')->references('id_mensaje')->on('mensajes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->dropForeign(['asignado_a']);
            $table->dropColumn('asignado_a');
        });
    }
};
