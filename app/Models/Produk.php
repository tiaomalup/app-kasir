<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'produk';

    // Kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'harga',
        'stok',
        'gambar',
    ];
}
