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
        Schema::create('rpp_archivo_solicituds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rpp_archivo_id')->references('id')->on('rpp_archivos')->onDelete('cascade');
            $table->foreignId('solicitud_id')->constrained()->onDelete('cascade');
            $table->string('asignado_a')->nullable();
            $table->foreignId('surtidor')->nullable()->references('id')->on('users');
            $table->foreignId('entregado_por')->nullable()->references('id')->on('users');
            $table->timestamp('entregado_en')->nullable();
            $table->foreignId('recibido_por')->nullable()->references('id')->on('users');
            $table->timestamp('regresado_en')->nullable();
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
        Schema::dropIfExists('rpp_archivo_solicitud');
    }
};
