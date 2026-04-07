<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PembayaranController;

// Halaman Utama & Laporan (Menggunakan DashboardController)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan.index');

// Halaman Kelola Invoice
Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');

// Halaman Pembayaran
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');



use App\Http\Controllers\LoginController;

// Halaman Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Proteksi Dashboard dkk agar harus Login dulu
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan.index');
    Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
});