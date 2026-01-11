<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\Authenticate;

Route::get('/', [DashboardController::class, 'home'])->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/home', [DashboardController::class, 'home'])->name('home');

Route::post('/', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'addUser'])->name('addUser');

// Dashboard route (protected)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Import route files
require __DIR__ . '/volunteer.php';
require __DIR__ . '/task.php';
require __DIR__ . '/assignment.php';
require __DIR__ . '/workplace.php';
