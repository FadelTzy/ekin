<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTTahunpegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_tahunpegawais', function (Blueprint $table) {
            $table->id();
            $table->integer('id_peg');
            $table->integer('id_semester_1')->nullable();
            $table->integer('id_semester_2')->nullable();
            $table->string('tahun');
            $table->string('nilai');
            $table->string('status_1');
            $table->string('status_2');
            $table->string('predikat', 15)->nullable();
            $table->string('tanggalnilai', 20)->nullable();
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
        Schema::dropIfExists('t_tahunpegawais');
    }
}
