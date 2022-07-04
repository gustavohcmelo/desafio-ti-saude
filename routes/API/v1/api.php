<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function(){
    Route::post('login', [App\Http\Controllers\API\v1\AuthController::class, 'login']);
    Route::post('register', [App\Http\Controllers\API\v1\AuthController::class, 'register']);
    Route::post('logout', [App\Http\Controllers\API\v1\AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [App\Http\Controllers\API\v1\AuthController::class, 'refresh'])->middleware('auth:api');
});

Route::middleware('auth:api')->group(function(){

    /* Routes CRUD to Medico Model */
    Route::resource('medicos', \App\Http\Controllers\API\v1\MedicoController::class);

    /* Routes CRUD to Paciente Model */
    Route::resource('pacientes', \App\Http\Controllers\API\v1\PacienteController::class);

    /* Routes CRUD to Plano Model */
    Route::resource('planos', \App\Http\Controllers\API\v1\PlanoController::class);

    /* Routes CRUD to Consulta Model */
    Route::resource('consultas', \App\Http\Controllers\API\v1\ConsultaController::class);

    /* Routes CRUD to Procedimento Model */
    Route::resource('procedimentos', \App\Http\Controllers\API\v1\ProcedimentoController::class);
    
    /* Routes CRUD to Telefone Model */
    Route::resource('telefones', \App\Http\Controllers\API\v1\TelefoneController::class);

    /* Routes CRUD to Especialidades Model */
    Route::resource('especialidades', \App\Http\Controllers\API\v1\EspecialidadeController::class);

    /* Routes CRUD to Paciente_plano Model */
    Route::resource('paciente-plano', \App\Http\Controllers\API\v1\PacientePlanoController::class);

    /* Routes CRUD to Consulta_procedimento Model */
    Route::resource('consulta-procedimento', \App\Http\Controllers\API\v1\ConsultaProcedimentoController::class);

});
