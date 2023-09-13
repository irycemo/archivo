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
        Schema::table('solicituds', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->after('ubicacion');
            $table->json('archivos')->nullable()->after('ubicacion');
            $table->string('asignado_a')->nullable()->after('ubicacion');
            $table->boolean('formacion')->default(0)->after('ubicacion');
            $table->foreignId('surtidor')->nullable()->references('id')->on('users')->after('ubicacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicituds', function (Blueprint $table) {
            //
        });
    }
};
