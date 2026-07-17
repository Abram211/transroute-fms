<?php

use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\Auth\{LoginController, RegisterController};
use App\Http\Controllers\Admin;
use App\Http\Controllers\Passenger;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicSiteController::class, 'index'])->name('home');

/* ── PASSENGER AUTH (public-facing) ───────────────────────────── */
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/* ── ADMIN AUTH (separate portal) ─────────────────────────────── */
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'adminLogin']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/* ── ADMIN ─────────────────────────────────────────────────────── */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/flights', [Admin\FlightController::class, 'index'])->name('flights.index');
    Route::post('/flights', [Admin\FlightController::class, 'store'])->name('flights.store');
    Route::put('/flights/{flight}', [Admin\FlightController::class, 'update'])->name('flights.update');
    Route::post('/flights/{flight}/cancel', [Admin\FlightController::class, 'cancel'])->name('flights.cancel');

    Route::post('/airports', [Admin\AirportController::class, 'store'])->name('airports.store');

    Route::get('/bookings', [Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [Admin\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{ticket}/receipt', [Admin\BookingController::class, 'downloadReceipt'])->name('bookings.receipt');
    Route::post('/bookings/{ticket}/approve', [Admin\BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{ticket}/cancel', [Admin\BookingController::class, 'cancel'])->name('bookings.cancel');

    // Only admin can add luggage
    Route::get('/luggage', [Admin\LuggageController::class, 'index'])->name('luggage.index');
    Route::post('/luggage', [Admin\LuggageController::class, 'store'])->name('luggage.store');
    Route::put('/luggage/{luggage}', [Admin\LuggageController::class, 'update'])->name('luggage.update');
    Route::delete('/luggage/{luggage}', [Admin\LuggageController::class, 'destroy'])->name('luggage.destroy');

    // Only admin allowed to add shipping
    Route::get('/shipping', [Admin\ShipmentController::class, 'index'])->name('shipping.index');
    Route::post('/shipping', [Admin\ShipmentController::class, 'store'])->name('shipping.store');
    Route::put('/shipping/{shipment}', [Admin\ShipmentController::class, 'update'])->name('shipping.update');
    Route::delete('/shipping/{shipment}', [Admin\ShipmentController::class, 'destroy'])->name('shipping.destroy');

    Route::get('/crew', [Admin\CrewController::class, 'index'])->name('crew.index');
    Route::post('/crew', [Admin\CrewController::class, 'store'])->name('crew.store');
    Route::put('/crew/{crew}', [Admin\CrewController::class, 'update'])->name('crew.update');
    Route::delete('/crew/{crew}', [Admin\CrewController::class, 'destroy'])->name('crew.destroy');

    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/download', [Admin\ReportController::class, 'download'])->name('reports.download');
    Route::get('/passengers', [Admin\PassengerController::class, 'index'])->name('passengers.index');
});

/* ── PASSENGER ─────────────────────────────────────────────────── */
Route::prefix('passenger')->name('passenger.')->middleware(['auth', 'role:passenger'])->group(function () {
    Route::get('/dashboard', [Passenger\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/schedule', [Passenger\ScheduleController::class, 'index'])->name('schedule.index');

    Route::get('/bookings', [Passenger\BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [Passenger\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{ticket}/receipt', [Passenger\BookingController::class, 'downloadReceipt'])->name('bookings.receipt');
    Route::post('/bookings/{ticket}/cancel', [Passenger\BookingController::class, 'cancel'])->name('bookings.cancel');

    // Read + update status only (admin-assigned)
    Route::get('/luggage', [Passenger\LuggageController::class, 'index'])->name('luggage.index');
    Route::post('/luggage/{luggage}/status', [Passenger\LuggageController::class, 'updateStatus'])->name('luggage.status');

    // Read-only
    Route::get('/shipping', [Passenger\ShipmentController::class, 'index'])->name('shipping.index');

    Route::post('/notifications/{notification}/read', [Passenger\NotificationController::class, 'markRead'])->name('notifications.read');
});
