<?php
// app/Models/Reservasi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservasi extends Model
{
    protected $table = 'reservasis';

    protected $fillable = [
        'nomor_reservasi',
        'nama',
        'no_hp',
        'email',
        'paket_menu',
        'ruangan',
        'jam_check_in',
        'total_harga',
        'bukti_pembayaran',
        'catatan',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function paketMenuRelation(): BelongsTo
    {
        return $this->belongsTo(PaketMenu::class, 'paket_menu');
    }

    public function ruanganRelation(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan');
    }

    public function fasilitas(): BelongsToMany
    {
        return $this->belongsToMany(Fasilitas::class, 'reservasi_fasilitas');
    }

    public function menuTambahan(): BelongsToMany
    {
        return $this->belongsToMany(MenuTambahan::class, 'reservasi_menu_tambahans');
    }
}