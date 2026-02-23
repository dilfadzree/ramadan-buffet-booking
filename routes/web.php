<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Staff\BookingController as StaffBookingController;
use App\Http\Controllers\Staff\CapacityController;
use App\Http\Controllers\Staff\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Booking routes
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/confirmation/{reference}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

// Payment routes (static routes before dynamic {reference})
Route::get('/payment/senangpay/return', [PaymentController::class, 'senangPayReturn'])->name('payment.senangpay.return');
Route::post('/payment/senangpay/callback', [PaymentController::class, 'senangPayCallback'])->name('payment.senangpay.callback');
Route::get('/payment/toyyibpay/return', [PaymentController::class, 'toyyibPayReturn'])->name('payment.toyyibpay.return');
Route::post('/payment/toyyibpay/callback', [PaymentController::class, 'toyyibPayCallback'])->name('payment.toyyibpay.callback');
Route::get('/payment/{reference}', [PaymentController::class, 'show'])->name('payment.checkout');
Route::get('/payment/{reference}/toyyibpay', [PaymentController::class, 'toyyibPayRedirect'])->name('payment.toyyibpay.redirect');
Route::get('/payment/{reference}/failed', [PaymentController::class, 'failed'])->name('payment.failed');

// API routes for AJAX
Route::get('/api/check-availability', [BookingController::class, 'checkAvailability'])->name('api.check-availability');
Route::get('/api/available-dates', [BookingController::class, 'availableDates'])->name('api.available-dates');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Staff Dashboard Routes
    Route::middleware(['App\Http\Middleware\EnsureUserIsStaff'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Staff Booking Management
        Route::resource('bookings', StaffBookingController::class);
        Route::post('/bookings/{booking}/cancel', [StaffBookingController::class, 'cancel'])->name('bookings.cancel');
        Route::get('/bookings-export', [StaffBookingController::class, 'export'])->name('bookings.export');

        // Capacity Management
        Route::get('/capacity', [CapacityController::class, 'index'])->name('capacity.index');
        Route::post('/capacity', [CapacityController::class, 'store'])->name('capacity.store');
        Route::get('/api/capacities', [CapacityController::class, 'getCapacities'])->name('capacity.api');
    });
});

// Auth routes (login/register)
require __DIR__.'/auth.php';
