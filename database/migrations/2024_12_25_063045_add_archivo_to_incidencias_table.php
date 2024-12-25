<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->string('archivo')->nullable()->after('prioridad'); // Añade la columna archivo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->dropColumn('archivo');
        });
    }
};
