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
            $table->string('categoria')->default('Otros')->change(); // Cambia 'Otros' según el valor por defecto que prefieras
        });
    }

    public function down()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->string('categoria')->default(null)->change(); // Revierte el valor por defecto
        });
    }
};
