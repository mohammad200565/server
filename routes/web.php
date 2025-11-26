<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/users', function () {
    return view('users');
});

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
