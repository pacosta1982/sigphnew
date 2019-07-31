<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulantesDocumentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulantes_documentations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('postulante_id')->unsigned();
            $table->foreign('postulante_id')->references('id')->on('postulantes')->onDelete('cascade');
            $table->bigInteger('document_id')->unsigned();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->string('title');
            $table->string('file_path');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postulantes_documentations');
    }
}
