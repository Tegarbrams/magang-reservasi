<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Models\BlockedSchedule;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

// =========================================
// PUBLIC API ENDPOINTS (Tanpa Auth)
// =========================================

// Authentication API
Route::post('/register', [AuthController::class, 'apiRegister']);
Route::post('/login', [AuthController::class, 'apiLogin']);

// Reservasi Publik (Tanpa perlu login)
Route::post('/reservasi', [ReservasiController::class, 'store']);

// =========================================
// CHECK AVAILABLE SLOTS - FIXED
// =========================================
Route::get('/check-available-slots', function (Request $request) {
    try {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date'
        ]);

        $tanggal = Carbon::parse($request->tanggal);
        $ruanganId = $request->ruangan_id;
        
        \Log::info('Checking available slots', [
            'ruangan_id' => $ruanganId,
            'tanggal' => $tanggal->format('Y-m-d')
        ]);
        
        // Generate all possible time slots (08:00 - 18:00)
        $allSlots = [];
        for ($hour = 8; $hour <= 18; $hour++) {
            $allSlots[] = sprintf('%02d:00', $hour);
        }

        // Get blocked slots from BlockedSchedule (both manual and auto)
        $blockedSlots = BlockedSchedule::where('ruangan_id', $ruanganId)
            ->where('tanggal', $tanggal->format('Y-m-d'))
            ->pluck('jam')
            ->toArray();

        \Log::info('Blocked slots from BlockedSchedule', ['slots' => $blockedSlots]);

        // Get approved/pending reservations (using 'jam' field, not jam_check_in)
        $reservedSlots = Reservasi::where('ruangan', $ruanganId)
            ->where('tanggal', $tanggal->format('Y-m-d'))
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('jam') // PERBAIKAN: gunakan 'jam' bukan 'jam_check_in'
            ->toArray();

        \Log::info('Reserved slots from Reservasi', ['slots' => $reservedSlots]);

        // Combine all unavailable slots
        $unavailableSlots = array_values(array_unique(array_merge($blockedSlots, $reservedSlots)));
        
        // Determine available slots
        $availableSlots = array_values(array_diff($allSlots, $unavailableSlots));

        \Log::info('Final result', [
            'available' => $availableSlots,
            'unavailable' => $unavailableSlots
        ]);

        return response()->json([
            'status' => true,
            'data' => [
                'available_slots' => $availableSlots,
                'unavailable_slots' => $unavailableSlots,
                'message' => count($availableSlots) . ' slot tersedia dari ' . count($allSlots) . ' total slot'
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi gagal',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        \Log::error('Error in check-available-slots: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
});

// =========================================
// AUTHENTICATED API ENDPOINTS
// =========================================
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'apiLogout']);

    // User - Lihat reservasi mereka sendiri
    Route::get('/reservasi', [ReservasiController::class, 'index']);

    // =========================================
    // ADMIN API ENDPOINTS (Role = 1)
    // =========================================
    Route::middleware('role:1')->prefix('admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'apiDashboard']);

        // Reservasi Management
        Route::get('/reservasi', [AdminController::class, 'apiGetReservasi']);
        Route::post('/reservasi/{id}/update-status', [AdminController::class, 'updateStatusReservasi']);
        Route::delete('/reservasi/{id}', [AdminController::class, 'apiDeleteReservasi']);

        // Schedule Management - FIXED ROUTES
        Route::get('/schedule/get-data', [AdminScheduleController::class, 'getData']);
        Route::post('/schedule/toggle-block', [AdminScheduleController::class, 'toggleBlock']);

        // Paket Menu Management
        Route::get('/paket-menu', [AdminController::class, 'apiPaketMenu']);
        Route::post('/paket-menu', [AdminController::class, 'apiStorePaketMenu']);
        Route::put('/paket-menu/{id}', [AdminController::class, 'apiUpdatePaketMenu']);
        Route::delete('/paket-menu/{id}', [AdminController::class, 'apiDeletePaketMenu']);

        // Ruangan Management
        Route::get('/ruangan', [AdminController::class, 'apiRuangan']);
        Route::post('/ruangan', [AdminController::class, 'apiStoreRuangan']);
        Route::put('/ruangan/{id}', [AdminController::class, 'apiUpdateRuangan']);
        Route::delete('/ruangan/{id}', [AdminController::class, 'apiDeleteRuangan']);

        // Fasilitas Management
        Route::get('/fasilitas', [AdminController::class, 'apiFasilitas']);
        Route::post('/fasilitas', [AdminController::class, 'apiStoreFasilitas']);
        Route::put('/fasilitas/{id}', [AdminController::class, 'apiUpdateFasilitas']);
        Route::delete('/fasilitas/{id}', [AdminController::class, 'apiDeleteFasilitas']);

        // Menu Tambahan Management
        Route::get('/menu-tambahan', [AdminController::class, 'apiMenuTambahan']);
        Route::post('/menu-tambahan', [AdminController::class, 'apiStoreMenuTambahan']);
        Route::put('/menu-tambahan/{id}', [AdminController::class, 'apiUpdateMenuTambahan']);
        Route::delete('/menu-tambahan/{id}', [AdminController::class, 'apiDeleteMenuTambahan']);

        // Users Management
        Route::get('/users', [AdminController::class, 'apiUsers']);
        Route::post('/users', [AdminController::class, 'apiStoreUser']);
        Route::put('/users/{id}', [AdminController::class, 'apiUpdateUser']);
        Route::delete('/users/{id}', [AdminController::class, 'apiDeleteUser']);
    });
});