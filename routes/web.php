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
use App\Http\Controllers\KlienPortalController;
use App\Http\Controllers\ProfileController;



Route::get('/', function () {
    return view('welcome');
})->name('welcome');




Route::get('/portal', [KlienPortalController::class, 'index'])->name('portal.login');
Route::post('/portal/login', [KlienPortalController::class, 'login'])->name('portal.auth');
Route::get('/portal/dashboard', [KlienPortalController::class, 'dashboard'])->name('portal.dashboard');
Route::get('/portal/invoice/{id}/pdf', [KlienPortalController::class, 'downloadPdf'])->name('portal.invoice.pdf');
Route::get('/portal/logout', [KlienPortalController::class, 'logout'])->name('portal.logout');

Route::get('/portal/konfirmasi/{id_invoice}', [PembayaranController::class, 'create'])->name('pembayaran.create');
Route::post('/portal/konfirmasi', [PembayaranController::class, 'store'])->name('pembayaran.store');




Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/name', [ProfileController::class, 'updateName'])->name('profile.updateName');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    
    Route::get('/invoice/trigger-reminder', [InvoiceController::class, 'triggerReminder'])->name('invoice.trigger-reminder');
    
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::post('/invoice/{id}/status', [InvoiceController::class, 'updateStatus'])->name('invoice.updateStatus');
    
    Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');

    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    Route::get('/klien', [KlienController::class, 'index'])->name('klien.index');
    Route::get('/klien/create', [KlienController::class, 'create'])->name('klien.create');
    Route::post('/klien', [KlienController::class, 'store'])->name('klien.store');

    Route::get('/klien/{id}/edit', [KlienController::class, 'edit'])->name('klien.edit');
    Route::put('/klien/{id}', [KlienController::class, 'update'])->name('klien.update');
    Route::delete('/klien/{id}', [KlienController::class, 'destroy'])->name('klien.destroy');

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');

    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::post('/pembayaran/{id}/verify', [App\Http\Controllers\PembayaranController::class, 'verify'])->name('pembayaran.verify');

    Route::get('/laporan/export', [LaporanController::class, 'exportPdf'])->name('laporan.export');
});