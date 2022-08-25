<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPeriodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_periodes', function (Blueprint $table) {
            $table->id();
            $table->string('awal', 30);
            $table->string('akhir', 30);
            $table->string('nama_periode');
            $table->string('semester');
            $table->integer('tahun');
            $table->string('status_aktif');
            $table->string('status_bulan');
            $table->string('sa');
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
        Schema::dropIfExists('t_periodes');
    }
}
