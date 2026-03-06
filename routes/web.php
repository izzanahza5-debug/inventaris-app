<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\JenjangController;
use App\Http\Controllers\Master\GedungController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\RuanganController;
use App\Http\Controllers\Master\SumberDanaController;
use App\Http\Controllers\PengajuanController;

/*
|--------------------------------------------------------------------------
| Public Routes (Halaman akses publik/guest)
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'index'])
    ->name('login')
    ->middleware('redirectIfLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


/*
|--------------------------------------------------------------------------
| Protected Routes (Halaman yang WAJIB Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Master Data (Jenjang, Gedung, Kategori/Kode Barang, Sumber Dana)
    Route::prefix('master')
        ->name('master.')
        ->group(function () {
            Route::resource('jenjang', JenjangController::class);
            Route::resource('gedung', GedungController::class);
            Route::resource('kategori', KategoriController::class); // Master Kode Barang
            Route::resource('sumber-dana', SumberDanaController::class); // Master Data Pembelian
            Route::resource('ruangan', RuanganController::class);
        });

    // 3. Kelola Barang & Laporan (PDF/Excel)
    // Pastikan route export diletakkan DI ATAS resource agar tidak tertukar dengan route /barang/{id}
    Route::get('/barang/export-pdf', [BarangController::class, 'exportPdf'])->name('barang.export-pdf');
    Route::get('/barang/export-excel', [BarangController::class, 'exportExcel'])->name('barang.export-excel');
    Route::get('/barang/cetak-label', [App\Http\Controllers\BarangController::class, 'cetakLabel'])->name('barang.cetak-label');
    Route::get('/barang/cetak-label-satuan/{id}', [BarangController::class, 'cetakLabelSatuan'])
    ->name('barang.cetak-label-satuan');
    Route::resource('barang', BarangController::class);
    Route::get('/api/ruangan/{gedung_id}', [App\Http\Controllers\Master\RuanganController::class, 'getRuanganByGedung']);

    // 4. Khusus Role Admin (Kelola User)
    // Hanya user dengan role 'admin' yang bisa masuk ke sini
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    // Route::middleware(['role:admin'])->group(function () {
    // });

    // 5. Pengajuan Barang
    Route::resource('pengajuan', PengajuanController::class);
    // Route khusus update status oleh Admin
    Route::patch('/pengajuan/{pengajuan}/status', [PengajuanController::class, 'updateStatus'])->name('pengajuan.update-status');
    Route::get('/pengajuan/{pengajuan}/cetak', [PengajuanController::class, 'cetakPdf'])->name('pengajuan.cetak');
});

Route::get('/{slug}', [App\Http\Controllers\BarangController::class, 'showPublic'])->name('barang.show-public');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

