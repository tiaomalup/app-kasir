<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Boba Bliss - Pantau Transaksi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet" />
  <style>
    /* Custom smooth transitions & hover effects */
    .table-row-hover:hover {
      background-color: rgba(251, 146, 60, 0.08);
      transition: all 0.2s ease;
      transform: scale(1.01);
      box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .badge-status {
      transition: all 0.2s;
    }
    .detail-btn {
      transition: all 0.2s ease;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .detail-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card-shadow-custom {
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    }
    /* subtle gradient for header */
    .gradient-header-bg {
      background: linear-gradient(135deg, #ffffff 0%, #fff9f0 100%);
    }
    /* smooth table border radius */
    .table-rounded {
      border-radius: 1rem;
      overflow: hidden;
    }
    /* custom scrollbar for table overflow */
    .overflow-x-auto::-webkit-scrollbar {
      height: 6px;
    }
    .overflow-x-auto::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
      background: #fb923c;
      border-radius: 10px;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-orange-50 to-amber-50 min-h-screen">

  <!-- Header (Fixed) -->
  <div class="fixed bg-white/90 backdrop-blur-md shadow-md text-blue-800 px-10 py-1 z-10 w-full border-b border-orange-200/50">
    <div class="flex items-center justify-between py-2">
      <div class="font-bold text-blue-900 text-xl tracking-tight">Admin<span class="text-orange-500"> Boba Bliss</span></div>
      <div class="flex items-center text-gray-500 gap-1">
        <span class="material-icons-outlined p-2 hover:bg-orange-100 rounded-full cursor-pointer transition" style="font-size: 28px;">search</span>
        <span class="material-icons-outlined p-2 hover:bg-orange-100 rounded-full cursor-pointer transition" style="font-size: 28px;">notifications</span>
        <div class="bg-center bg-cover bg-no-repeat rounded-full h-12 w-12 ml-2 ring-2 ring-orange-300 shadow-sm transition hover:scale-105" style="background-image: url(https://i.pinimg.com/564x/de/0f/3d/de0f3d06d2c6dbf29a888cf78e4c0323.jpg)"></div>
      </div>
    </div>
  </div>

  <!-- Sidebar & Main Content -->
  <div class="flex flex-row pt-28 px-10 pb-8 gap-6">

    <!-- Sidebar (unchanged structure, only subtle visual polish but NOT altered functionality) -->
    <div class="w-2/12 mr-6">
      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="{{ url('/admin/dashboard') }}" class="inline-block text-orange-600 bg-orange-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">dashboard</span>
          Home
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/akun') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">people</span>
          Kelola Akun Kasir
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/produk') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">storefront</span>
          Kelola Produk
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/transaksi') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">sync_alt</span>
          Pantau Transaksi
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/laporan') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">bar_chart</span>
          Laporan Transaksi
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/log-activity') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">history</span>
          Log Activity
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="{{ url('/admin/profil') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">face</span>
          Profile
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="inline-block w-full">
          @csrf
          <button type="submit" class="text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2 text-left">
            <span class="material-icons-outlined float-left pr-2">power_settings_new</span>
            Log out
            <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
          </button>
        </form>
      </div>
    </div>


    <!-- Main Content Area - Enhanced Design -->
    <div class="flex-1">
      <!-- Header with stats summary and decorative elements -->
      <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
          <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-800 to-orange-600 tracking-tight">Pantau Transaksi</h2>
          <p class="text-gray-500 mt-1 flex items-center gap-1 text-sm">
            <span class="material-icons-outlined text-orange-400 text-base">receipt</span> 
            Daftar lengkap pembayaran dan status pesanan
          </p>
        </div>
        <!-- optional summary card (dynamic count) -->
        <div class="bg-white/70 backdrop-blur-sm rounded-xl px-5 py-2 shadow-sm flex items-center gap-3 border border-orange-200">
          <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
            <span class="material-icons-outlined text-orange-600">receipt_long</span>
          </div>
          <div>
            <div class="text-xs text-gray-500 uppercase font-semibold">Total Transaksi</div>
            <div class="text-2xl font-bold text-blue-900">{{ count($transaksis ?? []) }}</div>
          </div>
        </div>
      </div>

      <!-- Filter & search mini bar (just for style, enhances UX) -->
      <div class="flex flex-wrap justify-between items-center mb-5 gap-3">
        <div class="flex gap-2">
          <div class="relative">
            <span class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">search</span>
            <input type="text" placeholder="Cari Order ID / metode..." class="pl-9 pr-4 py-2 rounded-xl border border-gray-200 bg-white text-sm w-64 focus:ring-2 focus:ring-orange-300 focus:border-orange-300 outline-none transition shadow-sm">
          </div>
          <button class="bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition flex items-center gap-1 shadow-sm">
            <span class="material-icons-outlined text-base">filter_list</span>
            Filter
          </button>
        </div>
        <div class="text-xs text-gray-400 flex items-center gap-1 bg-white/50 px-3 py-1.5 rounded-full">
          <span class="material-icons-outlined text-orange-400 text-sm">update</span>
          Data realtime · Terbaru
        </div>
      </div>

      <!-- Table Card - Elegant Design -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-orange-100/80 card-shadow-custom transition-all">
        <div class="overflow-x-auto">
          <table class="min-w-full table-auto">
            <thead class="bg-gradient-to-r from-orange-100 to-amber-50 border-b border-orange-200">
              <tr>
                <th class="p-5 text-left font-bold text-gray-700 uppercase tracking-wider text-sm"><span class="material-icons-outlined align-middle text-sm mr-1 text-orange-500">receipt</span> Order ID</th>
                <th class="p-5 text-left font-bold text-gray-700 uppercase tracking-wider text-sm"><span class="material-icons-outlined align-middle text-sm mr-1 text-orange-500">calendar_today</span> Tanggal Bayar</th>
                <th class="p-5 text-left font-bold text-gray-700 uppercase tracking-wider text-sm"><span class="material-icons-outlined align-middle text-sm mr-1 text-orange-500">payments</span> Total</th>
                <th class="p-5 text-left font-bold text-gray-700 uppercase tracking-wider text-sm"><span class="material-icons-outlined align-middle text-sm mr-1 text-orange-500">credit_card</span> Metode</th>
                <th class="p-5 text-left font-bold text-gray-700 uppercase tracking-wider text-sm"><span class="material-icons-outlined align-middle text-sm mr-1 text-orange-500">check_circle</span> Status</th>
                <th class="p-5 text-left font-bold text-gray-700 uppercase tracking-wider text-sm"><span class="material-icons-outlined align-middle text-sm mr-1 text-orange-500">more_horiz</span> Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @forelse ($transaksis as $trx)
              <tr class="table-row-hover transition-all duration-150 group">
                <!-- Order ID with stylish badge -->
                <td class="p-4">
                  <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xs font-mono font-bold shadow-inner">#</span>
                    <span class="font-mono font-bold text-blue-700 tracking-wide text-sm">ORD-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</span>
                  </div>
                </td>
                <!-- Tanggal Bayar with icon -->
                <td class="p-4">
                  <div class="flex items-center gap-2 text-gray-600 text-sm">
                    <span class="material-icons-outlined text-gray-400 text-sm">schedule</span>
                    {{ $trx->paid_at ? \Carbon\Carbon::parse($trx->paid_at)->format('d M Y, H:i') : '-' }}
                  </div>
                </td>
                <!-- Total Rp format with bold style -->
                <td class="p-4">
                  <div class="font-bold text-gray-800 text-base">Rp {{ number_format($trx->total, 0, ',', '.') }}</div>
                </td>
                <!-- Metode Pembayaran with icon -->
                <td class="p-4">
                  <div class="flex items-center gap-1.5">
                    @if($trx->payment_method == 'Cash')
                      <span class="material-icons-outlined text-green-600 text-sm">payments</span>
                    @elseif($trx->payment_method == 'QRIS')
                      <span class="material-icons-outlined text-purple-500 text-sm">qr_code_scanner</span>
                    @elseif($trx->payment_method == 'Card')
                      <span class="material-icons-outlined text-blue-500 text-sm">credit_card</span>
                    @else
                      <span class="material-icons-outlined text-gray-400 text-sm">payment</span>
                    @endif
                    <span class="capitalize text-gray-700">{{ $trx->payment_method ?? '-' }}</span>
                  </div>
                </td>
                <!-- Status with improved badge + pulse effect for paid -->
                <td class="p-4">
                  @if($trx->status == 'paid')
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold shadow-sm badge-status">
                      <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                      </span>
                      PAID
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold shadow-sm">
                      <span class="material-icons-outlined text-amber-500 text-sm">pending</span>
                      {{ strtoupper($trx->status) }}
                    </span>
                  @endif
                </td>
                <!-- Aksi - Enhanced Button -->
                <td class="p-4">
                  <a href="{{ url('/admin/transaksi/' . $trx->id) }}" 
                     class="detail-btn inline-flex items-center gap-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-1.5 rounded-lg text-sm font-medium shadow-md">
                    <span class="material-icons-outlined text-sm">visibility</span>
                    Detail
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="p-12 text-center">
                  <div class="flex flex-col items-center justify-center gap-3">
                    <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center">
                      <span class="material-icons-outlined text-orange-400 text-4xl">receipt</span>
                    </div>
                    <span class="text-gray-500 font-medium text-lg">Belum ada transaksi</span>
                    <p class="text-gray-400 text-sm">Transaksi yang telah dibayar akan muncul di sini</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <!-- Optional pagination style (if pagination exists, but keep blade syntax) -->
        @if(method_exists($transaksis, 'links') && $transaksis->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
          {{ $transaksis->links() }}
        </div>
        @else
        <div class="px-6 py-3 border-t border-gray-100 text-right text-xs text-gray-400 bg-gray-50/20">
          Menampilkan {{ count($transaksis ?? []) }} transaksi
        </div>
        @endif
      </div>

      <!-- Additional insight card (optional but makes layout richer) -->
      <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white/80 rounded-xl p-3 flex items-center gap-3 shadow-sm border border-orange-100">
          <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
            <span class="material-icons-outlined text-green-600">check_circle</span>
          </div>
          <div>
            <p class="text-xs text-gray-500">Transaksi Sukses</p>
            <p class="font-bold text-green-700">{{ $transaksis->where('status','paid')->count() ?? 0 }}</p>
          </div>
        </div>
        <div class="bg-white/80 rounded-xl p-3 flex items-center gap-3 shadow-sm border border-orange-100">
          <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
            <span class="material-icons-outlined text-amber-600">pending_actions</span>
          </div>
          <div>
            <p class="text-xs text-gray-500">Menunggu</p>
            <p class="font-bold text-amber-600">{{ $transaksis->where('status','pending')->count() ?? 0 }}</p>
          </div>
        </div>
        <div class="bg-white/80 rounded-xl p-3 flex items-center gap-3 shadow-sm border border-orange-100">
          <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
            <span class="material-icons-outlined text-blue-600">payments</span>
          </div>
          <div>
            <p class="text-xs text-gray-500">Pendapatan</p>
            <p class="font-bold text-blue-700">Rp {{ number_format($transaksis->where('status','paid')->sum('total'), 0, ',', '.') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Floating decorative blob (pure style) -->
  <div class="fixed bottom-6 right-6 opacity-20 pointer-events-none">
    <div class="w-32 h-32 bg-orange-300 rounded-full blur-3xl"></div>
  </div>
</body>
</html>