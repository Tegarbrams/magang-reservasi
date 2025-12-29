<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    // ==================== DASHBOARD (READ ONLY) ====================
    public function dashboard()
    {
        // Menggunakan logic yang sama dengan AdminController
        $totalReservasi = Reservasi::count();
        $reservasiPending = Reservasi::where('status', 'pending')->count();
        $reservasiConfirmed = Reservasi::where('status', 'approved')->count();
        $totalUser = User::where('role', 0)->count();
        $totalAdmin = User::where('role', 1)->count();

        $today = Carbon::today();
        $reservasiHariIni = Reservasi::whereDate('created_at', $today)->count();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $reservasiMingguIni = Reservasi::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $reservasiBulanIni = Reservasi::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        $statusStats = [
            'approved' => Reservasi::where('status', 'approved')->count(),
            'pending' => Reservasi::where('status', 'pending')->count(),
            'rejected' => Reservasi::where('status', 'rejected')->count(),
            'cancelled' => Reservasi::where('status', 'cancelled')->count(),
        ];

        $pendapatanHariIni = Reservasi::whereDate('created_at', $today)
            ->whereIn('status', ['approved', 'pending'])
            ->sum('jumlah_dibayar');

        $pendapatanMingguIni = Reservasi::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->whereIn('status', ['approved', 'pending'])
            ->sum('jumlah_dibayar');

        $pendapatanBulanIni = Reservasi::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['approved', 'pending'])
            ->sum('jumlah_dibayar');

        $totalPendapatan = Reservasi::whereIn('status', ['approved', 'pending'])
            ->sum('jumlah_dibayar');

        $last7Days = [];
        $reservasiPerHari = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $last7Days[] = $date->format('d M');
            $reservasiPerHari[] = Reservasi::whereDate('created_at', $date)->count();
        }

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

        return view('superadmin.dashboard', compact(
            'totalReservasi',
            'reservasiPending',
            'reservasiConfirmed',
            'totalUser',
            'totalAdmin',
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
            'pendapatanPerMinggu',
            'recentReservasi'
        ));
    }

    // ==================== RESERVASI (READ ONLY) ====================
    public function reservasi(Request $request)
    {
        $query = Reservasi::with(['paketMenu', 'ruanganRel', 'fasilitas', 'menuTambahan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_reservasi', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $totalPendapatan = (clone $query)->sum('jumlah_dibayar');
        $totalReservasiFiltered = (clone $query)->count();
        $reservasis = $query->latest()->paginate(10)->withQueryString();

        return view('superadmin.reservasi', compact('reservasis', 'totalPendapatan', 'totalReservasiFiltered'));
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
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== ADMIN MANAGEMENT (FULL CRUD) ====================
    public function admins()
    {
        // Hanya tampilkan user dengan role Admin (1) dan User biasa (0)
        $users = User::whereIn('role', [0, 1])->latest()->paginate(10);
        return view('superadmin.admins', compact('users'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string',
            'password' => 'required|min:6',
            'role' => 'required|in:0,1' // Hanya bisa buat User atau Admin
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('superadmin.admins')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function updateAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent editing Super Admin
        if ($user->role == 2) {
            return redirect()->back()->with('error', 'Tidak dapat mengedit Super Admin');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_hp' => 'required|string',
            'role' => 'required|in:0,1'
        ]);

        $data = $request->only(['name', 'email', 'no_hp', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('superadmin.admins')
            ->with('success', 'User berhasil diupdate');
    }

    public function deleteAdmin($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deleting Super Admin
            if ($user->role == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus Super Admin'
                ], 403);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }
}