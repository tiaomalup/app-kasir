<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi - Boba Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .emoji-sidebar {
            transition: all 0.2s ease;
        }
        .emoji-sidebar a {
            transition: all 0.2s ease;
        }
        .emoji-sidebar a:hover {
            transform: scale(1.1);
            background-color: #fef3c7;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="flex min-h-screen">

    
    <!-- ========== SIDEBAR KEDUA (MENU KASIR DENGAN TEKS) ========== -->
    <aside class="w-full md:w-64 bg-white border-r border-gray-100 p-6 flex flex-col">
        <div class="flex items-center space-x-3 mb-10">
            <img src="{{ asset('boba.png') }}" class="w-10 h-10 object-contain" onerror="this.style.display='none'"/>
            <h1 class="text-xl font-bold text-gray-800">Boba <span class="text-yellow-500">Bliss</span></h1>
        </div>

        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Menu Kasir</h2>
        <div class="space-y-3">
            <a href="{{ route('kasir.dashboard') }}" 
               class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl border border-gray-200 transition-all duration-200 hover:bg-gray-50 text-gray-600 font-medium">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('kasir.menus') }}" 
               class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl border border-gray-200 transition-all duration-200 hover:bg-gray-50 text-gray-600 font-medium">
                <i class="fas fa-utensils"></i>
                <span>Daftar Menu</span>
            </a>

            <a href="{{ url('/kasir/riwayat') }}" 
               class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl border border-yellow-400 bg-yellow-50 text-yellow-700 font-medium">
                <i class="fas fa-history"></i>
                <span>Riwayat Transaksi</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-6 overflow-y-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>
            <p class="text-sm text-gray-500">Daftar pesanan yang sudah dibayar</p>
        </div>

        <!-- LIST TRANSAKSI -->
        <div class="space-y-6">

            @forelse ($orders as $order)
            <div class="bg-white rounded-lg shadow border overflow-hidden">

                <!-- HEADER ORDER -->
                <div class="flex justify-between items-start px-6 py-4 border-b">
                    <div>
                        <p class="font-semibold text-gray-800">
                            Order #{{ $order->id }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="text-right space-y-1">
                        <p class="text-lg font-bold text-green-600">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </p>

                        <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full
                            {{ $order->status === 'paid'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-yellow-100 text-yellow-700' }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>

                <!-- ITEM PESANAN -->
                <div class="px-6 py-4 bg-gray-50">
                    <table class="w-full text-sm">
                        <thead class="text-gray-500">
                            <tr>
                                <th class="text-left pb-2">Menu</th>
                                <th class="text-center pb-2">Qty</th>
                                <th class="text-right pb-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                            <tr class="border-t">
                                <td class="py-2">
                                    {{ $item->name }}
                                    <div class="text-xs text-gray-500">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="py-2 text-center">
                                    {{ $item->quantity }}x
                                </td>
                                <td class="py-2 text-right font-medium">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            @empty
                <div class="bg-white p-12 text-center text-gray-400 rounded border">
                    Belum ada transaksi
                </div>
            @endforelse

        </div>

    </main>

</div>

<script>
    // Handle logout dari emoji sidebar (🚪)
    document.addEventListener('DOMContentLoaded', function() {
        const logoutEmoji = document.getElementById('logout-emoji-btn');
        if (logoutEmoji) {
            logoutEmoji.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Yakin ingin logout?')) {
                    // Buat form logout manual
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("logout") }}';
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    });
</script>

</body>
</html>