<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// REDIRECT ROOT: Redirect to login or dashboard based on auth status
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| GUEST ROUTES: Authentication
|--------------------------------------------------------------------------
| NOTE: Only accessible when not authenticated
*/
Route::middleware('guest')->group(function () {
    // SHOW LOGIN FORM: Display login page
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

    // PROCESS LOGIN: Authenticate user credentials
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES: All logged-in users
|--------------------------------------------------------------------------
| NOTE: Requires authentication
*/
Route::middleware('auth')->group(function () {
    // LOGOUT: End user session
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // DASHBOARD: Unified dashboard for all roles
    // NOTE: Single controller with role-based logic
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| SUPERADMIN ROUTES: Administrator access only
|--------------------------------------------------------------------------
| NOTE: Requires 'superadmin' role
*/
Route::middleware(['auth', 'role:superadmin'])->group(function () {

    // USER MANAGEMENT
    Route::prefix('users')->name('users.')->group(function () {
        // LIST USERS: Display all users with filters
        Route::get('/', [UserController::class, 'index'])->name('index');

        // CREATE USER: Show create form
        Route::get('/create', [UserController::class, 'create'])->name('create');

        // STORE USER: Save new user
        Route::post('/store', [UserController::class, 'store'])->name('store');

        // SHOW USER: Display user details
        Route::get('/show/{id}', [UserController::class, 'show'])->name('show');

        // EDIT USER: Show edit form
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');

        // UPDATE USER: Save user changes
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');

        // DELETE USER: Remove user
        Route::post('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');

        // TOGGLE STATUS: Activate/Deactivate user
        Route::post('/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('toggle.status');
    });

    // REPORT MANAGEMENT (SUPERADMIN)
    Route::prefix('reports')->name('reports.')->group(function () {
        // LIST REPORTS: Display all reports with filters
        Route::get('/', [ReportController::class, 'index'])->name('index');

        // SHOW REPORT: Display report details
        Route::get('/show/{id}', [ReportController::class, 'show'])->name('show');

        // APPROVE REPORT: Approve submitted report
        Route::post('/approve/{id}', [ReportController::class, 'approve'])->name('approve');

        // REJECT REPORT: Reject submitted report with reason
        Route::post('/reject/{id}', [ReportController::class, 'reject'])->name('reject');

        // EXPORT EXCEL: Export reports to Excel
        Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');

        // EXPORT PDF: Export reports to PDF
        Route::get('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
    });
});

/*
|--------------------------------------------------------------------------
| USER ROUTES: Regular user access
|--------------------------------------------------------------------------
| NOTE: Requires 'user' role
*/
Route::middleware(['auth', 'role:user'])->group(function () {

    // MY REPORTS
    Route::prefix('my-reports')->name('my.reports.')->group(function () {
        // LIST MY REPORTS: Display user's own reports
        Route::get('/', [ReportController::class, 'myReports'])->name('index');

        // CREATE REPORT: Show create form
        Route::get('/create', [ReportController::class, 'create'])->name('create');

        // STORE REPORT: Save new report
        Route::post('/store', [ReportController::class, 'store'])->name('store');

        // SHOW MY REPORT: Display report details
        Route::get('/show/{id}', [ReportController::class, 'showMyReport'])->name('show');

        // EDIT REPORT: Show edit form (only draft/rejected)
        Route::get('/edit/{id}', [ReportController::class, 'edit'])->name('edit');

        // UPDATE REPORT: Save report changes
        Route::post('/update/{id}', [ReportController::class, 'update'])->name('update');

        // DELETE REPORT: Remove report (only draft)
        Route::post('/delete/{id}', [ReportController::class, 'destroy'])->name('destroy');

        // SUBMIT REPORT: Submit draft to superadmin
        Route::post('/submit/{id}', [ReportController::class, 'submit'])->name('submit');

        // DELETE ATTACHMENT: Remove attachment from report
        Route::post('/attachments/delete/{id}', [ReportController::class, 'deleteAttachment'])->name('attachment.delete');
    });

    // PROFILE MANAGEMENT
    Route::prefix('profile')->name('profile.')->group(function () {
        // EDIT PROFILE: Show profile edit form
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');

        // UPDATE PROFILE: Save profile changes
        Route::post('/update', [ProfileController::class, 'update'])->name('update');

        // UPDATE PASSWORD: Change user password
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });
});
