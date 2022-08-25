<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRbulansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_rbulans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_mn')->unsigned();
            $table->string('jan', 11)->nullable();
            $table->string('feb', 11)->nullable();
            $table->string('mar', 11)->nullable();
            $table->string('apr', 11)->nullable();
            $table->string('mei', 11)->nullable();
            $table->string('jun', 11)->nullable();
            $table->string('jul', 11)->nullable();
            $table->string('agus', 11)->nullable();
            $table->string('sep', 11)->nullable();
            $table->string('okt', 11)->nullable();
            $table->string('nov', 11)->nullable();
            $table->string('des', 11)->nullable();
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
        Schema::dropIfExists('t_rbulans');
    }
}
