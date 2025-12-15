<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\RentController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });
    Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('rents', RentController::class);
        Route::apiResource('departments.reviews', ReviewController::class)->scoped();
        Route::apiResource('departments.comments', CommentController::class)->scoped();
        Route::post('departments/{department}/favorite/toggle', [FavoriteController::class, 'toggle']);
        Route::get('favorites/me', [FavoriteController::class, 'userFavorites']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});
