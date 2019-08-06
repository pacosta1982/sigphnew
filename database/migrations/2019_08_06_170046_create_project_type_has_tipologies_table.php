<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTypeHasTipologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_type_has_typologies', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('project_type_id')->unsigned();
            $table->foreign('project_type_id')->references('id')->on('project_type')->onDelete('cascade');
            $table->integer('typology_id')->unsigned();
            $table->foreign('typology_id')->references('id')->on('typologies')->onDelete('cascade');
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
        Schema::dropIfExists('project_type_has_tipologies');
    }
}
