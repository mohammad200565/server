<?php

use App\Http\Controllers\admin\AdminController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'showRecent'])->middleware(['auth']);
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout')->middleware(['auth']);

Route::prefix('users')->name('users.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'indexUsers'])->name('index');
    Route::get('/{user}', [AdminController::class, 'showUser'])->name('show');
    Route::put('/{user}/verify', [AdminController::class, 'verifyUser'])->name('verify');
    Route::put('/{user}/reject', [AdminController::class, 'rejectUser'])->name('reject');
    Route::post('/{user}/balance', [AdminController::class, 'updateBalance'])->name('update_balance');
});

Route::prefix('departments')->name('departments.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'indexDepartment'])->name('index');
    Route::get('/{department}', [AdminController::class, 'showDepartment'])->name('show');
    Route::put('/{department}/verify', [AdminController::class, 'verifyDepartment'])->name('verify');
    Route::put('/{department}/reject', [AdminController::class, 'rejectDepartment'])->name('reject');
});

Route::prefix('contracts')->name('contracts.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'indexContract'])->name('index');
    Route::get('/{rent}', [AdminController::class, 'showContract'])->name('show');
});
