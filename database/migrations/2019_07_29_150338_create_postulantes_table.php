<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('cedula');
            $table->string('marital_status');
            $table->string('nacionalidad');
            $table->string('gender');
            $table->dateTime('birthdate');
            $table->string('localidad')->unsigned()->nullable();
            $table->string('asentamiento')->unsigned()->nullable();
            $table->bigInteger('ingreso')->unsigned();
            //$table->integer('ingreso');
            $table->string('address');
            $table->string('grupo');
            $table->string('phone');
            $table->string('mobile');
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
        Schema::dropIfExists('postulantes');
    }
}
