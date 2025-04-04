<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Modules\Booking\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', ])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User management routes
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::put('/user/update-profile', [UserController::class, 'updateProfile'])->name('user.update-profile');
    });

    // Appointment routes
    Route::prefix('appointments')->group(function () {
        Route::get('/create', [BookingController::class, 'create'])->name('appointments.create');
        Route::post('/', [BookingController::class, 'store'])->name('appointments.store');
        Route::get('/', [BookingController::class, 'index'])->name('appointments.index');
        Route::get('/{appointment}/reschedule', [BookingController::class, 'reschedule'])
            ->name('appointments.reschedule');
        Route::put('/{appointment}', [BookingController::class, 'update'])
            ->name('appointments.update');
        Route::put('/{appointment}/cancel', [BookingController::class, 'cancel'])->name('appointments.cancel');
    });
});
