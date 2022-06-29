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

});