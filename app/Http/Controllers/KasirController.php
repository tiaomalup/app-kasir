<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    /**
     * =============================
     * HALAMAN LOG ACTIVITY
     * =============================
     */
    public function activity()
    {
        $logs = LogActivity::latest()->paginate(10);
        return view('admin.logactivity', compact('logs'));
    }

    /**
     * =============================
     * SIMPAN LOG ACTIVITY
     * =============================
     */
    public function logActivity($action, $description = null)
    {
        try {
            LogActivity::create([
                'user_id' => auth('kasir')->check() ? auth('kasir')->user()->id : null,
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip()
            ]);
        } catch (\Exception $e) {
            Log::error('Log Activity Error: ' . $e->getMessage());
        }
    }

    /**
     * =============================
     * DASHBOARD KASIR
     * =============================
     */
    public function dashboard()
{
    $orders = Order::with('items')
        ->where('status', 'pending') // 🔥 FILTER DI SINI
        ->orderBy('created_at', 'desc')
        ->get();

    $this->logActivity('OPEN DASHBOARD', 'Kasir membuka dashboard');

    return view('kasir.dashboard', compact('orders'));
}

    /**
     * =============================
     * CARI PESANAN
     * =============================
     */
    public function cariPesanan(Request $request)
    {
        try {
            $orderId = $request->query('id');

            if (!$orderId) {
                return redirect()->route('kasir.dashboard')
                    ->with('error', 'Masukkan ID pesanan');
            }

            $order = Order::with('items')->find($orderId);

            if (!$order) {
                return redirect()->route('kasir.dashboard')
                    ->with('error', 'Pesanan tidak ditemukan');
            }

            $this->logActivity(
                'SEARCH ORDER',
                'Kasir mencari pesanan ID ' . $order->id
            );

            $midtransClientKey = config('services.midtrans.client_key');

            return view('kasir.cari-pesanan', [
                'order' => $order,
                'midtransClientKey' => $midtransClientKey
            ]);

        } catch (\Exception $e) {
            Log::error('Cari Pesanan Error: ' . $e->getMessage());
            return redirect()->route('kasir.dashboard')
                ->with('error', 'Terjadi kesalahan');
        }
    }

    /**
     * =============================
     * BAYAR QRIS (MIDTRANS)
     * =============================
     */
    public function bayarQris(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id'
            ]);

            $order = Order::with('items')->findOrFail($request->order_id);

            if ($order->status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order sudah dibayar'
                ]);
            }

            // Set konfigurasi Midtrans
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $items = [];

            foreach ($order->items as $item) {
                $items[] = [
                    'id' => (string)$item->id,
                    'price' => (int)$item->price,
                    'quantity' => (int)$item->quantity,
                    'name' => substr($item->name, 0, 50)
                ];
            }

            // Generate order_id yang unik untuk Midtrans
            $midtransOrderId = 'ORDER-' . $order->id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $midtransOrderId,
                    'gross_amount' => (int)$order->total
                ],
                'item_details' => $items,
                'customer_details' => [
                    'first_name' => 'Customer',
                    'email' => 'customer@example.com',
                    'phone' => '08123456789'
                ],
                'enabled_payments' => [
                    'qris',
                    'gopay',
                    'shopeepay',
                    'bank_transfer',
                    'credit_card'
                ],
                'callbacks' => [
                    'finish' => route('kasir.struk', $order->id),
                    'error' => route('kasir.dashboard')
                ]
            ];

            // Dapatkan Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan midtrans_order_id ke database
            $order->update([
                'midtrans_order_id' => $midtransOrderId,
                'payment_method' => 'qris'
            ]);

            $this->logActivity(
                'QRIS PAYMENT',
                'Kasir membuat pembayaran QRIS untuk order ID ' . $order->id
            );

            return response()->json([
                'success' => true,
                'token' => $snapToken,
                'message' => 'QRIS berhasil dibuat'
            ]);

        } catch (\Exception $e) {
            Log::error('QRIS Error: ' . $e->getMessage());
            Log::error('QRIS Error Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat QRIS: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * =============================
     * UPDATE STATUS QRIS (SETELAH BAYAR)
     * =============================
     */
    public function updateStatusQris(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id'
            ]);

            // Panggil fungsi bayar dari OrderController untuk mengurangi stok
            $orderController = new OrderController();
            $response = $orderController->bayar($request->order_id);
            $data = json_decode($response->getContent(), true);

            if (!$data['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $data['message']
                ]);
            }

            // Update payment method
            $order = Order::find($request->order_id);
            $order->update([
                'payment_method' => 'qris'
            ]);

            $this->logActivity(
                'QRIS PAYMENT SUCCESS',
                'Pembayaran QRIS berhasil untuk order ID ' . $order->id
            );

            return response()->json([
                'success' => true,
                'redirect' => route('kasir.struk', $order->id)
            ]);

        } catch (\Exception $e) {
            Log::error('Update Status QRIS Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal update status: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * =============================
     * CEK STATUS PEMBAYARAN
     * =============================
     */
    public function cekStatus($id)
    {
        try {
            $order = Order::findOrFail($id);

            return response()->json([
                'status' => $order->status,
                'redirect' => $order->status === 'paid' ? route('kasir.struk', $order->id) : null
            ]);

        } catch (\Exception $e) {
            Log::error('Cek Status Error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal cek status'
            ]);
        }
    }

    /**
     * =============================
     * BAYAR CASH
     * =============================
     */
    public function bayarCash(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id',
                'uang_masuk' => 'required|numeric|min:0'
            ]);

            $order = Order::findOrFail($request->order_id);

            if ($order->status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order sudah dibayar'
                ]);
            }

            if ($request->uang_masuk < $order->total) {
                return response()->json([
                    'success' => false,
                    'message' => 'Uang tidak cukup. Minimal: Rp ' . number_format($order->total, 0, ',', '.')
                ]);
            }

            // Panggil fungsi bayar dari OrderController untuk mengurangi stok
            $orderController = new OrderController();
            $response = $orderController->bayar($request->order_id);
            $data = json_decode($response->getContent(), true);

            if (!$data['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $data['message']
                ]);
            }

            $kembalian = $request->uang_masuk - $order->total;

            // Update dengan informasi cash
            $order->update([
                'payment_method' => 'cash',
                'uang_masuk' => $request->uang_masuk,
                'kembalian' => $kembalian
            ]);

            $this->logActivity(
                'CASH PAYMENT',
                'Pembayaran cash order ID ' . $order->id . ' dengan uang masuk Rp ' . number_format($request->uang_masuk, 0, ',', '.')
            );

            return response()->json([
                'success' => true,
                'kembalian' => $kembalian,
                'redirect' => route('kasir.struk', $order->id)
            ]);

        } catch (\Exception $e) {
            Log::error('Cash Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Pembayaran gagal: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * =============================
     * CALLBACK MIDTRANS (WEBHOOK)
     * =============================
     */
    public function callback(Request $request)
    {
        Log::info('Midtrans Callback Received', $request->all());

        try {
            $orderId = $request->order_id;
            
            // Cari order berdasarkan midtrans_order_id
            $order = Order::with('items')->where('midtrans_order_id', $orderId)->first();

            if ($order && $request->transaction_status == 'settlement') {
                
                // Panggil fungsi bayar dari OrderController untuk mengurangi stok
                $orderController = new OrderController();
                $response = $orderController->bayar($order->id);
                $data = json_decode($response->getContent(), true);

                if ($data['success']) {
                    // Update payment method jika belum di-set
                    if (!$order->payment_method) {
                        $order->update(['payment_method' => 'qris']);
                    }

                    $this->logActivity(
                        'QRIS CALLBACK',
                        'Pembayaran QRIS berhasil via callback untuk order ' . $order->id
                    );
                    
                    Log::info('Order updated to paid via callback', ['order_id' => $order->id]);
                } else {
                    Log::error('Callback - Failed to update order: ' . ($data['message'] ?? 'Unknown error'));
                }
            } elseif ($order && $request->transaction_status == 'pending') {
                Log::info('Payment pending', ['order_id' => $order->id]);
            } elseif ($order && $request->transaction_status == 'expire') {
                Log::info('Payment expired', ['order_id' => $order->id]);
            }

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }

    /**
     * =============================
     * STRUK PEMBAYARAN
     * =============================
     */
    public function struk($id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->status !== 'paid') {
            return redirect()->route('kasir.dashboard')
                ->with('error', 'Pesanan belum dibayar');
        }

        $this->logActivity(
            'PRINT RECEIPT',
            'Kasir mencetak struk order ' . $order->id
        );

        return view('kasir.struk', compact('order'));
    }

    /**
     * =============================
     * RIWAYAT TRANSAKSI
     * =============================
     */
    public function riwayat()
    {
        $orders = Order::with('items')
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kasir.riwayat', compact('orders'));
    }

    /**
     * =============================
     * RESET ORDER (UNTUK DEBUGGING)
     * =============================
     */
    public function resetOrder($id)
    {
        try {
            $order = Order::with('items')->findOrFail($id);
            
            // Kembalikan stok jika order sudah paid
            if ($order->status === 'paid') {
                DB::beginTransaction();
                try {
                    foreach ($order->items as $item) {
                        $produk = Produk::find($item->produk_id);
                        if ($produk) {
                            $produk->increment('stok', $item->quantity);
                            Log::info("Reset - Stok produk {$produk->nama_produk} dikembalikan {$item->quantity}, total: {$produk->stok}");
                        }
                    }
                    
                    $order->update([
                        'status' => 'pending',
                        'payment_method' => null,
                        'uang_masuk' => null,
                        'kembalian' => null,
                        'paid_at' => null,
                        'midtrans_order_id' => null
                    ]);
                    
                    DB::commit();
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            } else {
                $order->update([
                    'status' => 'pending',
                    'payment_method' => null,
                    'uang_masuk' => null,
                    'kembalian' => null,
                    'paid_at' => null,
                    'midtrans_order_id' => null
                ]);
            }
            
            $this->logActivity(
                'RESET ORDER',
                'Reset order ID ' . $id . ' ke status pending (debugging)'
            );
            
            return redirect()->back()->with('success', 'Order berhasil direset ke status pending');
            
        } catch (\Exception $e) {
            Log::error('Reset Order Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal reset order: ' . $e->getMessage());
        }
    }

    /**
     * =============================
     * LOGOUT
     * =============================
     */
    public function logout()
    {
        $this->logActivity(
            'LOGOUT',
            'Kasir logout dari sistem'
        );

        auth('kasir')->logout();

        return redirect()->route('kasir.login');
    }
}