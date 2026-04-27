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

    // Kelola Invoice
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
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

    // Kelola Produk/Jasa
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');

    // Rute Verifikasi Pembayaran oleh Admin
    Route::post('/pembayaran/{id}/verify', [App\Http\Controllers\PembayaranController::class, 'verify'])->name('pembayaran.verify');
});