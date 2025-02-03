<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Middleware\JWTMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->withoutMiddleware(JWTMiddleware::class);
    Route::get('user', 'user');
    Route::post('logout', 'logout');
});

Route::controller(CidadeController::class)->group(function () {
    Route::get('cidades', 'index')->withoutMiddleware(JWTMiddleware::class);
    Route::get('cidades/{id}/medicos', 'medicos')->withoutMiddleware(JWTMiddleware::class);
});

Route::controller(MedicoController::class)->group(function () {
    Route::get('medicos/{nome?}', 'index')->withoutMiddleware(JWTMiddleware::class);
    Route::post('medicos/consulta', 'consulta');
    Route::get('medicos/{id}/pacientes', 'pacientes');
    Route::post('medicos', 'store');
});

Route::controller(PacienteController::class)->group(function () {
    Route::put('pacientes/{id}', 'update');
    Route::post('pacientes', 'store');
});