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

    protected $casts = [
        'tanggal' => 'date',
        'total_harga' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'sisa_pembayaran' => 'decimal:2',
    ];

    // ✅ PENTING: Append custom attributes
    protected $appends = ['paket_menu_obj', 'ruangan_obj'];

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
    // RELASI - GUNAKAN NAMA BERBEDA
    // ============================================
    
    public function paketMenu()
    {
        return $this->belongsTo(PaketMenu::class, 'paket_menu', 'id');
    }

    public function ruanganRel()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan', 'id');
    }

    // ✅ ACCESSOR: Supaya bisa akses $reservasi->paket_menu_obj
    public function getPaketMenuObjAttribute()
    {
        return $this->paketMenu;
    }

    // ✅ ACCESSOR: Supaya bisa akses $reservasi->ruangan_obj
    public function getRuanganObjAttribute()
    {
        return $this->ruanganRel;
    }

    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'reservasi_fasilitas',
            'reservasi_id',
            'fasilitas_id'
        );
    }

    public function menuTambahan()
    {
        return $this->belongsToMany(
            MenuTambahan::class,
            'reservasi_menu_tambahans',
            'reservasi_id',
            'menu_tambahan_id'
        )->withPivot('qty')->withTimestamps();
    }
}