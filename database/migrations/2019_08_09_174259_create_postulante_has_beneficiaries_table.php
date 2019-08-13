<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulanteHasBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulante_has_beneficiaries', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('postulante_id')->unsigned();
            $table->bigInteger('miembro_id')->unsigned();
            $table->timestamps();

            $table->foreign('postulante_id')
                ->references('id')->on('postulantes');
            $table->foreign('miembro_id')
                ->references('id')->on('postulantes');
                //->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postulante_has_beneficiaries');
    }
}
