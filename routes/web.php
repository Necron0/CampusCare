<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\pengguna\DashboardController;
use App\Http\Controllers\pengguna\ObatController;
use App\Http\Controllers\pengguna\KonsultasiController;
use App\Http\Controllers\pengguna\OrderController;
use App\Http\Controllers\pengguna\RiwayatController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\MitraManagementController;
use App\Http\Controllers\Auth\MitraAuthController;
use App\Http\Controllers\Mitra\MitraObatController;
use App\Http\Controllers\Mitra\MitraPesananController;
use App\Http\Controllers\Mitra\MitraPromosiController;
use App\Http\Controllers\Mitra\NotifikasiController;
use App\Http\Controllers\Mitra\MitraKonsultasiController;

// ============================================
// PUBLIC ROUTES (Tanpa Authentication)
// ============================================
Route::get('/', function () {
    return view('pengguna.login'); // Tampilkan welcome page untuk guest
})->name('home');

// Authentication Routes
Route::get('/login', function () {
    // Redirect berdasarkan session sebelumnya
    if (session()->has('url.intended')) {
        return view('pengguna.login');
    }

    // Cek jika sudah login, redirect ke dashboard sesuai role
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

    return view('pengguna.login');
})->name('login');

// Google Auth
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('login.google.callback');

// Mitra Auth (Public)
Route::prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/register', [MitraAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [MitraAuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [MitraAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MitraAuthController::class, 'login'])->name('login.submit');
});

// ============================================
// SINGLE LOGOUT ROUTE (Hanya satu logout route)
// ============================================
Route::post('/logout', function () {
    Auth::logout();
    session()->flush(); // Clear semua session
    return redirect()->route('login')->with('status', 'Anda telah logout.');
})->name('logout');

// ============================================
// PENGGUNA ROUTES (User Biasa)
// ============================================
Route::prefix('pengguna')->name('pengguna.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Obat
    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
    Route::get('/obat/{id}', [ObatController::class, 'show'])->name('obat.show');

    // Order
    Route::get('/order/{obat_id}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/{obat_id}', [OrderController::class, 'store'])->name('order.store');
    Route::get('/obat/{id}/pesan', [ObatController::class, 'pesan'])->name('obat.pesan');
    Route::post('/obat/{id}/pesan', [ObatController::class, 'pesanStore'])->name('obat.pesan.store');


    Route::get('/riwayat', [OrderController::class, 'riwayat'])->name('riwayat.index');

    // Konsultasi
    Route::prefix('konsultasi')->name('konsultasi.')->group(function () {
        Route::get('/', [KonsultasiController::class, 'index'])->name('index');
        Route::get('/create', [KonsultasiController::class, 'create'])->name('create');
        Route::post('/', [KonsultasiController::class, 'store'])->name('store');
        Route::get('/{id}', [KonsultasiController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [KonsultasiController::class, 'cancel'])->name('cancel');
        Route::post('/{id}/close', [KonsultasiController::class, 'close'])->name('close');
        Route::delete('/{id}', [KonsultasiController::class, 'destroy'])->name('destroy');
    });
});

// ============================================
// MITRA ROUTES
// ============================================
Route::prefix('mitra')->name('mitra.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [MitraAuthController::class, 'dashboard'])->name('dashboard');

    // Obat
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

    // Pesanan
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/', [MitraPesananController::class, 'index'])->name('index');
        Route::get('/{id}', [MitraPesananController::class, 'show'])->name('show');
        Route::put('/{id}/update-status', [MitraPesananController::class, 'updateStatus'])->name('update-status');
        Route::put('/{id}/konfirmasi-diterima', [MitraPesananController::class, 'konfirmasiDiterima'])->name('konfirmasi-diterima');
        Route::put('/{id}/batalkan', [MitraPesananController::class, 'batalkan'])->name('batalkan');
    });

    // Promosi
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

    // Notifikasi
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::get('/get', [NotifikasiController::class, 'getNotifikasi'])->name('get');
        Route::post('/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotifikasiController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [NotifikasiController::class, 'destroy'])->name('destroy');
        Route::delete('/clear-read', [NotifikasiController::class, 'clearRead'])->name('clear-read');
    });

    // Konsultasi
    Route::prefix('konsultasi')->name('konsultasi.')->group(function () {
        Route::get('/', [MitraKonsultasiController::class, 'index'])->name('index');
        Route::get('/selesai', [MitraKonsultasiController::class, 'selesai'])->name('selesai');
        Route::get('/{id}', [MitraKonsultasiController::class, 'show'])->name('show');
        Route::get('/{id}/jawab', [MitraKonsultasiController::class, 'jawabForm'])->name('jawab.form');
        Route::post('/{id}/jawab', [MitraKonsultasiController::class, 'jawab'])->name('jawab');
        Route::post('/{id}/claim', [MitraKonsultasiController::class, 'claim'])->name('claim');
        Route::post('/{id}/release', [MitraKonsultasiController::class, 'release'])->name('release');
    });
});

// ============================================
// ADMIN ROUTES
// ============================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Routes (Login)
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    // Authenticated Routes
    Route::middleware(['auth', 'admin.only'])->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::prefix('user-management')->name('user-management.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/', [UserManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
        });

        // Mitra Management
        Route::prefix('mitra-management')->name('mitra-management.')->group(function () {
            Route::get('/', [MitraManagementController::class, 'index'])->name('index');
            Route::post('/', [MitraManagementController::class, 'store'])->name('store');
            Route::get('/{id}', [MitraManagementController::class, 'show'])->name('show');
            Route::put('/{id}', [MitraManagementController::class, 'update'])->name('update');
            Route::post('/{id}/toggle-status', [MitraManagementController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/{id}', [MitraManagementController::class, 'destroy'])->name('destroy');
        });

        // Analytics
        Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
    });
});
