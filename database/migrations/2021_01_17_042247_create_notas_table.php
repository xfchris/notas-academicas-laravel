<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->integer('estudiante_id')->unsigned();
            $table->integer('evaluacion_id')->unsigned();
            $table->double('calificacion')->unsigned();
        });

        Schema::table('notas', function($table) {
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones');        
            $table->primary(['estudiante_id', 'evaluacion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas');
    }
}
