<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleClassController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

/*
 *   Instructor all Route
 */

Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/instructor/dashboard', function () {
        return view('instructor.dashboard');
    })->name('instructor.dashboard');

    Route::resource('/instructor/schedule', ScheduleClassController::class)
        ->only('index', 'create', 'store', 'destroy');
});

/*
 *   Member all Route
 */

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    })->name('member.dashboard');

    Route::get('/member/book', [BookingController::class, 'create'])
        ->name('booking.create');
    Route::post('/member/booking', [BookingController::class, 'store'])
        ->name('booking.store');
    Route::get('/member/booking', [BookingController::class, 'index'])
        ->name('booking.index');
    Route::delete('/member/booking/{id}', [BookingController::class, 'destroy'])
        ->name('booking.destroy');
});

/*
 *   breezee authentication part
 */

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
