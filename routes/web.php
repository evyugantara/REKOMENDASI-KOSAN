<?php

use App\Http\Controllers\Admin\AdminKostController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kost', [HomeController::class, 'cariKost'])->name('kost.index');
Route::get('/kost/{kost}', [HomeController::class, 'detailKost'])->name('kost.detail');

// ==================== AUTH ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==================== USER (MAHASISWA) ROUTES ====================
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    // Rekomendasi (Mahasiswa)
    Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
    Route::post('/rekomendasi/simpan', [RekomendasiController::class, 'simpanPreferensi'])->name('rekomendasi.simpan');
    Route::get('/rekomendasi/hasil', [RekomendasiController::class, 'hasil'])->name('rekomendasi.hasil');
    Route::post('/rekomendasi/api-hitung', [RekomendasiController::class, 'apiHitung'])->name('rekomendasi.api');

    // Ulasan
    Route::post('/kost/{kost}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::delete('/ulasan/{ulasan}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
});

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminKostController::class, 'dashboard'])->name('dashboard');

    // CRUD Kost
    Route::get('/kost', [AdminKostController::class, 'index'])->name('kost.index');
    Route::get('/kost/tambah', [AdminKostController::class, 'create'])->name('kost.create');
    Route::post('/kost', [AdminKostController::class, 'store'])->name('kost.store');
    Route::get('/kost/{kost}/edit', [AdminKostController::class, 'edit'])->name('kost.edit');
    Route::put('/kost/{kost}', [AdminKostController::class, 'update'])->name('kost.update');
    Route::delete('/kost/{kost}', [AdminKostController::class, 'destroy'])->name('kost.destroy');
    Route::delete('/kost-foto/{foto}', [AdminKostController::class, 'hapusFoto'])->name('kost.hapusFoto');

    // User Management
    Route::get('/users', [AdminKostController::class, 'manageUsers'])->name('users');

    // Ulasan Management
    Route::get('/ulasan', [AdminKostController::class, 'manageUlasan'])->name('ulasan');
    Route::patch('/ulasan/{ulasan}/approve', [AdminKostController::class, 'approveUlasan'])->name('ulasan.approve');
});
