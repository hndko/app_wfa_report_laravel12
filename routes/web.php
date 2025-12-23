<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\ReportController as SuperadminReportController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Redirect root to appropriate dashboard
    Route::get('/', function () {
        if (auth()->user()->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }
        return redirect()->route('user.dashboard');
    });
});

// Superadmin routes
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('dashboard');

    // User management
    Route::resource('users', UserController::class);

    // Report management
    Route::get('/reports', [SuperadminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [SuperadminReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/approve', [SuperadminReportController::class, 'approve'])->name('reports.approve');
    Route::post('/reports/{report}/reject', [SuperadminReportController::class, 'reject'])->name('reports.reject');
    Route::get('/reports/export/excel', [SuperadminReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [SuperadminReportController::class, 'exportPdf'])->name('reports.export.pdf');
});

// User routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Reports
    Route::resource('reports', UserReportController::class);
    Route::post('/reports/{report}/submit', [UserReportController::class, 'submit'])->name('reports.submit');
});
