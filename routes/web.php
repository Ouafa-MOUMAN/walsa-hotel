<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\WelcomController;
use App\Http\Controllers\BookingController;

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
Route::get('/booking/reserve/{room}', [BookingController::class, 'reserve'])->name('booking.reserve');

// Route protégée par l'authentification client
Route::middleware('auth:client')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboards.client');
    })->name('client.dashboard');

    // Routes de réservation (protégées par authentification)
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('booking.my-bookings');
});

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->name('admin');

Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations.index');
    Route::get('/clients', [AdminController::class, 'clients'])->name('clients.index');
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
    Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');

    // Routes de gestion des chambres
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::resource('clients', ClientController::class);
    
    // Route pour l'export CSV des clients
    Route::get('clients/export/csv', [ClientController::class, 'export'])
         ->name('clients.export');
    
    // Routes AJAX pour les modals
    Route::get('clients/{client}/details', [ClientController::class, 'show'])
         ->name('clients.details');
});

Route::get('/', [WelcomController::class, 'index'])->name('home');