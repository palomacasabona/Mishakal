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
            $table->string('estado')->default('en proceso')->change();
        });
    }

    public function down()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->string('estado')->default(null)->change();
        });
    }
};
