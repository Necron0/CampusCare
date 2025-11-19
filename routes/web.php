<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\MitraManagementController;


Route::get('login/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('public.logout');



Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->middleware('throttle:admin-login');
    });
    Route::middleware(['auth', 'admin.only'])->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('user-management')->name('user-management.')->group(function () {

            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/', [UserManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('mitra-management')->name('mitra-management.')->group(function () {
        Route::get('/', [MitraManagementController::class, 'index'])->name('index');
        Route::post('/', [MitraManagementController::class, 'store'])->name('store');
        Route::get('/{id}', [MitraManagementController::class, 'show'])->name('show');
        Route::put('/{id}', [MitraManagementController::class, 'update'])->name('update');
        Route::post('/{id}/toggle-status', [MitraManagementController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{id}', [MitraManagementController::class, 'destroy'])->name('destroy');
    });

        Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
    });
});
