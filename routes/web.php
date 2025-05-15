<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route protégée par l'authentification
Route::middleware('auth:client')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboards.client');
    })->name('client.dashboard');  // Modifier ce nom de route
});
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->name('admin');
Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin');
    })->name('admin.dashboard');
});

Route::get('/home', function () {
    return view('welcome');  // Ou n'importe quelle vue que vous voulez afficher
})->name('home');