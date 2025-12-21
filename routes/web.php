<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservasiController;
use Illuminate\Support\Facades\Route;
use App\Models\PaketMenu;
use App\Models\Ruangan;
use App\Models\Fasilitas;
use App\Models\MenuTambahan;
use App\Models\Reservasi;

// =========================================
// PUBLIC ROUTES (Tanpa Auth)
// =========================================

// Landing Page
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes (Web Form)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Reservasi Public (Render View) - DATA SUBMIT VIA API
Route::get('/reservasi', function() {
    try {
        $paketMenu = PaketMenu::where('stock', '>', 0)->get();
        $ruangan = Ruangan::all();
        $fasilitas = Fasilitas::all();
        $menuTambahan = MenuTambahan::all();
        
        $reservasiRuangan = Reservasi::select('ruangan', 'jam')
            ->whereIn('status', ['pending', 'approved'])
            ->get();
        
        return view('reservasi.identitas', compact(
            'paketMenu',
            'ruangan', 
            'fasilitas',
            'menuTambahan',
            'reservasiRuangan'
        ));
    } catch (\Exception $e) {
        if (config('app.debug')) {
            throw $e;
        }
        return redirect('/')->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
    }
})->name('reservasi.index');

// Success Page
Route::get('/reservasi/success', function () {
    return view('reservasi.success');
})->name('reservasi.success');

// =========================================
// AUTHENTICATED ROUTES (Perlu Login)
// =========================================
Route::middleware(['auth'])->group(function () {
    
    // User Home
    Route::get('/home', function () {
        return view('home');
    })->name('user.home')->middleware('role:0');
    
    // User - Lihat reservasi mereka
    Route::get('/my-reservasi', function() {
        $reservasi = Reservasi::with(['paketMenu', 'ruangan'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('reservasi.dashboard', compact('reservasi'));
    })->name('user.reservasi');
    
});

// =========================================
// ADMIN ROUTES (Role = 1)
// =========================================
Route::prefix('admin')->middleware(['auth', 'role:1'])->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // ==================== RESERVASI ====================
    Route::get('/reservasi', [AdminController::class, 'reservasi'])->name('reservasi');
    Route::post('/reservasi/{id}/update-status', [AdminController::class, 'updateStatusReservasi'])->name('reservasi.update-status');
    Route::delete('/reservasi/{id}', [AdminController::class, 'deleteReservasi'])->name('reservasi.delete');
    
    // ==================== SCHEDULE MANAGEMENT ====================
    // 🔥 PERBAIKAN: Gunakan AdminScheduleController yang benar
    Route::get('/schedule-management', [AdminScheduleController::class, 'index'])->name('schedule-management');
    Route::get('/schedule/get-data', [AdminScheduleController::class, 'getData'])->name('schedule.get-data');
    Route::post('/schedule/toggle-block', [AdminScheduleController::class, 'toggleBlock'])->name('schedule.toggle-block');
    
    // ==================== PAKET MENU ====================
    Route::get('/paket-menu', [AdminController::class, 'paketMenu'])->name('paket-menu');
    Route::post('/paket-menu', [AdminController::class, 'storePaketMenu'])->name('paket-menu.store');
    Route::put('/paket-menu/{id}', [AdminController::class, 'updatePaketMenu'])->name('paket-menu.update');
    Route::delete('/paket-menu/{id}', [AdminController::class, 'deletePaketMenu'])->name('paket-menu.delete');
    
    // ==================== RUANGAN ====================
    Route::get('/ruangan', [AdminController::class, 'ruangan'])->name('ruangan');
    Route::post('/ruangan', [AdminController::class, 'storeRuangan'])->name('ruangan.store');
    Route::put('/ruangan/{id}', [AdminController::class, 'updateRuangan'])->name('ruangan.update');
    Route::delete('/ruangan/{id}', [AdminController::class, 'deleteRuangan'])->name('ruangan.delete');
    
    // ==================== FASILITAS ====================
    Route::get('/fasilitas', [AdminController::class, 'fasilitas'])->name('fasilitas');
    Route::post('/fasilitas', [AdminController::class, 'storeFasilitas'])->name('fasilitas.store');
    Route::put('/fasilitas/{id}', [AdminController::class, 'updateFasilitas'])->name('fasilitas.update');
    Route::delete('/fasilitas/{id}', [AdminController::class, 'deleteFasilitas'])->name('fasilitas.delete');
    
    // ==================== MENU TAMBAHAN ====================
    Route::get('/menu-tambahan', [AdminController::class, 'menuTambahan'])->name('menu-tambahan');
    Route::post('/menu-tambahan', [AdminController::class, 'storeMenuTambahan'])->name('menu-tambahan.store');
    Route::put('/menu-tambahan/{id}', [AdminController::class, 'updateMenuTambahan'])->name('menu-tambahan.update');
    Route::delete('/menu-tambahan/{id}', [AdminController::class, 'deleteMenuTambahan'])->name('menu-tambahan.delete');
    
    // ==================== USERS ====================
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
});