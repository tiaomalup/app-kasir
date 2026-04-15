<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir - Boba Store</title>
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



    <!-- ========== SIDEBAR KEDUA (TIPE LAYANAN - TAPI UNTUK KASIR BISA DIHAPUS ATAU DISEMBUNYIKAN) ========== -->
    <!-- Karena di halaman kasir tidak perlu tipe layanan, kita buat sidebar kosong atau bisa juga diisi menu tambahan -->
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
               class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl border border-gray-200 transition-all duration-200 hover:bg-gray-50 text-gray-600 font-medium">
                <i class="fas fa-history"></i>
                <span>Riwayat Transaksi</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER -->
        <div class="bg-white border-b px-6 py-4">
            <h1 class="text-xl font-semibold text-gray-800">Dashboard Kasir</h1>
            <p class="text-sm text-gray-500">Daftar semua pesanan</p>
        </div>

        <!-- CONTENT -->
        <div class="p-6">

            <!-- ALERT -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- TABLE -->
            <div class="bg-white border rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-3 font-medium text-gray-600">ID Order</th>
                            <th class="px-4 py-3 font-medium text-gray-600">ID Customer</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Total</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Tipe</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Tanggal</th>
                            <th class="px-4 py-3 text-center font-medium text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    ORD-{{ $order->id }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $order->customer_id }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $order->service_type }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ url('/kasir/cari-pesanan?id=' . $order->id) }}"
                                       class="inline-block bg-gray-700 text-white px-3 py-1 rounded text-xs hover:bg-gray-900">
                                        bayar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400">
                                    Belum ada pesanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

<script>
    // Handle logout dari emoji sidebar (🚪)
    document.addEventListener('DOMContentLoaded', function() {
        const logoutEmoji = document.getElementById('logout-emoji-btn');
        if (logoutEmoji) {
            logoutEmoji.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Yakin ingin logout?')) {
                    // Buat form logout manual karena mungkin route logout berbeda
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("kasir.logout") }}';
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