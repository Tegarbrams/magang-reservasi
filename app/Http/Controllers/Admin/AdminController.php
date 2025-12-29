<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservasi;
use App\Models\PaketMenu;
use App\Models\Ruangan;
use App\Models\Fasilitas;
use App\Models\MenuTambahan;
use App\Models\BlockedSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        // Basic Stats
        $totalReservasi = Reservasi::count();
        $reservasiPending = Reservasi::where('status', 'pending')->count();
        $reservasiConfirmed = Reservasi::where('status', 'approved')->count();
        $totalUser = User::where('role', 0)->count();
        $totalPaketMenu = PaketMenu::count();
        $totalRuangan = Ruangan::count();

        // 1. PENGUNJUNG RESERVASI (Per Hari, Minggu, Bulan)
        $today = Carbon::today();
        $reservasiHariIni = Reservasi::whereDate('created_at', $today)->count();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $reservasiMingguIni = Reservasi::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $reservasiBulanIni = Reservasi::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // 2. STATISTIK STATUS RESERVASI
        $statusStats = [
            'approved' => Reservasi::where('status', 'approved')->count(),
            'pending' => Reservasi::where('status', 'pending')->count(),
            'rejected' => Reservasi::where('status', 'rejected')->count(),
            'cancelled' => Reservasi::where('status', 'cancelled')->count(),
        ];

        // 3. PENDAPATAN RESERVASI
        // Pendapatan hari ini
        $pendapatanHariIni = Reservasi::whereDate('created_at', $today)
            ->whereIn('status', ['approved', 'pending'])
            ->sum('jumlah_dibayar');

        // Pendapatan minggu ini
        $pendapatanMingguIni = Reservasi::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->whereIn('status', ['approved', 'pending'])
            ->sum('jumlah_dibayar');

        // Pendapatan bulan ini
        $pendapatanBulanIni = Reservasi::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['approved', 'pending'])
            ->sum('jumlah_dibayar');

        // Total pendapatan (all time)
        $totalPendapatan = Reservasi::whereIn('status', ['approved', 'pending'])
            ->sum('jumlah_dibayar');

        // Grafik Reservasi per Hari (7 hari terakhir)
        $last7Days = [];
        $reservasiPerHari = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $last7Days[] = $date->format('d M');
            $reservasiPerHari[] = Reservasi::whereDate('created_at', $date)->count();
        }

        // Grafik Pendapatan per Minggu (4 minggu terakhir)
        $last4Weeks = [];
        $pendapatanPerMinggu = [];
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
            $last4Weeks[] = $weekStart->format('d M');
            $pendapatanPerMinggu[] = Reservasi::whereBetween('created_at', [$weekStart, $weekEnd])
                ->whereIn('status', ['approved', 'pending'])
                ->sum('jumlah_dibayar');
        }

        $recentReservasi = Reservasi::with(['paketMenu', 'ruanganRel'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalReservasi',
            'reservasiPending',
            'reservasiConfirmed',
            'totalUser',
            'totalPaketMenu',
            'totalRuangan',
            'recentReservasi',
            // Statistik baru
            'reservasiHariIni',
            'reservasiMingguIni',
            'reservasiBulanIni',
            'statusStats',
            'pendapatanHariIni',
            'pendapatanMingguIni',
            'pendapatanBulanIni',
            'totalPendapatan',
            'last7Days',
            'reservasiPerHari',
            'last4Weeks',
            'pendapatanPerMinggu'
        ));
    }

    // ==================== RESERVASI ====================
    public function reservasi(Request $request)
    {
        $query = Reservasi::with(['paketMenu', 'ruanganRel', 'fasilitas', 'menuTambahan']);

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Tanggal Mulai
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        // Filter Tanggal Akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_reservasi', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Hitung total pendapatan dari hasil filter
        $totalPendapatan = (clone $query)->sum('jumlah_dibayar');
        $totalReservasiFiltered = (clone $query)->count();

        // Paginate hasil
        $reservasis = $query->latest()->paginate(10)->withQueryString();

        return view('admin.reservasi', compact('reservasis', 'totalPendapatan', 'totalReservasiFiltered'));
    }

    public function updateStatusReservasi(Request $request, $id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);
            $oldStatus = $reservasi->status;
            $newStatus = $request->status;

            $reservasi->status = $newStatus;
            $reservasi->save();

            // Auto block/unblock schedule based on status
            $this->syncBlockedSchedule($reservasi, $oldStatus, $newStatus);

            return response()->json([
                'success' => true,
                'message' => 'Status reservasi berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteReservasi($id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);

            // Remove blocked schedule if exists
            BlockedSchedule::where('reservasi_id', $reservasi->id)
                ->where('type', 'auto')
                ->delete();

            $reservasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus reservasi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function detailReservasi($id)
    {
        try {
            $reservasi = Reservasi::with([
                'paketMenu',
                'ruanganRel',
                'fasilitas',
                'menuTambahan'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $reservasi->id,
                    'nomor_reservasi' => $reservasi->nomor_reservasi,
                    'nama' => $reservasi->nama,
                    'email' => $reservasi->email,
                    'no_hp' => $reservasi->no_hp,
                    'tanggal' => $reservasi->tanggal,
                    'jam' => $reservasi->jam,
                    'jumlah_orang' => $reservasi->jumlah_orang,
                    'paket_menu' => $reservasi->paketMenu ? [
                        'id' => $reservasi->paketMenu->id,
                        'nama' => $reservasi->paketMenu->nama,
                        'harga' => $reservasi->paketMenu->harga
                    ] : null,
                    'ruangan' => $reservasi->ruanganRel ? [
                        'id' => $reservasi->ruanganRel->id,
                        'nama' => $reservasi->ruanganRel->nama,
                        'kapasitas' => $reservasi->ruanganRel->kapasitas,
                        'harga' => $reservasi->ruanganRel->harga
                    ] : null,
                    'fasilitas' => $reservasi->fasilitas->map(function ($f) {
                        return [
                            'id' => $f->id,
                            'nama' => $f->nama,
                            'harga' => $f->harga
                        ];
                    }),
                    'menu_tambahan' => $reservasi->menuTambahan->map(function ($m) {
                        return [
                            'id' => $m->id,
                            'nama' => $m->nama,
                            'harga' => $m->harga
                        ];
                    }),
                    'catatan' => $reservasi->catatan,
                    'total_harga' => $reservasi->total_harga,
                    'tipe_pembayaran' => $reservasi->tipe_pembayaran,
                    'jumlah_dibayar' => $reservasi->jumlah_dibayar,
                    'sisa_pembayaran' => $reservasi->sisa_pembayaran,
                    'bukti_pembayaran' => $reservasi->bukti_pembayaran,
                    'status' => $reservasi->status,
                    'created_at' => $reservasi->created_at->format('Y-m-d H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Detail Reservasi Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🔧 Helper function to sync blocked schedule
    private function syncBlockedSchedule($reservasi, $oldStatus, $newStatus)
    {
        $shouldBlock = in_array($newStatus, ['pending', 'approved']);
        $wasBlocked = in_array($oldStatus, ['pending', 'approved']);

        $jamNormalized = substr($reservasi->jam, 0, 5);

        if ($shouldBlock && !$wasBlocked) {
            BlockedSchedule::updateOrCreate(
                [
                    'ruangan_id' => $reservasi->ruangan,
                    'tanggal' => $reservasi->tanggal,
                    'jam' => $jamNormalized,
                ],
                [
                    'type' => 'auto',
                    'keterangan' => 'Reservasi: ' . $reservasi->nomor_reservasi,
                    'reservasi_id' => $reservasi->id,
                ]
            );
        } elseif (!$shouldBlock && $wasBlocked) {
            BlockedSchedule::where('ruangan_id', $reservasi->ruangan)
                ->where('tanggal', $reservasi->tanggal)
                ->where('jam', $jamNormalized)
                ->where('type', 'auto')
                ->delete();
        }
    }

    // ==================== SCHEDULE MANAGEMENT ====================
    public function scheduleManagement()
    {
        $ruangans = Ruangan::all();
        return view('admin.schedule-management', compact('ruangans'));
    }

    public function getScheduleData(Request $request)
    {
        $ruanganId = $request->ruangan_id;
        $month = $request->month ?? now()->format('Y-m');

        $startDate = Carbon::parse($month . '-01')->startOfMonth();
        $endDate = Carbon::parse($month . '-01')->endOfMonth();

        $blockedSchedules = BlockedSchedule::where('ruangan_id', $ruanganId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->with('reservasi')
            ->get();

        $scheduleData = [];

        foreach ($blockedSchedules as $blocked) {
            $label = 'Blocked';
            $type = $blocked->type;

            if ($blocked->type === 'auto' && $blocked->reservasi) {
                $label = 'Reservasi: ' . $blocked->reservasi->nama;
            } elseif ($blocked->keterangan) {
                $label = $blocked->keterangan;
            }

            $scheduleData[] = [
                'date' => $blocked->tanggal->format('Y-m-d'),
                'time' => substr($blocked->jam, 0, 5),
                'type' => $type,
                'label' => $label,
                'id' => $blocked->id
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $scheduleData
        ]);
    }

    public function toggleScheduleBlock(Request $request)
    {
        try {
            $request->validate([
                'ruangan_id' => 'required|exists:ruangans,id',
                'tanggal' => 'required|date',
                'jam' => 'required',
                'action' => 'required|in:block,unblock',
                'keterangan' => 'nullable|string',
            ]);

            $jamNormalized = substr($request->jam, 0, 5);

            if ($request->action === 'block') {
                $existingReservation = Reservasi::where('ruangan', $request->ruangan_id)
                    ->where('tanggal', $request->tanggal)
                    ->whereRaw('SUBSTRING(jam, 1, 5) = ?', [$jamNormalized])
                    ->whereIn('status', ['pending', 'approved'])
                    ->exists();

                if ($existingReservation) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jam ini sudah ada reservasi aktif. Tidak bisa diblok manual.'
                    ], 422);
                }

                BlockedSchedule::create([
                    'ruangan_id' => $request->ruangan_id,
                    'tanggal' => $request->tanggal,
                    'jam' => $jamNormalized,
                    'type' => 'manual',
                    'keterangan' => $request->keterangan ?? 'Diblok oleh admin',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal berhasil diblok'
                ]);
            } else {
                $deleted = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
                    ->where('tanggal', $request->tanggal)
                    ->where('jam', $jamNormalized)
                    ->delete();

                if ($deleted) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Blok jadwal berhasil dihapus'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Slot tidak ditemukan atau sudah terhapus'
                    ], 422);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== STOK - PAKET MENU ====================
    public function paketMenu()
    {
        $paketMenus = PaketMenu::latest()->paginate(10);
        return view('admin.paket-menu', compact('paketMenus'));
    }

    public function storePaketMenu(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // ← TAMBAHKAN
        ]);

        $data = $request->all();

        // ← TAMBAHKAN INI
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/paket-menu'), $filename);
            $data['gambar'] = 'uploads/paket-menu/' . $filename;
        }

        PaketMenu::create($data);

        return redirect()->route('admin.paket-menu')
            ->with('success', 'Paket menu berhasil ditambahkan');
    }

    public function updatePaketMenu(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // ← TAMBAHKAN
        ]);

        $paket = PaketMenu::findOrFail($id);
        $data = $request->all();

        // ← TAMBAHKAN INI
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($paket->gambar && file_exists(public_path($paket->gambar))) {
                unlink(public_path($paket->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/paket-menu'), $filename);
            $data['gambar'] = 'uploads/paket-menu/' . $filename;
        }

        $paket->update($data);

        return redirect()->route('admin.paket-menu')
            ->with('success', 'Paket menu berhasil diupdate');
    }

    public function deletePaketMenu($id)
    {
        try {
            $paket = PaketMenu::findOrFail($id);

            // ← TAMBAHKAN INI - Hapus gambar jika ada
            if ($paket->gambar && file_exists(public_path($paket->gambar))) {
                unlink(public_path($paket->gambar));
            }

            $paket->delete();

            return response()->json([
                'success' => true,
                'message' => 'Paket menu berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== STOK - RUANGAN ====================
    public function ruangan()
    {
        $ruangans = Ruangan::latest()->paginate(10);
        return view('admin.ruangan', compact('ruangans'));
    }

    public function storeRuangan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        Ruangan::create($request->all());

        return redirect()->route('admin.ruangan')
            ->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function updateRuangan(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update($request->all());

        return redirect()->route('admin.ruangan')
            ->with('success', 'Ruangan berhasil diupdate');
    }

    public function deleteRuangan($id)
    {
        try {
            Ruangan::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Ruangan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== STOK - FASILITAS ====================
    public function fasilitas()
    {
        $fasilitas = Fasilitas::latest()->paginate(10);
        return view('admin.fasilitas', compact('fasilitas'));
    }

    public function storeFasilitas(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        Fasilitas::create($request->all());

        return redirect()->route('admin.fasilitas')
            ->with('success', 'Fasilitas berhasil ditambahkan');
    }

    public function updateFasilitas(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->update($request->all());

        return redirect()->route('admin.fasilitas')
            ->with('success', 'Fasilitas berhasil diupdate');
    }

    public function deleteFasilitas($id)
    {
        try {
            Fasilitas::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Fasilitas berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== STOK - MENU TAMBAHAN ====================
    public function menuTambahan()
    {
        $menuTambahans = MenuTambahan::latest()->paginate(10);
        return view('admin.menu-tambahan', compact('menuTambahans'));
    }

    public function storeMenuTambahan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        MenuTambahan::create($request->all());

        return redirect()->route('admin.menu-tambahan')
            ->with('success', 'Menu tambahan berhasil ditambahkan');
    }

    public function updateMenuTambahan(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $menu = MenuTambahan::findOrFail($id);
        $menu->update($request->all());

        return redirect()->route('admin.menu-tambahan')
            ->with('success', 'Menu tambahan berhasil diupdate');
    }

    public function deleteMenuTambahan($id)
    {
        try {
            MenuTambahan::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Menu tambahan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== DATA USER ====================
    // public function users()
    // {
    //     $users = User::latest()->paginate(10);
    //     return view('admin.users', compact('users'));
    // }

    // public function storeUser(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'no_hp' => 'required|string',
    //         'password' => 'required|min:6',
    //         'role' => 'required|in:0,1'
    //     ]);

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'no_hp' => $request->no_hp,
    //         'password' => Hash::make($request->password),
    //         'role' => $request->role
    //     ]);

    //     return redirect()->route('admin.users')
    //         ->with('success', 'User berhasil ditambahkan');
    // }

    // public function updateUser(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $id,
    //         'no_hp' => 'required|string',
    //         'role' => 'required|in:0,1'
    //     ]);

    //     $data = $request->only(['name', 'email', 'no_hp', 'role']);

    //     if ($request->filled('password')) {
    //         $data['password'] = Hash::make($request->password);
    //     }

    //     $user->update($data);

    //     return redirect()->route('admin.users')
    //         ->with('success', 'User berhasil diupdate');
    // }

    // public function deleteUser($id)
    // {
    //     try {
    //         User::findOrFail($id)->delete();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'User berhasil dihapus'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal menghapus: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,cancelled'
        ]);

        try {
            $reservasi = Reservasi::findOrFail($id);
            $oldStatus = $reservasi->status;
            $newStatus = $request->status;

            $reservasi->status = $newStatus;
            $reservasi->save();

            if ($newStatus === 'approved' && $oldStatus === 'pending') {
                AdminScheduleController::blockScheduleOnApprove($reservasi);
                $message = 'Reservasi berhasil disetujui dan jadwal telah diblok';
            } elseif (in_array($newStatus, ['rejected', 'cancelled'])) {
                AdminScheduleController::unblockScheduleOnCancelOrReject($reservasi);
                $message = 'Status reservasi berhasil diubah dan jadwal telah dibuka kembali';
            } else {
                $message = 'Status reservasi berhasil diubah';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function approve($id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);

            $jamNormalized = substr($reservasi->jam, 0, 5);

            $isBlocked = BlockedSchedule::where('ruangan_id', $reservasi->ruangan)
                ->where('tanggal', $reservasi->tanggal)
                ->where('jam', $jamNormalized)
                ->where('type', '!=', 'manual')
                ->exists();

            if ($isBlocked) {
                return redirect()->back()->with('error', 'Jadwal sudah diblok oleh reservasi lain');
            }

            $reservasi->status = 'approved';
            $reservasi->save();

            AdminScheduleController::blockScheduleOnApprove($reservasi);

            return redirect()->back()->with('success', 'Reservasi berhasil disetujui dan jadwal telah diblok');
        } catch (\Exception $e) {
            Log::error('Error approving reservation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);
            $reservasi->status = 'rejected';
            $reservasi->save();

            AdminScheduleController::unblockScheduleOnCancelOrReject($reservasi);

            return redirect()->back()->with('success', 'Reservasi berhasil ditolak');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);
            $reservasi->status = 'cancelled';
            $reservasi->save();

            AdminScheduleController::unblockScheduleOnCancelOrReject($reservasi);

            return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan dan jadwal telah dibuka kembali');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
