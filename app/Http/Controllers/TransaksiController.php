<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TransaksiController extends Controller
{
    public function index()
    {
        // ambil data dari orders
        $transaksis = Order::orderBy('created_at', 'desc')->get();

        return view('admin.pantau_transaksi', compact('transaksis'));
    }

    public function show($id)
    {
        $trx = Order::with('items')->findOrFail($id);

        return view('admin.detail_transaksi', compact('trx'));
    }
}