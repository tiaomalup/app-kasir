<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-6" id="printArea">

    <!-- HEADER -->
    <div class="text-center border-b pb-4 mb-4">
        <h1 class="text-2xl font-bold text-blue-900">Boba Bliss</h1>
        <p class="text-sm text-gray-500">Struk Transaksi</p>
    </div>

    <!-- INFO -->
    <div class="mb-4 text-sm">
        <p><strong>Order ID:</strong> #ORD-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Tanggal Bayar:</strong>
            {{ $trx->paid_at ? \Carbon\Carbon::parse($trx->paid_at)->format('d M Y, H:i') : '-' }}
        </p>
        <p><strong>Metode:</strong> {{ $trx->payment_method ?? '-' }}</p>
        <p><strong>Status:</strong> {{ strtoupper($trx->status) }}</p>
    </div>

    <!-- LIST ITEM -->
    <table class="w-full text-sm mb-4">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($trx->items as $item)
            <tr class="border-b">
                <td class="py-2">{{ $item->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">
                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="text-right text-lg font-bold">
        Total: Rp {{ number_format($trx->total, 0, ',', '.') }}
    </div>

    <!-- FOOTER -->
    <div class="text-center text-xs text-gray-500 mt-6">
        Terima kasih telah berbelanja 💖
    </div>

</div>

<!-- BUTTON -->
<div class="max-w-2xl mx-auto mt-4 flex justify-between">

    <a href="/admin/transaksi"
       class="bg-gray-500 text-white px-4 py-2 rounded">
        Kembali
    </a>

    <button onclick="printStruk()"
        class="bg-green-500 text-white px-4 py-2 rounded">
        Print
    </button>

</div>

<!-- SCRIPT PRINT -->
<script>
function printStruk() {
    var content = document.getElementById('printArea').innerHTML;
    var original = document.body.innerHTML;

    document.body.innerHTML = content;
    window.print();
    document.body.innerHTML = original;
    location.reload();
}
</script>

</body>
</html>