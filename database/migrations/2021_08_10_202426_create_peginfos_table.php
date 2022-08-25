<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeginfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peginfos', function (Blueprint $table) {
            $table->id();
            $table->string('id_peg');
            $table->string('nama')->nullable();
            $table->string('id_atasan')->nullable();
            $table->string('id_ppa')->nullable();
            $table->string('id_bawahan')->nullable();
            $table->string('durasi')->nullable();
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
        Schema::dropIfExists('peginfos');
    }
}
