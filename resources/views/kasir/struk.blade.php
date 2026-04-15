<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white w-80 p-4 shadow rounded text-sm">
    <h2 class="text-center font-bold text-lg mb-2">🍹 BOBA STORE</h2>
    <p class="text-center text-xs mb-3">Terima kasih</p>

    <div class="mb-2">
        <div>ID: <b>ORD-{{ $order->id }}</b></div>
        <div>Customer: {{ $order->customer_id ?? 'Umum' }}</div>
        <div>Tipe Layanan: {{ $order->service_type ?? 'Take Away' }}</div>
        <div>Metode: {{ strtoupper($order->payment_method ?? 'CASH') }}</div>
    </div>

    <hr class="my-2">

    @forelse($order->items ?? [] as $item)
        <div class="flex justify-between">
            <span>{{ $item->name ?? 'Item' }} x{{ $item->quantity ?? 1 }}</span>
            <span>
                Rp {{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 0, ',', '.') }}
            </span>
        </div>
    @empty
        <div class="text-center text-gray-500">- Tidak ada item -</div>
    @endforelse

    <hr class="my-2">

    <div class="flex justify-between font-bold">
        <span>Total</span>
        <span>Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</span>
    </div>

    {{-- Di bagian blade struk --}}
@php
    $paymentMethod = strtolower($order->payment_method ?? '');
    $total = $order->total ?? 0;
    
    if ($paymentMethod === 'cash') {
        // CASH: ambil dari database
        $bayar = $order->uang_masuk ?? $total;
        $kembalian = $order->kembalian ?? 0;
    } else {
        // QRIS/ lainnya: bayar = total, kembalian = 0
        $bayar = $total;
        $kembalian = 0;
    }
@endphp

<div class="flex justify-between">
    <span>Bayar</span>
    <span>Rp {{ number_format($bayar, 0, ',', '.') }}</span>
</div>

<div class="flex justify-between">
    <span>Kembalian</span>
    <span>Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
</div>
   
    <hr class="my-2">

    <p class="text-center text-xs">🙏 Selamat Menikmati</p>

    <!-- Tombol aksi (tidak ikut cetak) -->
    <div class="no-print">
        <a href="{{ route('kasir.dashboard') }}"
           class="block text-center mt-4 bg-blue-600 text-white py-2 rounded text-sm hover:bg-blue-700">
            ← Kembali ke Dashboard
        </a>
        
        <button onclick="window.print()" 
                class="block w-full text-center mt-2 bg-gray-200 text-gray-800 py-2 rounded text-sm hover:bg-gray-300">
            🖨️ Cetak Ulang
        </button>
    </div>
</div>

<script>
    // Auto print saat halaman dimuat
    window.onload = function() {
        // Beri sedikit delay untuk memastikan semua data terload
        setTimeout(() => {
            window.print();
        }, 500);
    }
</script>

</body>
</html>