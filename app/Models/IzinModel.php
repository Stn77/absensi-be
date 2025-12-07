<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinModel extends Model
{
    protected $fillable = [
        'siswa_id',
        'from_date',
        'until_date',
        'jenis',
        'keperluan',
        'catatan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
