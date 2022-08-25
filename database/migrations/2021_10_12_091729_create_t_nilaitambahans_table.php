<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTNilaitambahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_nilaitambahans', function (Blueprint $table) {
            $table->id();
            $table->string('id_mn', 6);
            $table->enum('status_t', ['0', '1', '2', '3']);
            $table->enum('status_k', ['0', '1', '2', '3'])->nullable();
            $table->string('nt', 10)->nullable();
            $table->string('ket_nt')->nullable();
            $table->string('nk', 10)->nullable();
            $table->string('ket_nk')->nullable();
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
        Schema::dropIfExists('t_nilaitambahans');
    }
}
