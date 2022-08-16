<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catastro_archivo_solicitud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catastro_archivo_id')->references('id')->on('catastro_archivos');
            $table->foreignId('solicitud_id')->references('id')->on('solicituds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catastro_archivo_solicitud');
    }
};
