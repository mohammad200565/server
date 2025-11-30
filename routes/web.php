<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'indexUsers'])->name('index');
Route::view('/contracts', 'contracts')->name('contracts');
Route::view('/history', 'history')->name('history');
Route::view('/login', 'auth.login')->name('login');

Route::post('/login', [AdminController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [AdminController::class, 'indexUsers'])->name('index');
    Route::get('/{user}', [AdminController::class, 'showUser'])->name('show');
    Route::put('/{user}/verify', [AdminController::class, 'verifyUser'])->name('verify');
    Route::put('/{user}/reject', [AdminController::class, 'rejectUser'])->name('reject');
});

Route::prefix('departments')->name('departments.')->group(function () {
    Route::get('/', [AdminController::class, 'indexDepartment'])->name('index');
    Route::get('/{department}', [AdminController::class, 'showDepartment'])->name('show');
    Route::put('/{department}/verify', [AdminController::class, 'verifyDepartment'])->name('verify');
    Route::put('/{department}/reject', [AdminController::class, 'rejectDepartment'])->name('reject');
});
