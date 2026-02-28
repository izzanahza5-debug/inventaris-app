<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route Login
Route::get('/', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    // 1. Menu Kelola User (Hanya Admin)
    Route::group(['middleware' => 'checkRole:admin'], function () {
        Route::resource('users', UserController::class);
    });

    // 2. Menu Master (Dropdown)
    Route::prefix('master')->group(function () {
        Route::resource('jenjang', MasterJenjangController::class);
        Route::resource('kategori', MasterKategoriController::class);
        Route::resource('gedung', MasterGedungController::class);
        Route::resource('sumber-dana', MasterSumberDanaController::class); // Master Data Pembelian
    });

    // 3. Menu Laporan / Rekap
    Route::get('/laporan', [LaporanController::class, 'index']);

    // 4. Menu Kelola Barang
    Route::resource('barang', BarangController::class);
});