<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\JenjangController;
use App\Http\Controllers\Master\GedungController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Master\SumberDanaController;

// Halaman Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login') ->middleware('redirectIfLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route Group untuk Master Data (Bisa diakses Admin, IT, Umum)
Route::prefix('master')->name('master.')->group(function () {
    Route::resource('jenjang', JenjangController::class);
    Route::resource('gedung', GedungController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('sumber-dana', SumberDanaController::class);
});

// Route Khusus Admin (Kelola User)
// Kita akan buat middleware 'role:admin' nanti
Route::resource('user', UserController::class);
Route::middleware(['auth', 'role:admin'])->group(function () {
});

// Route Kelola Barang & Laporan (Bisa diakses semua role)
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');