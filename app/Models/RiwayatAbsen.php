<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAbsen extends Model
{
    /** @use HasFactory<\Database\Factories\RiwayatAbsenFactory> */
    use HasFactory;
    protected $fillable = ['siswa_id', 'tanggal', 'hari', 'is_late', 'waktu_absen', 'latitude', 'longitude', 'jenis'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
