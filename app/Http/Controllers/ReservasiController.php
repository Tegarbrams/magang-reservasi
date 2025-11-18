<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\PaketMenu;
use App\Models\Ruangan;
use App\Models\Fasilitas;
use App\Models\MenuTambahan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

/**
 * Class ReservasiController
 * Handle hotel reservation operations
 *
 * @package App\Http\Controllers
 */
class ReservasiController extends Controller
{
    /**
     * Display the reservation form
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $paketMenu = PaketMenu::all();
            $ruangan = Ruangan::all();
            $fasilitas = Fasilitas::all();
            $menuTambahan = MenuTambahan::all();
            $reservasiRuangan = Reservasi::select('ruangan', 'jam_check_in')
                ->where('status', '!=', 'cancelled')
                ->get();

            return view('reservasi.identitas', compact(
                'paketMenu',
                'ruangan',
                'fasilitas',
                'menuTambahan',
                'reservasiRuangan'
            ));
        } catch (Exception $e) {
            Log::error('Error di index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat halaman');
        }
    }

    /**
     * Store a new reservation
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Log data yang diterima untuk debugging
            Log::info('Data request diterima:', $request->all());

            // Validasi input
            $validated = $this->validateReservation($request);
            
            Log::info('Validasi berhasil');

            // Cek stock paket menu
            $paket = $this->checkPaketStock($validated['paket_menu']);
            
            Log::info('Stock paket tersedia: ' . $paket->stock);

            // Cek ketersediaan ruangan
            $this->checkRoomAvailability($validated['ruangan'], $validated['jam_check_in']);
            
            Log::info('Ruangan tersedia');

            // Upload bukti pembayaran
            $buktiPath = $this->uploadBuktiPembayaran($request);
            
            if ($buktiPath) {
                Log::info('Bukti pembayaran uploaded: ' . $buktiPath);
            }

            // Hitung total harga
            $totalHarga = $this->calculateTotal($validated);
            Log::info('Total harga: Rp ' . number_format($totalHarga, 0, ',', '.'));

            // Generate nomor reservasi
            $nomorReservasi = $this->generateNomorReservasi();
            Log::info('Nomor reservasi: ' . $nomorReservasi);

            // Simpan reservasi
            $reservasi = $this->saveReservasi($validated, $nomorReservasi, $totalHarga, $buktiPath);
            
            Log::info('Reservasi tersimpan dengan ID: ' . $reservasi->id);

            // Attach fasilitas dan menu tambahan
            $this->attachRelations($reservasi, $validated);

            // Kurangi stock paket menu
            $paket->decrement('stock');
            Log::info('Stock dikurangi, sisa stock: ' . $paket->fresh()->stock);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibuat',
                'nomor_reservasi' => $nomorReservasi
            ], 200);

        } catch (ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            Log::error('Error saat menyimpan reservasi: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate reservation request
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    private function validateReservation(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|regex:/^08\d{8,11}$/',
            'email' => 'required|email|max:255',
            'paket_menu' => 'required|exists:paket_menus,id',
            'ruangan' => 'required|exists:ruangans,id',
            'jam_check_in' => 'required|string',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string|max:1000',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,id',
            'menu_tambahan' => 'nullable|array',
            'menu_tambahan.*' => 'exists:menu_tambahans,id',
        ]);
    }

    /**
     * Check paket menu stock availability
     *
     * @param int $paketMenuId
     * @return PaketMenu
     * @throws Exception
     */
    private function checkPaketStock(int $paketMenuId): PaketMenu
    {
        $paket = PaketMenu::find($paketMenuId);
        
        if (!$paket) {
            throw new Exception('Paket menu tidak ditemukan');
        }

        if ($paket->stock <= 0) {
            throw new Exception('Paket menu tidak tersedia (stock habis)');
        }

        return $paket;
    }

    /**
     * Check room availability at specified time
     *
     * @param int $ruanganId
     * @param string $jamCheckIn
     * @return void
     * @throws Exception
     */
    private function checkRoomAvailability(int $ruanganId, string $jamCheckIn): void
    {
        $isBooked = Reservasi::where('ruangan', $ruanganId)
            ->where('jam_check_in', $jamCheckIn)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($isBooked) {
            throw new Exception('Ruangan sudah dipesan di jam tersebut');
        }
    }

    /**
     * Upload bukti pembayaran file
     *
     * @param Request $request
     * @return string|null
     */
    private function uploadBuktiPembayaran(Request $request): ?string
    {
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            return $file->store('bukti_pembayaran', 'public');
        }

        return null;
    }

    /**
     * Save reservation to database
     *
     * @param array $validated
     * @param string $nomorReservasi
     * @param float $totalHarga
     * @param string|null $buktiPath
     * @return Reservasi
     */
    private function saveReservasi(array $validated, string $nomorReservasi, float $totalHarga, ?string $buktiPath): Reservasi
    {
        $reservasi = new Reservasi();
        $reservasi->nomor_reservasi = $nomorReservasi;
        $reservasi->nama = $validated['nama'];
        $reservasi->no_hp = $validated['no_hp'];
        $reservasi->email = $validated['email'];
        $reservasi->paket_menu = $validated['paket_menu'];
        $reservasi->ruangan = $validated['ruangan'];
        $reservasi->jam_check_in = $validated['jam_check_in'];
        $reservasi->total_harga = $totalHarga;
        $reservasi->bukti_pembayaran = $buktiPath ?? '';
        $reservasi->catatan = $validated['catatan'] ?? null;
        $reservasi->status = 'pending';
        $reservasi->save();

        return $reservasi;
    }

    /**
     * Attach fasilitas and menu tambahan to reservation
     *
     * @param Reservasi $reservasi
     * @param array $validated
     * @return void
     */
    private function attachRelations(Reservasi $reservasi, array $validated): void
    {
        // Attach fasilitas
        if (!empty($validated['fasilitas'])) {
            $reservasi->fasilitas()->attach($validated['fasilitas']);
            Log::info('Fasilitas attached: ' . implode(', ', $validated['fasilitas']));
        }

        // Attach menu tambahan
        if (!empty($validated['menu_tambahan'])) {
            $reservasi->menuTambahan()->attach($validated['menu_tambahan']);
            Log::info('Menu tambahan attached: ' . implode(', ', $validated['menu_tambahan']));
        }
    }

    /**
     * Calculate total price of reservation
     *
     * @param array $data
     * @return float
     */
    private function calculateTotal(array $data): float
    {
        $total = 0.0;

        // Harga paket menu
        if (isset($data['paket_menu'])) {
            $paket = PaketMenu::find($data['paket_menu']);
            if ($paket) {
                $total += (float) $paket->harga;
                Log::info('Harga paket: Rp ' . number_format($paket->harga, 0, ',', '.'));
            }
        }

        // Harga ruangan
        if (isset($data['ruangan'])) {
            $ruangan = Ruangan::find($data['ruangan']);
            if ($ruangan) {
                $total += (float) $ruangan->harga;
                Log::info('Harga ruangan: Rp ' . number_format($ruangan->harga, 0, ',', '.'));
            }
        }

        // Harga fasilitas
        if (!empty($data['fasilitas'])) {
            $fasilitasTotal = Fasilitas::whereIn('id', $data['fasilitas'])->sum('harga');
            $total += (float) $fasilitasTotal;
            Log::info('Total fasilitas: Rp ' . number_format($fasilitasTotal, 0, ',', '.'));
        }

        // Harga menu tambahan
        if (!empty($data['menu_tambahan'])) {
            $menuTambahanTotal = MenuTambahan::whereIn('id', $data['menu_tambahan'])->sum('harga');
            $total += (float) $menuTambahanTotal;
            Log::info('Total menu tambahan: Rp ' . number_format($menuTambahanTotal, 0, ',', '.'));
        }

        return $total;
    }

    /**
     * Generate unique reservation number
     *
     * @return string
     */
    private function generateNomorReservasi(): string
    {
        $date = now()->format('YmdHis');
        $random = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        return 'RES-' . $date . '-' . $random;
    }
}