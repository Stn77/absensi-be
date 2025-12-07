<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    /** @use HasFactory<\Database\Factories\SiswaFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'nisn',
        'alamat',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'no_telepon',
        'jenis_kelamin',
        'foto',
        'kelas_id',
        'jurusan_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function izin()
    {
        return $this->hasMany(IzinModel::class, 'siswa_id');
    }

    public function getIzin()
    {
        $data = $this->izin()->get();
        return $data;
    }
}
