<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KlienController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KlienPortalController; // Tambahan untuk Pelanggan
use App\Http\Controllers\ProfileController; // Tambahan untuk Pengaturan Akun Admin

// ========================================================
// 1. HALAMAN UTAMA (LANDING PAGE - PILIH PORTAL)
// ========================================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// ========================================================
// 2. PORTAL PELANGGAN (SESUAI DFD & SEQUENCE DIAGRAM 5.0)
// ========================================================
Route::get('/portal', [KlienPortalController::class, 'index'])->name('portal.login');
Route::post('/portal/login', [KlienPortalController::class, 'login'])->name('portal.auth');
Route::get('/portal/dashboard', [KlienPortalController::class, 'dashboard'])->name('portal.dashboard');
Route::get('/portal/invoice/{id}/pdf', [KlienPortalController::class, 'downloadPdf'])->name('portal.invoice.pdf');
Route::get('/portal/logout', [KlienPortalController::class, 'logout'])->name('portal.logout');

// Form Pelanggan Mengirim Konfirmasi Pembayaran
Route::get('/portal/konfirmasi/{id_invoice}', [PembayaranController::class, 'create'])->name('pembayaran.create');
Route::post('/portal/konfirmasi', [PembayaranController::class, 'store'])->name('pembayaran.store');


// ========================================================
// 3. PORTAL ADMIN (AUTH & MANAJEMEN)
// ========================================================

// Otentikasi Admin
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Area Terlindungi Admin (Harus Login)
Route::middleware('auth')->group(function () {
    
    // Dashboard Admin (Ubah rute dari '/' menjadi '/dashboard' karena '/' dipakai Landing Page)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pengaturan Akun Admin (Rute Baru)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/name', [ProfileController::class, 'updateName'])->name('profile.updateName');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Kelola Invoice
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    
    // --- Rute Baru untuk Tombol Trigger Reminder Manual ---
    Route::get('/invoice/trigger-reminder', [InvoiceController::class, 'triggerReminder'])->name('invoice.trigger-reminder');
    
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::post('/invoice/{id}/status', [InvoiceController::class, 'updateStatus'])->name('invoice.updateStatus');

    // Kelola Pembayaran (Admin melihat riwayat)
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');

    // Kelola Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Kelola Klien
    Route::get('/klien', [KlienController::class, 'index'])->name('klien.index');
    Route::get('/klien/create', [KlienController::class, 'create'])->name('klien.create');
    Route::post('/klien', [KlienController::class, 'store'])->name('klien.store');
    // --- Rute Baru untuk Edit dan Delete Klien ---
    Route::get('/klien/{id}/edit', [KlienController::class, 'edit'])->name('klien.edit');
    Route::put('/klien/{id}', [KlienController::class, 'update'])->name('klien.update');
    Route::delete('/klien/{id}', [KlienController::class, 'destroy'])->name('klien.destroy');

    // Kelola Produk/Jasa
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    // --- Rute Baru untuk Edit dan Delete Produk ---
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // Rute Verifikasi Pembayaran oleh Admin
    Route::post('/pembayaran/{id}/verify', [App\Http\Controllers\PembayaranController::class, 'verify'])->name('pembayaran.verify');

    // Export PDF
    Route::get('/laporan/export', [LaporanController::class, 'exportPdf'])->name('laporan.export');
});