<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKinerjaUtamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinerja_utamas', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai')->nullable();
            $table->string('manajemen_ps')->nullable();
            $table->string('id_periode')->nullable();
            $table->text('rencana')->nullable();
            $table->string('status')->nullable();
            $table->string('ket')->nullable();
            $table->string('nilai1')->nullable();
            $table->string('nilai2')->nullable();
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
        Schema::dropIfExists('kinerja_utamas');
    }
}
