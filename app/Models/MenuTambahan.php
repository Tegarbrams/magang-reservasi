<?php
// app/Models/MenuTambahan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuTambahan extends Model
{
    protected $table = 'menu_tambahans';

    protected $fillable = [
        'nama',
        'harga',
        'deskripsi',
    ];

    public function reservasis()
    {
        return $this->belongsToMany(Reservasi::class, 'reservasi_menu_tambahans');
    }
}