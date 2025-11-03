<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // ⭐ PENTING: Tentukan field yang bisa diisi
    protected $fillable = [
        'kode',
        'nama',
        'stok',
        'harga',
    ];

    // ⭐ PENTING: Cast tipe data
    protected $casts = [
        'stok' => 'integer',
        'harga' => 'decimal:2',
    ];
}
