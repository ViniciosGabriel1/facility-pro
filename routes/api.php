<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login',[AuthController::class,'login']);
Route::post('/cadastro',[AuthController::class,'cadastro']);


Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('clinicas', ClinicasController::class)->except('create','edit');

    Route::apiResource('dentistas', \App\Http\Controllers\DentistasController::class);
    Route::apiResource('pacientes', \App\Http\Controllers\PacientesController::class);
    Route::apiResource('servicos', \App\Http\Controllers\ServicosController::class);
});




