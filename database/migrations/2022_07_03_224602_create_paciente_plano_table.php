<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientePlanoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente_plano', function (Blueprint $table) {
            $table->unsignedInteger('pac_plano_codigo')->autoIncrement();
            $table->unsignedInteger('pac_codigo');
            $table->unsignedInteger('plano_codigo');
            $table->string('nr_contrato', 200);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->foreign('pac_codigo')->references('pac_codigo')->on('pacientes');
            $table->foreign('plano_codigo')->references('plano_codigo')->on('planos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paciente_plano');
    }
}
