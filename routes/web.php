<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

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

// Route protégée par l'authentification client
Route::middleware('auth:client')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboards.client');
    })->name('client.dashboard');
});

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->name('admin');

// Routes admin protégées
Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des chambres
    Route::get('/chambres', [AdminController::class, 'chambres'])->name('chambres.index');
    
    // Gestion des réservations
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations.index');
    
    // Gestion des clients
    Route::get('/clients', [AdminController::class, 'clients'])->name('clients.index');
    
    // Gestion des admins
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
    Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');