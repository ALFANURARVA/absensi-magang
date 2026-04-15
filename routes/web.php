<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;

// Home/Welcome Route
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Admin Login Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
});

// Admin Protected Routes
Route::middleware(['auth', 'admin_role'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('siswa');
    Route::get('/siswa/{id}', [AdminController::class, 'siswaDetail'])->name('siswa-detail');
    Route::get('/absensi', [AdminController::class, 'absensi'])->name('absensi');
    Route::get('/absensi/export', [AdminController::class, 'exportAbsensi'])->name('export-absensi');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::controller(AbsensiController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/user', 'user')->name('user');
        Route::get('/absen-masuk', 'showAbsenMasuk')->name('absen.show-masuk');
        Route::get('/absen-pulang', 'showAbsenPulang')->name('absen.show-pulang');
        Route::get('/riwayat', 'riwayat')->name('riwayat');
        Route::get('/laporan', 'laporan')->name('laporan');
        Route::post('/absen-masuk', 'absenMasuk')->name('absen.masuk');
        Route::post('/absen-pulang', 'absenPulang')->name('absen.pulang');
    });

    Route::controller(SiswaController::class)->group(function () {
        Route::get('/siswa/edit', 'edit')->name('siswa.edit');
        Route::put('/siswa/update', 'update')->name('siswa.update');
    });
});