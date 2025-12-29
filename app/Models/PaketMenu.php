<?php
// app/Models/PaketMenu.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketMenu extends Model
{
    protected $table = 'paket_menus';

    protected $fillable = [
        'nama',
        'harga',
        'deskripsi',
        'stock',
         'gambar',
    ];

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'paket_menu');
    }
}