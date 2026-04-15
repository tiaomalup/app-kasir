<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class MenuController extends Controller
{
    public function index()
    {
        $produk = Produk::all(); // Ambil semua data produk dari database
        return view('user.index', compact('produk')); // Kirim ke view
    }
}
