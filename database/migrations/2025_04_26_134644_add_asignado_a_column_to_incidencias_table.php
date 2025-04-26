<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsignadoAColumnToIncidenciasTable extends Migration
{
    public function up()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->unsignedBigInteger('asignado_a')->nullable()->after('usuario_id');
        });
    }

    public function down()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->dropColumn('asignado_a');
        });
    }
}
