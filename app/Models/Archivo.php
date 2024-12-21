<?php

namespace App\Models;

use Cassandra\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Archivo extends Model
{
    public function up()
    {
        Schema::table('archivos', function (Blueprint $table) {
            $table->unsignedBigInteger('incidencia_id')->nullable();
            $table->foreign('incidencia_id')->references('id')->on('incidencias')->onDelete('cascade');
        });
    }
}
