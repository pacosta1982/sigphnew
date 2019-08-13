<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentescoIdToPostulantesHasNeneficiaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postulante_has_beneficiaries', function (Blueprint $table) {
            //
            $table->integer('parentesco_id')->unsigned();
            $table->foreign('parentesco_id')->references('id')->on('parentesco')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postulante_has_beneficiaries', function (Blueprint $table) {
            //
            $table->dropColumn('parentesco_id');
        });
    }
}
