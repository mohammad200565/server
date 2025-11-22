<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('v1.auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('v1.auth.login');
    });
    Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('v1.auth.logout');
        Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('departments.reviews', ReviewController::class)->scoped();
        Route::post('/departments/${department}/favorite/toggle', [FavoriteController::class, 'toggle']);
    });
});
