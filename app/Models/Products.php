<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok_awal',
        'harga_beli',
        'harga_jual',
        'kadaluarsa',
        'deskripsi',
        'vendor',
        'gambar',
        'kategori',
        'total_stok',
        'user_id',
    ];
}
