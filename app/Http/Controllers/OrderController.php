<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * =========================
     * BUAT ORDER (STATUS: PENDING)
     * =========================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customerId' => 'required|string',
            'cart' => 'required|array',
            'total' => 'required|integer',
            'serviceType' => 'required|string',
            'status' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // =========================
            // CEK STOK (TANPA KURANGI)
            // =========================
            foreach ($validated['cart'] as $item) {
                $produk = Produk::find($item['id']);

                if (!$produk) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Produk tidak ditemukan: ' . $item['name']
                    ], 400);
                }

                if ($produk->stok < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stok tidak mencukupi untuk {$item['name']}. Tersedia: {$produk->stok}, Dibutuhkan: {$item['quantity']}"
                    ], 400);
                }
            }

            // =========================
            // SIMPAN ORDER
            // =========================
            $order = Order::create([
                'customer_id' => $validated['customerId'],
                'total' => $validated['total'],
                'service_type' => $validated['serviceType'],
                'status' => 'pending', // pastikan selalu pending
            ]);

            // =========================
            // SIMPAN ITEM (TANPA KURANGI STOK)
            // =========================
            foreach ($validated['cart'] as $item) {
                $produk = Produk::find($item['id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $produk->id,
                    'name' => $produk->nama_produk,
                    'price' => $produk->harga,
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'message' => 'Order berhasil dibuat'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * =========================
     * PEMBAYARAN BERHASIL
     * (STOK DIKURANGI DI SINI)
     * =========================
     */
    public function bayar($id)
    {
        DB::beginTransaction();

        try {
            $order = Order::with('items')->findOrFail($id);

            // ❗ cegah double bayar
            if ($order->status === 'paid') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan sudah dibayar'
                ]);
            }

            // =========================
            // KURANGI STOK
            // =========================
            foreach ($order->items as $item) {
                $produk = Produk::find($item->produk_id);

                if (!$produk) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Produk dengan ID {$item->produk_id} tidak ditemukan"
                    ]);
                }

                if ($produk->stok < $item->quantity) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stok tidak cukup untuk {$item->name}. Tersedia: {$produk->stok}, Dibutuhkan: {$item->quantity}"
                    ]);
                }

                // Kurangi stok
                $produk->stok -= $item->quantity;
                $produk->save();
            }

            // =========================
            // UPDATE STATUS
            // =========================
            $order->status = 'paid';
            $order->paid_at = now();
            $order->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil & stok diperbarui',
                'redirect' => route('kasir.struk', $order->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}