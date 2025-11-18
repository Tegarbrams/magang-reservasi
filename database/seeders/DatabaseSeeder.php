<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaketMenu;
use App\Models\Ruangan;
use App\Models\Fasilitas;
use App\Models\MenuTambahan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Paket Menu
        PaketMenu::create([
            'nama' => 'Paket Premium Suite',
            'harga' => 1500000,
            'deskripsi' => 'Suite room dengan fasilitas premium',
            'stock' => 3,
        ]);

        PaketMenu::create([
            'nama' => 'Paket Deluxe Room',
            'harga' => 1000000,
            'deskripsi' => 'Deluxe room yang nyaman',
            'stock' => 2,
        ]);

        PaketMenu::create([
            'nama' => 'Paket Executive Suite',
            'harga' => 2000000,
            'deskripsi' => 'Executive suite dengan pemandangan kota',
            'stock' => 0, // Tidak tersedia
        ]);

        PaketMenu::create([
            'nama' => 'Paket Presidential Suite',
            'harga' => 3500000,
            'deskripsi' => 'Suite paling mewah kami',
            'stock' => 1,
        ]);

        PaketMenu::create([
            'nama' => 'Paket Honeymoon Special',
            'harga' => 2500000,
            'deskripsi' => 'Paket spesial untuk pengantin',
            'stock' => 4,
        ]);

        PaketMenu::create([
            'nama' => 'Paket Family Package',
            'harga' => 2200000,
            'deskripsi' => 'Paket keluarga 2 kamar',
            'stock' => 2,
        ]);

        // Seed Ruangan
        Ruangan::create([
            'nama' => 'Ruang Ballroom A',
            'kapasitas' => 500,
            'harga' => 5000000,
            'deskripsi' => 'Ballroom terbesar dengan fasilitas lengkap',
        ]);

        Ruangan::create([
            'nama' => 'Ruang Ballroom B',
            'kapasitas' => 300,
            'harga' => 3000000,
            'deskripsi' => 'Ballroom dengan desain modern',
        ]);

        Ruangan::create([
            'nama' => 'Ruang Emerald',
            'kapasitas' => 150,
            'harga' => 1500000,
            'deskripsi' => 'Ruang meeting premium',
        ]);

        Ruangan::create([
            'nama' => 'Ruang Diamond',
            'kapasitas' => 100,
            'harga' => 1000000,
            'deskripsi' => 'Ruang meeting eksklusif',
        ]);

        // Seed Fasilitas
        Fasilitas::create([
            'nama' => 'Dekorasi Premium',
            'harga' => 500000,
            'deskripsi' => 'Paket dekorasi premium dengan desainer profesional',
        ]);

        Fasilitas::create([
            'nama' => 'Catering Mewah',
            'harga' => 1000000,
            'deskripsi' => 'Menu catering mewah dari chef berpengalaman',
        ]);

        Fasilitas::create([
            'nama' => 'Sound System Profesional',
            'harga' => 750000,
            'deskripsi' => 'Sound system berkualitas tinggi',
        ]);

        Fasilitas::create([
            'nama' => 'Fotografer Profesional',
            'harga' => 1500000,
            'deskripsi' => 'Dokumentasi profesional dengan 2 fotografer',
        ]);

        Fasilitas::create([
            'nama' => 'MC & Entertainment',
            'harga' => 2000000,
            'deskripsi' => 'MC profesional dan entertainment berkualitas',
        ]);

        // Seed Menu Tambahan
        MenuTambahan::create([
            'nama' => 'Appetizer Premium',
            'harga' => 150000,
            'deskripsi' => 'Pilihan appetizer premium',
        ]);

        MenuTambahan::create([
            'nama' => 'Main Course Special',
            'harga' => 200000,
            'deskripsi' => 'Main course dengan menu spesial',
        ]);

        MenuTambahan::create([
            'nama' => 'Dessert Deluxe',
            'harga' => 100000,
            'deskripsi' => 'Dessert pilihan premium',
        ]);

        MenuTambahan::create([
            'nama' => 'Minuman Premium',
            'harga' => 50000,
            'deskripsi' => 'Minuman premium pilihan',
        ]);
    }
}