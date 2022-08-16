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
        Schema::create('catastro_archivos', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->string('tomo')->nullable();
            $table->unsignedInteger('localidad');
            $table->unsignedInteger('oficina');
            $table->unsignedInteger('tipo');
            $table->unsignedInteger('registro');
            $table->unsignedInteger('folio');
            $table->boolean('tarjeta');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
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
        Schema::dropIfExists('catastro_archivos');
    }
};
