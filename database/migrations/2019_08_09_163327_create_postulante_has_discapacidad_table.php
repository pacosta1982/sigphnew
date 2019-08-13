<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulanteHasDiscapacidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulante_has_discapacidad', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('postulante_id')->unsigned();
            $table->foreign('postulante_id')->references('id')->on('postulantes')->onDelete('cascade');
            $table->integer('discapacidad_id')->unsigned();
            $table->foreign('discapacidad_id')->references('id')->on('discapacidad')->onDelete('cascade');
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
        Schema::dropIfExists('postulante_has_discapacidad');
    }
}
