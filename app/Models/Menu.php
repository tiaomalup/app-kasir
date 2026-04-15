<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';  // nama tabel di database
    protected $fillable = ['nama', 'harga', 'gambar']; // kolom yang bisa diisi massal
}
