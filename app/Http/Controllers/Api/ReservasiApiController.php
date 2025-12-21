<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\ScheduleBlock;
use Illuminate\Http\Request;

class ReservasiApiController extends Controller
{
    /**
     * Check available time slots untuk ruangan dan tanggal tertentu
     */
    public function checkAvailableSlots(Request $request)
    {
        try {
            $ruanganId = $request->input('ruangan_id');
            $tanggal = $request->input('tanggal');

            // Validasi input
            if (!$ruanganId || !$tanggal) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ruangan ID dan tanggal harus diisi'
                ], 400);
            }

            // Generate semua slot waktu (08:00 - 18:00)
            $allSlots = [];
            for ($hour = 8; $hour <= 18; $hour++) {
                $allSlots[] = sprintf('%02d:00', $hour);
            }

            // 1. Cek reservasi yang sudah di-booking
            // PENTING: kolom di database adalah 'ruangan' bukan 'ruangan_id'
            $bookedSlots = Reservasi::where('ruangan', $ruanganId)
                ->where('tanggal', $tanggal)
                ->whereNotIn('status', ['cancelled', 'rejected', 'ditolak']) // Exclude yang dibatalkan
                ->pluck('jam')
                ->toArray();

            // 2. Cek slot yang di-block manual oleh admin (jika ada table schedule_blocks)
            $blockedSlots = [];
            if (\Schema::hasTable('schedule_blocks')) {
                $blockColumn = \Schema::hasColumn('schedule_blocks', 'ruangan_id') ? 'ruangan_id' : 'ruangan';
                $blockedSlots = \DB::table('schedule_blocks')
                    ->where($blockColumn, $ruanganId)
                    ->where('tanggal', $tanggal)
                    ->where('is_blocked', true)
                    ->pluck('jam')
                    ->toArray();
            }

            // Gabungkan slot yang tidak tersedia
            $unavailableSlots = array_unique(array_merge($bookedSlots, $blockedSlots));

            // Hitung slot yang masih available
            $availableSlots = array_values(array_diff($allSlots, $unavailableSlots));

            return response()->json([
                'status' => true,
                'data' => [
                    'available_slots' => $availableSlots,
                    'unavailable_slots' => array_values($unavailableSlots),
                    'total_slots' => count($allSlots),
                    'available_count' => count($availableSlots),
                    'unavailable_count' => count($unavailableSlots)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit reservasi baru
     */
    public function submitReservasi(Request $request)
    {
        try {
            // Validasi request
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email',
                'no_hp' => 'required|string',
                'ruangan' => 'required|exists:ruangans,id',
                'paket_menu' => 'required|exists:paket_menus,id',
                'tanggal' => 'required|date',
                'jam' => 'required',
                'jumlah_orang' => 'required|integer|min:1',
                'dp_percentage' => 'required|in:20,50,100',
                'tipe_pembayaran' => 'required|in:dp_20,dp_50,full',
                'bukti' => 'required|image|max:5120', // Max 5MB
            ]);

            // Cek apakah slot masih available (gunakan kolom 'ruangan' bukan 'ruangan_id')
            $existingReservasi = Reservasi::where('ruangan', $validated['ruangan'])
                ->where('tanggal', $validated['tanggal'])
                ->where('jam', $validated['jam'])
                ->whereNotIn('status', ['cancelled', 'rejected', 'ditolak'])
                ->exists();

            if ($existingReservasi) {
                return response()->json([
                    'status' => false,
                    'message' => 'Maaf, slot waktu ini sudah dibooking. Silakan pilih waktu lain.'
                ], 422);
            }

            // Upload bukti pembayaran
            $buktiPath = null;
            if ($request->hasFile('bukti')) {
                $buktiPath = $request->file('bukti')->store('bukti-pembayaran', 'public');
            }

            // Hitung total harga
            $paketMenu = \App\Models\PaketMenu::findOrFail($validated['paket_menu']);
            $ruangan = \App\Models\Ruangan::findOrFail($validated['ruangan']);
            
            $totalHarga = ($paketMenu->harga * $validated['jumlah_orang']) + $ruangan->harga;

            // Tambahkan fasilitas tambahan
            $fasilitasIds = [];
            if ($request->has('fasilitas')) {
                $fasilitasIds = $request->input('fasilitas');
                $fasilitasTotal = \App\Models\Fasilitas::whereIn('id', $fasilitasIds)->sum('harga');
                $totalHarga += $fasilitasTotal;
            }

            // Tambahkan menu tambahan
            $menuIds = [];
            if ($request->has('menu_tambahan')) {
                $menuIds = $request->input('menu_tambahan');
                $menuTotal = \App\Models\MenuTambahan::whereIn('id', $menuIds)->sum('harga');
                $totalHarga += $menuTotal;
            }

            // Hitung DP
            $dpPercentage = (int) $validated['dp_percentage'];
            $dpAmount = ($totalHarga * $dpPercentage) / 100;
            $sisaBayar = $totalHarga - $dpAmount;

            // Generate nomor reservasi
            $nomorReservasi = 'RSV-' . date('Ymd') . '-' . str_pad(Reservasi::count() + 1, 4, '0', STR_PAD_LEFT);

            // Simpan reservasi (sesuaikan dengan nama kolom yang benar)
            $reservasi = Reservasi::create([
                'nomor_reservasi' => $nomorReservasi,
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'],
                'ruangan' => $validated['ruangan'], // Bukan ruangan_id
                'paket_menu' => $validated['paket_menu'], // Bukan paket_menu_id
                'tanggal' => $validated['tanggal'],
                'jam' => $validated['jam'],
                'jumlah_orang' => $validated['jumlah_orang'],
                'catatan' => $request->input('pesan'), // Kolom 'catatan' bukan 'pesan'
                'total_harga' => $totalHarga,
                'tipe_pembayaran' => $validated['tipe_pembayaran'],
                'jumlah_dibayar' => $dpAmount,
                'sisa_pembayaran' => $sisaBayar,
                'bukti_pembayaran' => $buktiPath,
                'status' => 'pending', // Default pending, admin akan konfirmasi
            ]);

            // Simpan relasi fasilitas dan menu tambahan jika ada tabel pivot
            // Uncomment jika Anda punya relasi many-to-many
            /*
            if (!empty($fasilitasIds)) {
                $reservasi->fasilitas()->attach($fasilitasIds);
            }

            if (!empty($menuIds)) {
                $reservasi->menuTambahan()->attach($menuIds);
            }
            */

            return response()->json([
                'status' => true,
                'message' => 'Reservasi berhasil dibuat! Silakan tunggu konfirmasi admin.',
                'data' => [
                    'reservasi_id' => $reservasi->id,
                    'nomor_reservasi' => $nomorReservasi,
                    'total_harga' => $totalHarga,
                    'dp_amount' => $dpAmount,
                    'sisa_bayar' => $sisaBayar
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}