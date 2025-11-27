<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pengguna\DashboardController;
use App\Http\Controllers\pengguna\ObatController;
use App\Http\Controllers\pengguna\KonsultasiController;
use App\Http\Controllers\pengguna\OrderController;
use App\Http\Controllers\pengguna\RiwayatController;

Route::get('/', function () {
    return redirect()->route('pengguna.dashboard');
});

Route::prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
    Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');

    Route::get('/order/{obat_id}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/{obat_id}', [OrderController::class, 'store'])->name('order.store');

    Route::get('/riwayat', [OrderController::class, 'riwayat'])->name('riwayat.index');
});







