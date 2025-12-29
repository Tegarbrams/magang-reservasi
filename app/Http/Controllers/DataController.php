<?php

namespace App\Http\Controllers;

use App\Models\PaketMenu;
use App\Models\Ruangan;
use App\Models\Fasilitas;
use App\Models\MenuTambahan;

class DataController extends Controller
{
    public function paketMenu()
    {
        return response()->json(PaketMenu::select('id', 'nama', 'harga', 'deskripsi')->get());
    }

    public function ruangan()
    {
        return response()->json(Ruangan::select('id', 'nama', 'harga', 'kapasitas')->get());
    }

    public function fasilitas()
    {
        return response()->json(Fasilitas::select('id', 'nama', 'harga')->get());
    }

    public function menuTambahan()
    {
        return response()->json(MenuTambahan::select('id', 'nama', 'harga')->get());
    }
}
