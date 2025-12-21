<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruangan_id',
        'tanggal',
        'jam',
        'keterangan',
        'type',
        'reservasi_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

    // Check if a specific time slot is blocked
    public static function isBlocked($ruanganId, $tanggal, $jam)
    {
        return self::where('ruangan_id', $ruanganId)
            ->where('tanggal', $tanggal)
            ->where('jam', $jam)
            ->exists();
    }

    // Get all blocked times for a specific date and room
    public static function getBlockedTimes($ruanganId, $tanggal)
    {
        return self::where('ruangan_id', $ruanganId)
            ->where('tanggal', $tanggal)
            ->pluck('jam')
            ->toArray();
    }
}