<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPerilakusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_perilakus', function (Blueprint $table) {
            $table->id();
            $table->integer('id_m');
            $table->integer('orientasi_pelayanan')->nullable();
            $table->integer('integritas')->nullable();
            $table->integer('komitmen')->nullable();
            $table->integer('disiplin')->nullable();
            $table->integer('kerjasama')->nullable();
            $table->integer('kepemimpinan')->nullable();
            $table->integer('inisiatif_kerja')->nullable();
            $table->integer('nilaiperilaku')->nullable();
            $table->integer('status')->nullable();
            $table->string('predikat')->nullable();
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
        Schema::dropIfExists('t_perilakus');
    }
}
