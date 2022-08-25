<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerdtahunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perdtahuns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_peg')->unsigned();
            $table->integer('id_mp');
            $table->string('tahun');
            $table->string('awal');
            $table->string('akhir');
            $table->string('status')->nullable();
            $table->string('ket')->nullable();
            $table->string('s_1')->nullable();
            $table->string('s_2')->nullable();
            $table->string('status_a', 128)->nullable();
            $table->integer('ss_1')->nullable();
            $table->integer('ss_2')->nullable();
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
        Schema::dropIfExists('perdtahuns');
    }
}
