<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $fillable = [
        'nomor_reservasi',
        'nama',
        'email',
        'no_hp',
        'paket_menu',
        'ruangan',
        'tanggal',
        'jumlah_orang',
        'jam_check_in',
        'jam',
        'catatan',
        'total_harga',
        'tipe_pembayaran',
        'jumlah_dibayar',
        'sisa_pembayaran',
        'bukti_pembayaran',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($reservasi) {
            if (empty($reservasi->nomor_reservasi)) {
                $date = date('Ymd');
                $lastReservasi = self::whereDate('created_at', today())
                    ->orderBy('id', 'desc')
                    ->first();
                
                if ($lastReservasi && preg_match('/RSV-\d{8}-(\d{4})/', $lastReservasi->nomor_reservasi, $matches)) {
                    $number = intval($matches[1]) + 1;
                } else {
                    $number = 1;
                }
                
                $reservasi->nomor_reservasi = 'RSV-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // ============================================
    // 👇 TAMBAHKAN RELASI INI
    // ============================================
    
    public function paketMenu()
    {
        return $this->belongsTo(PaketMenu::class, 'paket_menu');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan');
    }

    // 👇 RELASI MANY-TO-MANY untuk Fasilitas
    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'reservasi_fasilitas',  // nama tabel pivot
            'reservasi_id',          // foreign key untuk reservasi
            'fasilitas_id'           // foreign key untuk fasilitas
        );
    }

    // 👇 RELASI MANY-TO-MANY untuk Menu Tambahan
    public function menuTambahan()
    {
        return $this->belongsToMany(
            MenuTambahan::class,
            'reservasi_menu_tambahans',  // nama tabel pivot
            'reservasi_id',               // foreign key untuk reservasi
            'menu_tambahan_id'            // foreign key untuk menu tambahan
        );
    }
}