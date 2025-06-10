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
        Schema::table('rpp_archivos', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->after('estado');
            $table->boolean('formacion')->default(0)->after('estado');
            $table->string('registro')->nullable()->after('tomo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
