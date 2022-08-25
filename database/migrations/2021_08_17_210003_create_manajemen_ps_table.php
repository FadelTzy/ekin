<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManajemenPsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manajemen_ps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_peg')->unsigned();
            $table->string('pp')->nullable();
            $table->string('ppt')->nullable();
            $table->string('appt')->nullable();
            $table->string('status')->nullable();
            $table->string('ket')->nullable();
            $table->string('unit')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('pangkat')->nullable();
            $table->enum('status_target', ['1', '2', '3', '0'])->nullable();
            $table->integer('id_ped')->nullable();
            $table->integer('id_jab')->nullable();
            $table->string('nilai_remun', 8)->nullable();
            $table->string('nilai_skp', 10)->nullable();
            $table->integer('adendum')->nullable();
            $table->text('ket_adendum')->nullable();
            $table->integer('nilai_kerja')->nullable();
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
        Schema::dropIfExists('manajemen_ps');
    }
}
