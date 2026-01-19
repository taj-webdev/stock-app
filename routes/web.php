<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Tambahkan controller Master
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Master\MerkController;
use App\Http\Controllers\Master\SatuanController;

// Tambahkan controller Customer
use App\Http\Controllers\CustomerController;

// Tambahkan controller Transaksi
use App\Http\Controllers\Transaksi\BarangMasukController;
use App\Http\Controllers\Transaksi\BarangKeluarController;

// Tambahkan controller Laporan
use App\Http\Controllers\Laporan\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// ===========================
// AUTH ROUTES (Login, Register, Logout)
// ===========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
});

// Logout hanya untuk user yang login
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ===========================
// DASHBOARD + PROFILE + MASTER DATA + CUSTOMERS + TRANSAKSI + LAPORAN
// ===========================
Route::middleware(['auth'])->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===========================
    // PROFILE
    // ===========================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===========================
    // MASTER BARANG
    // ===========================
    Route::prefix('master')->group(function () {
        Route::resource('barang', BarangController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('merk', MerkController::class);
        Route::resource('satuan', SatuanController::class);
    });

    // ===========================
    // CUSTOMERS
    // ===========================
    Route::resource('customers', CustomerController::class);

    // ===========================
    // TRANSAKSI
    // ===========================
    Route::resource('barang-masuk', BarangMasukController::class);
    Route::resource('barang-keluar', BarangKeluarController::class);

    // ===========================
    // LAPORAN
    // ===========================
    Route::prefix('laporan')->group(function () {
        Route::get('/barang-masuk', [LaporanController::class, 'barangMasuk'])->name('laporan.barang-masuk');
        Route::get('/barang-keluar', [LaporanController::class, 'barangKeluar'])->name('laporan.barang-keluar');
        Route::get('/barang-masuk/pdf', [LaporanController::class, 'barangMasukPDF'])->name('laporan.barang-masuk.pdf');
        Route::get('/barang-keluar/pdf', [LaporanController::class, 'barangKeluarPDF'])->name('laporan.barang-keluar.pdf');
    });
});

// ⚠️ Tidak perlu lagi `require __DIR__.'/auth.php'`
// karena kita sudah override semua route login/register sendiri.
