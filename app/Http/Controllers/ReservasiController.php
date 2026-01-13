<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\PaketMenu;
use App\Models\Ruangan;
use App\Models\Fasilitas;
use App\Models\MenuTambahan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\BlockedSchedule; // Tambahan
use Carbon\Carbon;

class ReservasiController extends Controller
{
    /**
     * Get available time slots untuk ruangan tertentu pada tanggal tertentu
     * Endpoint: GET /api/check-available-slots?ruangan_id=1&tanggal=2025-12-15
     */
    public function getAvailableSlots(Request $request)
    {
        try {
            $ruanganId = $request->input('ruangan_id');
            $tanggal = $request->input('tanggal');

            if (!$ruanganId || !$tanggal) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ruangan ID dan Tanggal harus diisi'
                ], 400);
            }

            // Jam operasional (08:00 - 18:00)
            $jamOperasional = [];
            for ($i = 8; $i <= 18; $i++) {
                $jamOperasional[] = sprintf('%02d:00', $i);
            }

            // Ambil slot yang diblok (dari reservasi pending/approved DAN BlockedSchedule)
            $bookedSlots = Reservasi::where('ruangan', $ruanganId)
                ->where('tanggal', $tanggal)
                ->whereIn('status', ['pending', 'approved'])
                ->pluck('jam_check_in')
                ->toArray();

            $blockedSlots = BlockedSchedule::where('ruangan_id', $ruanganId)
                ->where('tanggal', $tanggal)
                ->pluck('jam')
                ->toArray();

            // Gabungkan dan unik
            $unavailableSlots = array_unique(array_merge($bookedSlots, $blockedSlots));

            // Filter jam yang available
            $availableSlots = array_values(array_diff($jamOperasional, $unavailableSlots));

            // Jika tanggal adalah hari ini, filter jam yang sudah lewat
            $today = Carbon::now()->format('Y-m-d');
            $currentHour = Carbon::now()->hour;

            if ($tanggal === $today) {
                $availableSlots = array_filter($availableSlots, function ($jam) use ($currentHour) {
                    $jamHour = (int) substr($jam, 0, 2);
                    return $jamHour > $currentHour;
                });
                $availableSlots = array_values($availableSlots);
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'ruangan_id' => $ruanganId,
                    'tanggal' => $tanggal,
                    'jam_operasional' => $jamOperasional,
                    'unavailable_slots' => $unavailableSlots, // Tambahan untuk JS tampil blocked
                    'available_slots' => $availableSlots
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check apakah slot waktu tertentu tersedia
     * Endpoint: POST /api/check-availability
     */
    public function checkAvailability(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ruangan_id' => 'required|exists:ruangans,id',
                'tanggal' => 'required|date',
                'jam' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $isBooked = Reservasi::where('ruangan', $request->ruangan_id)
                ->where('tanggal', $request->tanggal)
                ->where('jam_check_in', $request->jam)
                ->whereIn('status', ['pending', 'approved'])
                ->exists();

            $isBlocked = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
                ->where('tanggal', $request->tanggal)
                ->where('jam', $request->jam)
                ->exists();

            $isUnavailable = $isBooked || $isBlocked;

            return response()->json([
                'status' => true,
                'available' => !$isUnavailable,
                'message' => $isUnavailable ? 'Slot tidak tersedia' : 'Slot tersedia'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store reservasi (dipanggil dari API)
     * Endpoint: POST /api/reservasi
     */
    public function store(Request $request)
    {
        // VALIDASI (Tambah dp_percentage)
        $validator = Validator::make($request->all(), [
            'nama'              => 'required|string|max:255',
            'no_hp'             => 'required|string|max:20',
            'email'             => 'required|email',
            'paket_menu'        => 'required|exists:paket_menus,id',
            'ruangan'           => 'required|exists:ruangans,id',
            'jam'               => 'required|string',
            'tanggal'           => 'required|date|after_or_equal:today',
            'jumlah_orang'      => 'required|integer|min:1',
            'fasilitas'         => 'array|nullable',
            'fasilitas.*'       => 'exists:fasilitas,id',
            'menu_tambahan'     => 'array|nullable',
            'menu_tambahan.*'   => 'string',
            'bukti'             => 'required|image|max:2048',
            'pesan'             => 'nullable|string',
            'dp_percentage'     => 'required|in:20,50,100', // Tambahan
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // CEK STOCK PAKET (sama)
            $paket = PaketMenu::find($request->paket_menu);
            if (!$paket || $paket->stock < 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Stock paket tidak tersedia'
                ], 400);
            }

            // CEK KAPASITAS RUANGAN (sama)
            $ruangan = Ruangan::find($request->ruangan);
            if ($request->jumlah_orang > $ruangan->kapasitas) {
                return response()->json([
                    'status' => false,
                    'message' => "Jumlah orang melebihi kapasitas ruangan (max {$ruangan->kapasitas})"
                ], 400);
            }

            // CEK BENTROK (Double check, include BlockedSchedule)
            $existingReservasi = Reservasi::where('ruangan', $request->ruangan)
                ->where('tanggal', $request->tanggal)
                ->where('jam_check_in', $request->jam)
                ->whereIn('status', ['pending', 'approved'])
                ->exists();

            $existingBlock = BlockedSchedule::where('ruangan_id', $request->ruangan)
                ->where('tanggal', $request->tanggal)
                ->where('jam', $request->jam)
                ->exists();

            if ($existingReservasi || $existingBlock) {
                return response()->json([
                    'status' => false,
                    'message' => 'Maaf, slot waktu ini tidak tersedia.'
                ], 409);
            }

            // UPLOAD FOTO (sama)
            $fileName = null;
            if ($request->hasFile('bukti')) {
                $fileName = time() . '_' . $request->file('bukti')->getClientOriginalName();
                $request->file('bukti')->storeAs('public/bukti_pembayaran', $fileName);
            }

            // HITUNG TOTAL (sama)
            $total = 0;
            $total += $paket->harga * $request->jumlah_orang;
            $total += $ruangan->harga;

            $fasilitasIds = [];
            if ($request->fasilitas) {
                $fasilitasItems = Fasilitas::whereIn('id', $request->fasilitas)->get();
                $total += $fasilitasItems->sum('harga');
                $fasilitasIds = $fasilitasItems->pluck('id')->toArray();
            }

            $menuTambahanData = [];
            if ($request->menu_tambahan) {
                foreach ($request->menu_tambahan as $menuItem) {
                    // Format: "id:qty" atau "id" saja
                    $parts = explode(':', $menuItem);
                    $menuId = $parts[0];
                    $qty = isset($parts[1]) ? (int)$parts[1] : 1;

                    $menu = MenuTambahan::find($menuId);
                    if ($menu) {
                        $total += $menu->harga * $qty;
                        $menuTambahanData[$menuId] = ['qty' => $qty];
                    }
                }
            }

            // SIMPAN DATA RESERVASI (Tambah dp_percentage)
            // Hitung DP dan Sisa Pembayaran
            $dpPercentage = $request->dp_percentage;
            $jumlahDibayar = round(($total * $dpPercentage) / 100);
            $sisaPembayaran = $total - $jumlahDibayar;

            // Tentukan tipe pembayaran
            $tipePembayaran = match ($dpPercentage) {
                '20' => 'dp_20',
                '50' => 'dp_50',
                '100' => 'full',
                default => 'full'
            };

            // SIMPAN DATA RESERVASI
            $reservasi = Reservasi::create([
                'nama'              => $request->nama,
                'no_hp'             => $request->no_hp,
                'email'             => $request->email,
                'paket_menu'        => $request->paket_menu,
                'ruangan'           => $request->ruangan,
                'jam_check_in'      => $request->jam,
                'jam'               => $request->jam,  // 👈 TAMBAHKAN
                'tanggal'           => $request->tanggal,
                'jumlah_orang'      => $request->jumlah_orang,
                'bukti_pembayaran'  => $fileName,
                'catatan'           => $request->pesan,
                'total_harga'       => $total,
                'tipe_pembayaran'   => $tipePembayaran,      // 👈 TAMBAHKAN
                'jumlah_dibayar'    => $jumlahDibayar,       // 👈 TAMBAHKAN
                'sisa_pembayaran'   => $sisaPembayaran,      // 👈 TAMBAHKAN
                'status'            => 'pending',
            ]);

            // ATTACH FASILITAS & MENU (sama)
            if (!empty($fasilitasIds)) {
                $reservasi->fasilitas()->attach($fasilitasIds);
            }
            if (!empty($menuTambahanData)) {
                $reservasi->menuTambahan()->attach($menuTambahanData);
            }

            // KURANGI STOCK (sama)
            $paket->decrement('stock');

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Reservasi berhasil dibuat',
                'data'    => [
                    'nomor_reservasi' => $reservasi->nomor_reservasi,
                    'nama' => $reservasi->nama,
                    'total_harga' => $reservasi->total_harga,
                    'dp_percentage' => $reservasi->dp_percentage, // Tambahan
                    'status' => $reservasi->status,
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get reservasi via API
     * Endpoint: GET /api/reservasi
     */
    public function index(Request $request)
    {
        try {
            $reservasi = Reservasi::with(['paketMenu', 'ruangan', 'fasilitas', 'menuTambahan'])
                ->latest()
                ->paginate(10);

            return response()->json([
                'status' => true,
                'data' => $reservasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
