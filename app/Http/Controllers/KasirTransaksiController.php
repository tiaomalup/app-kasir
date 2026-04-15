<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class KasirTransaksiController extends Controller
{
    // ==============================
    // CARI PESANAN
    // ==============================
    public function cariPesanan(Request $request)
    {
        $request->validate([
            'customer_id' => 'required'
        ]);

        $order = Transaksi::with('items')
            ->where('customer_id', $request->customer_id)
            ->where('status', 'Pending')
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'customer_id' => $order->customer_id,
                'total' => $order->total,
                'status' => $order->status,
                'service_type' => $order->service_type,
                'payment_method' => $order->payment_method ?? null,
            ],
            'items' => $order->items->map(function($item) {
                return [
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity
                ];
            })
        ]);
    }

    // ==============================
    // CHECKOUT PESANAN
    // ==============================
    public function checkout(Request $request)
    {
        $data = $request->json()->all();

        $order = Transaksi::where('customer_id', $data['customer_id'])
            ->where('status', 'Pending')
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan atau sudah dibayar'
            ]);
        }

        $order->update([
            'payment_method' => $data['metode_pembayaran'],
            'status' => 'Paid',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Checkout berhasil'
        ]);
    }

    // ==============================
    // RIWAYAT TRANSAKSI
    // ==============================
    public function riwayat()
    {
        $orders = Transaksi::with('items')
            ->where('status', 'Paid')
            ->latest()
            ->get();

        return view('kasir.riwayat', compact('orders'));
    }
}
