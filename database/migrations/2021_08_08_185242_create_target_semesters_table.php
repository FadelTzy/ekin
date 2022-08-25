<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_semesters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ped')->unsigned()->nullable();
            $table->string('bulan', 128)->nullable();
            $table->integer('tkuantitas')->nullable();
            $table->string('satuan')->nullable();
            $table->string('tkualitas')->default('100');
            $table->string('twaktu')->nullable();
            $table->string('tbiaya')->nullable();
            $table->text('ket')->nullable();
            $table->string('kegiatan')->nullable();
            $table->string('id_tup', 19)->nullable();
            $table->integer('rkuantitas')->nullable();
            $table->integer('rkualitas')->nullable();
            $table->integer('rwaktu')->nullable();
            $table->enum('status', ['0', '1', '2'])->nullable();
            $table->string('nilai_mutu', 128)->nullable();
            $table->integer('nilai_atasan')->nullable();
            $table->integer('nilai_capaian')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('status_adendum', ['0', '1', '2', '3'])->nullable();


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
        Schema::dropIfExists('target_semesters');
    }
}
