<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('id_peg', 50);
            $table->string('nip', 100);
            $table->string('id_jenis_pegawai')->nullable();
            $table->string('jenis_kepegawaian', 20)->nullable();
            $table->string('nama')->nullable();
            $table->string('jabatanRemun')->nullable();
            $table->string('statusJabFungsionalBKD', 100)->nullable();
            $table->string('idUnitRemun')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('golongan', 100)->nullable();
            $table->string('pangkat', 40)->nullable();
            $table->string('foto')->nullable();
            $table->string('unit', 100)->nullable();
            $table->text('password')->nullable();
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
        Schema::dropIfExists('pegawais');
    }
}
