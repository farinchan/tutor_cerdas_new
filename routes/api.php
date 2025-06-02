<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/chatbot-restart', [
    \App\Http\Controllers\Api\DockerController::class,
    'restart'
]);
