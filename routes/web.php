<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\AvailabilityController;

/*
|--------------------------------------------------------------------------
| Public Routes (Ophthalmology Clinic)
|--------------------------------------------------------------------------
*/

// Homepage - List of doctors
Route::get('/', [PublicController::class, 'index'])->name('home');

// Doctor profile with availability
Route::get('/doctors/{doctor:slug}', [PublicController::class, 'showDoctor'])->name('doctors.show');

// Appointment booking form
Route::get('/appointments/new', [PublicController::class, 'showBookingForm'])->name('appointments.booking-form');

// Store appointment (public)
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Home Dashboard - Main admin panel
    Route::get('/home', [HomeController::class, 'index'])->name('home.admin');

    /*
    |--------------------------------------------------------------------------
    | Doctors Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Doctors CRUD
        Route::resource('doctors', DoctorController::class);
        
        // Doctor availability management
        Route::get('doctors/{doctor}/availabilities', [AvailabilityController::class, 'index'])
            ->name('doctors.availabilities.index');
        Route::post('doctors/{doctor}/availabilities', [AvailabilityController::class, 'store'])
            ->name('doctors.availabilities.store');
        Route::put('doctors/{doctor}/availabilities/{availability}', [AvailabilityController::class, 'update'])
            ->name('doctors.availabilities.update');
        Route::delete('doctors/{doctor}/availabilities/{availability}', [AvailabilityController::class, 'destroy'])
            ->name('doctors.availabilities.destroy');

        /*
        |--------------------------------------------------------------------------
        | Appointments Management
        |--------------------------------------------------------------------------
        */
        Route::get('appointments', [AdminAppointmentController::class, 'index'])
            ->name('appointments.index');
        Route::get('appointments/{appointment:slug}', [AdminAppointmentController::class, 'show'])
            ->name('appointments.show');
        Route::post('appointments/{appointment:slug}/accept', [AdminAppointmentController::class, 'accept'])
            ->name('appointments.accept');
        Route::post('appointments/{appointment:slug}/reject', [AdminAppointmentController::class, 'reject'])
            ->name('appointments.reject');
        Route::post('appointments/{appointment:slug}/cancel', [AdminAppointmentController::class, 'cancel'])
            ->name('appointments.cancel');

        /*
        |--------------------------------------------------------------------------
        | Calendar View
        |--------------------------------------------------------------------------
        */
        Route::get('calendar', [CalendarController::class, 'index'])
            ->name('calendar');
    });
    
    // Calendar route accessible directly (not under /admin prefix)
    Route::get('/calendar', [CalendarController::class, 'index'])
        ->name('calendar.admin');
});

