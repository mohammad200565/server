<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'showRecent']);
Route::post('/login', [AdminController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [AdminController::class, 'indexUsers'])->name('index');
    Route::get('/{user}', [AdminController::class, 'showUser'])->name('show')->middleware(['auth']);
    Route::put('/{user}/verify', [AdminController::class, 'verifyUser'])->name('verify')->middleware(['auth']);
    Route::put('/{user}/reject', [AdminController::class, 'rejectUser'])->name('reject')->middleware(['auth']);
});

Route::prefix('departments')->name('departments.')->group(function () {
    Route::get('/', [AdminController::class, 'indexDepartment'])->name('index');
    Route::get('/{department}', [AdminController::class, 'showDepartment'])->name('show')->middleware(['auth']);
    Route::put('/{department}/verify', [AdminController::class, 'verifyDepartment'])->name('verify')->middleware(['auth']);
    Route::put('/{department}/reject', [AdminController::class, 'rejectDepartment'])->name('reject')->middleware(['auth']);
});

Route::prefix('contracts')->name('contracts.')->group(function () {
    Route::get('/', [AdminController::class, 'indexContract'])->name('index');
    Route::get('/{rent}', [AdminController::class, 'showContract'])->name('show')->middleware(['auth']);
});
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');;
