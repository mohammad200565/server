<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EditedRentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\FcmTokenController;
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
        Route::get('favorites/{department}', [FavoriteController::class, 'isFavorite']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/rents/{rent}/approve', [RentController::class, 'approveRent']);
        Route::post('/rents/{rent}/reject', [RentController::class, 'rejectRent']);
        Route::post('/rents/{rent}/cancel', [RentController::class, 'cancelRent']);

        Route::prefix('edited_rent')->group(function() {
            Route::get('{edited_rent}', [EditedRentController::class, 'show']);
            Route::post('{edited_rent}/approve', [EditedRentController::class, 'approve']);
            Route::post('{edited_rent}/reject', [EditedRentController::class, 'reject']);
        });
        Route::post('/save-fcm-token', [FcmTokenController::class, 'store']);
    });
    Route::post('/send', [FavoriteController::class, 'sendNot']);
});
