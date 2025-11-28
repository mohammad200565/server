<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/users', [AdminController::class, 'indexUsers']);
Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
Route::put('/users/{user}/verify', [AdminController::class, 'verify'])->name('users.verify');
Route::put('/users/{user}/reject', [AdminController::class, 'reject'])->name('users.reject');

Route::get('/departments', function () {
    return view('departments');
});

Route::get('/contracts', function () {
    return view('contracts');
});

Route::get('/history', function () {
    return view('history');
});

Route::get('/login', function() {
    return view('auth.login');
});

Route::post('login', [AdminController::class, 'login']);
Route::post('logout', [AdminController::class, 'logout']);

