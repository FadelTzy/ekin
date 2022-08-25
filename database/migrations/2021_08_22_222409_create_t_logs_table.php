<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_mn')->unsigned();
            $table->bigInteger('id_target')->unsigned();
            $table->date('tanggal')->nullable();
            $table->string('bulan')->nullable();
            $table->text('ket')->nullable();
            $table->string('kuantitas')->nullable();
            $table->string('satuan')->nullable();
            $table->string('gambar', 128)->nullable();
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
        Schema::dropIfExists('t_logs');
    }
}
