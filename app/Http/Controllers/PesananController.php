<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $orders = Pesanan::all();
        return view('manajemen', compact('orders'));
    }
}
