<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JWTMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->withoutMiddleware(JWTMiddleware::class);
    Route::get('user', 'user');
    Route::post('logout', 'logout');
});