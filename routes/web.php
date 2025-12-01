<?php

// routes/web.php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route lupa password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// halaman home untuk user
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth', 'role:0'); // User biasa = role 0


Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');

//testt

// Admin Routes - Protected with middleware
Route::prefix('admin')->middleware(['auth', 'role:1'])->group(function () {

    // FIX: tidak pakai /admin/ lagi
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/reservasi', [AdminController::class, 'reservasi'])->name('admin.reservasi');
    Route::post('/reservasi/{id}/update-status', [AdminController::class, 'updateStatusReservasi'])->name('admin.reservasi.update-status');
    Route::delete('/reservasi/{id}', [AdminController::class, 'deleteReservasi'])->name('admin.reservasi.delete');

    Route::get('/paket-menu', [AdminController::class, 'paketMenu'])->name('admin.paket-menu');
    Route::post('/paket-menu', [AdminController::class, 'storePaketMenu'])->name('admin.paket-menu.store');
    Route::put('/paket-menu/{id}', [AdminController::class, 'updatePaketMenu'])->name('admin.paket-menu.update');
    Route::delete('/paket-menu/{id}', [AdminController::class, 'deletePaketMenu'])->name('admin.paket-menu.delete');

    Route::get('/ruangan', [AdminController::class, 'ruangan'])->name('admin.ruangan');
    Route::post('/ruangan', [AdminController::class, 'storeRuangan'])->name('admin.ruangan.store');
    Route::put('/ruangan/{id}', [AdminController::class, 'updateRuangan'])->name('admin.ruangan.update');
    Route::delete('/ruangan/{id}', [AdminController::class, 'deleteRuangan'])->name('admin.ruangan.delete');

    Route::get('/fasilitas', [AdminController::class, 'fasilitas'])->name('admin.fasilitas');
    Route::post('/fasilitas', [AdminController::class, 'storeFasilitas'])->name('admin.fasilitas.store');
    Route::put('/fasilitas/{id}', [AdminController::class, 'updateFasilitas'])->name('admin.fasilitas.update');
    Route::delete('/fasilitas/{id}', [AdminController::class, 'deleteFasilitas'])->name('admin.fasilitas.delete');

    Route::get('/menu-tambahan', [AdminController::class, 'menuTambahan'])->name('admin.menu-tambahan');
    Route::post('/menu-tambahan', [AdminController::class, 'storeMenuTambahan'])->name('admin.menu-tambahan.store');
    Route::put('/menu-tambahan/{id}', [AdminController::class, 'updateMenuTambahan'])->name('admin.menu-tambahan.update');
    Route::delete('/menu-tambahan/{id}', [AdminController::class, 'deleteMenuTambahan'])->name('admin.menu-tambahan.delete');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

