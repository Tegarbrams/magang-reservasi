<?php
// app/Models/Fasilitas.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';

    protected $fillable = [
        'nama',
        'harga',
        'deskripsi',
    ];

    public function reservasis()
    {
        return $this->belongsToMany(Reservasi::class, 'reservasi_fasilitas');
    }
}