<?php
// app/Models/Ruangan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangans';

    protected $fillable = [
        'nama',
        'kapasitas',
        'harga',
        'deskripsi',
    ];

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'ruangan');
    }
}