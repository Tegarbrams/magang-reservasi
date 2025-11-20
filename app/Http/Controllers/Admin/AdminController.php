<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservasi;
use App\Models\PaketMenu;
use App\Models\Ruangan;
use App\Models\Fasilitas;
use App\Models\MenuTambahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalReservasi = Reservasi::count();
        $reservasiPending = Reservasi::where('status', 'pending')->count();
        $reservasiConfirmed = Reservasi::where('status', 'confirmed')->count();
        $totalUser = User::where('role', 0)->count(); // ✅ User biasa = 0
        $totalPaketMenu = PaketMenu::count();
        $totalRuangan = Ruangan::count();
        
        $recentReservasi = Reservasi::with(['paketMenuRelation', 'ruanganRelation'])
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
            'recentReservasi'
        ));
    }

    // ==================== RESERVASI ====================
    public function reservasi()
    {
        $reservasis = Reservasi::with(['paketMenuRelation', 'ruanganRelation', 'fasilitas', 'menuTambahan'])
            ->latest()
            ->paginate(10);
        
        return view('admin.reservasi', compact('reservasis'));
    }

    public function updateStatusReservasi(Request $request, $id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);
            $reservasi->status = $request->status;
            $reservasi->save();

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
            'deskripsi' => 'nullable|string'
        ]);

        PaketMenu::create($request->all());

        return redirect()->route('admin.paket-menu')
            ->with('success', 'Paket menu berhasil ditambahkan');
    }

    public function updatePaketMenu(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $paket = PaketMenu::findOrFail($id);
        $paket->update($request->all());

        return redirect()->route('admin.paket-menu')
            ->with('success', 'Paket menu berhasil diupdate');
    }

    public function deletePaketMenu($id)
    {
        try {
            PaketMenu::findOrFail($id)->delete();
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
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string',
            'password' => 'required|min:6',
            'role' => 'required|in:0,1'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

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

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil diupdate');
    }

    public function deleteUser($id)
    {
        try {
            User::findOrFail($id)->delete();
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