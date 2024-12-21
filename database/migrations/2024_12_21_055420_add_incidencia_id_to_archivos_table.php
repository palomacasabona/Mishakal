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
        Schema::table('archivos', function (Blueprint $table) {
            $table->unsignedBigInteger('incidencia_id')->nullable(); // Añade la columna incidencia_id
            $table->foreign('incidencia_id') // Define la clave foránea
            ->references('id') // Apunta a la columna 'id' de la tabla 'incidencias'
            ->on('incidencias') // Tabla referenciada
            ->onDelete('cascade'); // Elimina los archivos relacionados si se elimina la incidencia
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archivos', function (Blueprint $table) {
            $table->dropForeign(['incidencia_id']); // Elimina la clave foránea
            $table->dropColumn('incidencia_id'); // Elimina la columna
        });
    }
};
