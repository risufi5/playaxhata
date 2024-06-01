<?php

use App\Http\Controllers\CodeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('generate-code/{nr}', [CodeController::class, 'generateCodes']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('check-code', [CodeController::class, 'checkCodeAndStart']);
    Route::post('finish', [CodeController::class, 'finishGame']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

