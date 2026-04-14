<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Home/Welcome Route
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
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