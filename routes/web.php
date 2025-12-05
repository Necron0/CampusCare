<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pengguna\DashboardController;
use App\Http\Controllers\pengguna\ObatController;
use App\Http\Controllers\pengguna\KonsultasiController;
use App\Http\Controllers\pengguna\OrderController;
use App\Http\Controllers\pengguna\RiwayatController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\MitraManagementController;
use App\Http\Controllers\Auth\MitraAuthController;
use App\Http\Controllers\Mitra\MitraObatController; // TAMBAHAN BARU
use App\Http\Controllers\Mitra\MitraPesananController;
use App\Http\Controllers\Mitra\MitraPromosiController;
use App\Http\Controllers\Mitra\NotifikasiController;

// Public Routes - Tidak memerlukan login
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('login.google.callback');

// Mitra Auth Routes (Bisa diakses tanpa login)
Route::prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/register', [MitraAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [MitraAuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [MitraAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MitraAuthController::class, 'login'])->name('login.submit');
});

Route::get('/login', function () {
    return view('pengguna.login');
})->name('login');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('public.logout');

Route::prefix('pengguna')->name('pengguna.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
    Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');

    Route::get('/order/{obat_id}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/{obat_id}', [OrderController::class, 'store'])->name('order.store');

    Route::get('/riwayat', [OrderController::class, 'riwayat'])->name('riwayat.index');
});

Route::prefix('mitra')->name('mitra.')->middleware(['auth'])->group(function () {
    // Dashboard Mitra
    Route::get('/dashboard', [MitraAuthController::class, 'dashboard'])->name('dashboard');

    // Manajemen Obat Mitra - TAMBAHAN BARU
    Route::prefix('obat')->name('obat.')->group(function () {
        Route::get('/', [MitraObatController::class, 'index'])->name('index');
        Route::get('/create', [MitraObatController::class, 'create'])->name('create');
        Route::post('/', [MitraObatController::class, 'store'])->name('store');
        Route::get('/{id}', [MitraObatController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MitraObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MitraObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [MitraObatController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/update-stok', [MitraObatController::class, 'updateStok'])->name('update-stok');
    });

    // Manajemen Pesanan (TAMBAH INI - BARU)
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/', [MitraPesananController::class, 'index'])->name('index');
        Route::get('/{id}', [MitraPesananController::class, 'show'])->name('show');
        Route::put('/{id}/update-status', [MitraPesananController::class, 'updateStatus'])->name('update-status');
        Route::put('/{id}/konfirmasi-diterima', [MitraPesananController::class, 'konfirmasiDiterima'])->name('konfirmasi-diterima');
        Route::put('/{id}/batalkan', [MitraPesananController::class, 'batalkan'])->name('batalkan');
});

    // Manajemen Promosi (TAMBAH INI - BARU)
    Route::prefix('promosi')->name('promosi.')->group(function () {
        Route::get('/', [MitraPromosiController::class, 'index'])->name('index');
        Route::get('/create', [MitraPromosiController::class, 'create'])->name('create');
        Route::post('/', [MitraPromosiController::class, 'store'])->name('store');
        Route::get('/{id}', [MitraPromosiController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MitraPromosiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MitraPromosiController::class, 'update'])->name('update');
        Route::delete('/{id}', [MitraPromosiController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/toggle-status', [MitraPromosiController::class, 'toggleStatus'])->name('toggle-status');
});

    // Notifikasi Routes (TAMBAH INI - BARU)
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::get('/get', [NotifikasiController::class, 'getNotifikasi'])->name('get');
        Route::post('/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotifikasiController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [NotifikasiController::class, 'destroy'])->name('destroy');
        Route::delete('/clear-read', [NotifikasiController::class, 'clearRead'])->name('clear-read');
});
    // Route mitra lainnya bisa ditambahkan di sini
    // Contoh: Pesanan, Konsultasi, Laporan, dll
});

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

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'mitra') {
            return redirect()->route('mitra.dashboard');
        } else {
            return redirect()->route('pengguna.dashboard');
        }
    }
    return redirect()->route('login');
});
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
