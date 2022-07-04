<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->unsignedInteger('cons_codigo')->autoIncrement();
            $table->unsignedInteger('pac_codigo');
            $table->unsignedInteger('med_codigo');
            $table->date('cons_data');
            $table->time('cons_hora');
            $table->boolean('cons_particular')->default(false); //este paramêtro deve respeitar a regra de negócio estabelecida pela empresa.
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->foreign('pac_codigo')->references('pac_codigo')->on('pacientes');
            $table->foreign('med_codigo')->references('med_codigo')->on('medicos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}
