<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/departments', 'departments')->name('departments');
Route::view('/contracts', 'contracts')->name('contracts');
Route::view('/history', 'history')->name('history');
Route::view('/login', 'auth.login')->name('login');

Route::post('/login', [AdminController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [AdminController::class, 'indexUsers'])->name('index');
    Route::get('/{user}', [AdminController::class, 'showUser'])->name('show');
    Route::put('/{user}/verify', [AdminController::class, 'verify'])->name('verify');
    Route::put('/{user}/reject', [AdminController::class, 'reject'])->name('reject');
});
