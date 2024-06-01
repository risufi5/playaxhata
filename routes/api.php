<?php

use App\Http\Controllers\CodeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('generate-code/{nr}', [CodeController::class, 'generateCodes']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('start', [CodeController::class, 'checkCodeAndStart']);
    Route::get('data', [UserController::class, 'getUserData']);
    Route::post('finish', [CodeController::class, 'finishGame']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

