<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaProcedimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulta_procedimento', function (Blueprint $table) {
            $table->unsignedInteger('cons_proc_codigo')->autoIncrement();
            $table->unsignedInteger('proc_codigo');
            $table->unsignedInteger('cons_codigo');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->foreign('proc_codigo')->references('proc_codigo')->on('procedimentos');
            $table->foreign('cons_codigo')->references('cons_codigo')->on('consultas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consulta_procedimento');
    }
}
