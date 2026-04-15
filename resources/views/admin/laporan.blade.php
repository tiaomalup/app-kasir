<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Laporan Analitik - Boba Bliss</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    /* Sembunyikan elemen yang tidak perlu saat print */
    @media print {
      .no-print {
        display: none !important;
      }
      /* Sembunyikan sidebar, header, filter, dan tombol */
      .sidebar-area, 
      .navbar-area,
      .filter-section,
      .print-hide {
        display: none !important;
      }
      /* Yang dicetak hanya konten utama dengan tabel rincian produk */
      .print-content-only {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
      }
      /* Pastikan tabel tetap rapi saat print */
      table {
        width: 100%;
        border-collapse: collapse;
      }
      th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
      }
      th {
        background-color: #f97316;
        color: white;
      }
      body {
        background: white;
        padding: 20px;
      }
      /* Sembunyikan elemen tambahan */
      .stat-card, .bg-gradient-to-r {
        display: none;
      }
    }
    
    .stat-card {
      transition: all 0.3s ease;
      border: 1px solid rgba(255,255,255,0.1);
    }
    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
    }
    
    .filter-input {
      transition: all 0.2s ease;
    }
    .filter-input:focus {
      box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
    }
    
    .table-row-hover {
      transition: all 0.2s ease;
    }
    .table-row-hover:hover {
      background-color: rgba(249, 115, 22, 0.03);
    }
  </style>
</head>

<body class="bg-orange-50 min-h-screen">

  <!-- HEADER (tidak dicetak) -->
  <div class="fixed bg-white text-blue-800 px-10 py-1 z-10 w-full navbar-area shadow-sm no-print">
    <div class="flex items-center justify-between py-2">
      <div class="font-bold text-blue-900 text-xl flex items-center gap-2">
        Admin <span class="text-orange-500">Boba Bliss</span>
      </div>
      <div class="flex items-center text-gray-400">
        <span class="material-icons-outlined p-2 hover:bg-orange-50 rounded-full cursor-pointer transition-all duration-200" style="font-size: 30px;">search</span>
        <span class="material-icons-outlined p-2 hover:bg-orange-50 rounded-full cursor-pointer transition-all duration-200 relative" style="font-size: 30px;">
          notifications
          <span class="absolute top-1 right-1 w-2 h-2 bg-orange-400 rounded-full"></span>
        </span>
        <div class="bg-center bg-cover bg-no-repeat rounded-full h-12 w-12 ml-2 border-2 border-orange-200 cursor-pointer hover:border-orange-300 transition-all duration-200"
             style="background-image: url(https://i.pinimg.com/564x/de/0f/3d/de0f3d06d2c6dbf29a888cf78e4c0323.jpg)">
        </div>
      </div>
    </div>
  </div>

  <!-- SIDEBAR + CONTENT -->
  <div class="flex flex-row pt-24 px-10 pb-4">

    <!-- SIDEBAR (TIDAK DICETAK) -->
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

    <!-- MAIN CONTENT - YANG AKAN DICETAK HANYA BAGIAN INI -->
    <div class="w-10/12 main-content print-content-only">

      <!-- HEADER DENGAN GRADIENT (tidak dicetak) -->
      <div class="flex justify-between items-center mb-6 bg-gradient-to-r from-orange-400 to-orange-300 p-6 rounded-xl shadow-md text-white no-print">
        <div>
          <h2 class="text-3xl font-bold flex items-center gap-2">
            <i class="fas fa-chart-line text-white"></i>
            Laporan Analitik Penjualan
          </h2>
          <p class="text-orange-100 mt-1 flex items-center gap-1">
            <i class="fas fa-calendar-alt text-sm"></i>
            Periode: {{ now()->format('F Y') }}
          </p>
        </div>

        <button onclick="printOnlyReport()"
          class="no-print bg-white text-orange-500 px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 font-semibold hover:bg-orange-50">
          <i class="fas fa-print"></i>
          Cetak PDF
        </button>
      </div>

      <!-- FILTER (tidak dicetak) -->
      <div class="bg-white p-6 rounded-xl shadow-md mb-6 border border-orange-100 no-print filter-section">
        <div class="flex items-center gap-2 mb-4">
          <i class="fas fa-filter text-orange-400"></i>
          <h3 class="font-semibold text-gray-700">Filter Data</h3>
        </div>
        <form method="GET" action="{{ url('/admin/laporan') }}" class="flex items-end gap-4">
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-500 mb-2">
              <i class="fas fa-calendar-day mr-1 text-orange-400"></i>
              Pilih Tanggal:
            </label>
            <input type="date" name="tanggal"
                   value="{{ $filterTanggal ?? '' }}"
                   class="filter-input w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-orange-300 bg-gray-50">
          </div>

          <button type="submit"
            class="bg-gradient-to-r from-orange-400 to-orange-300 text-white px-8 py-3 rounded-lg font-semibold hover:from-orange-500 hover:to-orange-400 transition-all duration-200 flex items-center gap-2 shadow-sm">
            <i class="fas fa-search"></i>
            Filter
          </button>

          <a href="{{ url('/admin/laporan') }}"
             class="bg-gray-400 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-500 transition-all duration-200 flex items-center gap-2 shadow-sm">
            <i class="fas fa-sync-alt"></i>
            Reset
          </a>
        </form>
      </div>

      <!-- RINGKASAN (tidak dicetak) -->
      <div class="grid grid-cols-3 gap-6 mb-6 no-print">
        <div class="stat-card bg-gradient-to-br from-green-400 to-green-300 p-6 rounded-xl shadow-md text-white relative overflow-hidden">
          <div class="absolute right-0 top-0 w-20 h-20 bg-white opacity-5 rounded-full -mr-5 -mt-5"></div>
          <div class="relative">
            <div class="flex items-center gap-2 mb-2">
              <i class="fas fa-money-bill-wave text-2xl text-white"></i>
              <p class="text-green-100 text-sm">Total Penjualan</p>
            </div>
            <h3 class="text-3xl font-bold">
              Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
            </h3>
            <p class="text-green-100 text-xs mt-2">
              <i class="fas fa-arrow-up"></i> +8.3% dari bulan lalu
            </p>
          </div>
        </div>

        <div class="stat-card bg-gradient-to-br from-blue-400 to-blue-300 p-6 rounded-xl shadow-md text-white relative overflow-hidden">
          <div class="absolute right-0 top-0 w-20 h-20 bg-white opacity-5 rounded-full -mr-5 -mt-5"></div>
          <div class="relative">
            <div class="flex items-center gap-2 mb-2">
              <i class="fas fa-shopping-cart text-2xl text-white"></i>
              <p class="text-blue-100 text-sm">Jumlah Pesanan</p>
            </div>
            <h3 class="text-3xl font-bold">
              {{ $jumlahPesanan }}
            </h3>
            <p class="text-blue-100 text-xs mt-2">
              <i class="fas fa-box"></i> Total transaksi
            </p>
          </div>
        </div>

        <div class="stat-card bg-gradient-to-br from-orange-400 to-orange-300 p-6 rounded-xl shadow-md text-white relative overflow-hidden">
          <div class="absolute right-0 top-0 w-20 h-20 bg-white opacity-5 rounded-full -mr-5 -mt-5"></div>
          <div class="relative">
            <div class="flex items-center gap-2 mb-2">
              <i class="fas fa-crown text-2xl text-white"></i>
              <p class="text-orange-100 text-sm">Produk Terlaris</p>
            </div>
            <h3 class="text-2xl font-bold truncate">
              {{ $produkTerlaris->name ?? '-' }}
            </h3>
            @if(!empty($produkTerlaris->total_qty))
            <p class="text-orange-100 text-xs mt-2">
              <i class="fas fa-chart-bar"></i> Terjual {{ $produkTerlaris->total_qty }} pcs
            </p>
            @endif
          </div>
        </div>
      </div>

      <!-- TABEL RINCIAN PRODUK - INI YANG AKAN DICETAK -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden border border-orange-100" id="printable-area">
        <div class="p-6 border-b bg-gradient-to-r from-orange-50 to-white no-print">
          <div class="flex items-center gap-2">
            <i class="fas fa-clipboard-list text-orange-400 text-xl"></i>
            <h3 class="font-bold text-gray-700 text-lg">
              Rincian Penjualan Produk
            </h3>
          </div>
          <p class="text-sm text-gray-400 mt-1">
            Detail penjualan per produk pada periode terpilih
          </p>
        </div>

        <!-- Judul untuk print (hanya muncul saat print) -->
        <div class="print-title" style="display: none; text-align: center; margin-bottom: 20px;">
          <h2 style="color: #f97316; margin-bottom: 5px;">Boba Bliss - Laporan Penjualan</h2>
          <p style="color: #666;">Periode: {{ now()->format('d F Y') }}</p>
          <hr style="margin: 10px 0;">
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left" id="report-table">
            <thead class="bg-orange-500 text-white">
              <tr>
                <th class="p-4 text-sm font-semibold">No</th>
                <th class="p-4 text-sm font-semibold">Nama Produk</th>
                <th class="p-4 text-sm font-semibold text-center">Total Qty</th>
                <th class="p-4 text-sm font-semibold text-right">Harga Satuan</th>
                <th class="p-4 text-sm font-semibold text-right">Total Pendapatan</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
              @forelse($laporan as $index => $item)
              <tr class="table-row-hover">
                <td class="p-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                <td class="p-4 text-sm font-medium">
                  <div class="flex items-center gap-2">
                    <span class="text-gray-700">{{ $item->name }}</span>
                  </div>
                </td>
                <td class="p-4 text-sm text-center">
                  <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-medium">
                    {{ $item->total_qty }} pcs
                  </span>
                </td>
                <td class="p-4 text-sm text-right font-medium text-gray-600">
                  Rp {{ number_format($item->price, 0, ',', '.') }}
                </td>
                <td class="p-4 text-sm text-right font-semibold text-green-600">
                  Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="p-8 text-center">
                  <i class="fas fa-chart-bar text-4xl text-gray-300 mb-3"></i>
                  <p class="text-gray-400 text-lg">Belum ada data penjualan</p>
                  <p class="text-sm text-gray-300">Pilih periode lain untuk melihat data</p>
                </td>
              </tr>
              @endforelse
            </tbody>

            <tfoot class="bg-orange-50 font-medium">
              <tr>
                <td colspan="4" class="p-4 text-right text-gray-600">
                  <span class="flex items-center justify-end gap-2">
                    <i class="fas fa-calculator text-orange-400"></i>
                    TOTAL KESELURUHAN
                  </span>
                </td>
                <td class="p-4 text-right">
                  <span class="text-lg text-orange-500 font-semibold">
                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                  </span>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
        
        <div class="p-4 bg-gray-50 border-t border-gray-100 text-sm text-gray-400 flex items-center justify-between no-print">
          <div class="flex items-center gap-2">
            <i class="fas fa-info-circle text-orange-400"></i>
            <span>* Dicetak pada: {{ now()->format('d-m-Y H:i') }}</span>
          </div>
          <div class="flex items-center gap-4">
            <span class="flex items-center gap-1">
              <span class="w-2 h-2 bg-orange-400 rounded-full"></span>
              {{ count($laporan) }} produk terjual
            </span>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script>
    function printOnlyReport() {
      // Ambil elemen tabel dan judul untuk print
      const originalTitle = document.title;
      const tableArea = document.getElementById('printable-area');
      
      // Clone area yang akan dicetak
      const printContent = tableArea.cloneNode(true);
      
      // Hapus elemen yang tidak perlu di print dari clone
      const noPrintElements = printContent.querySelectorAll('.no-print');
      noPrintElements.forEach(el => el.remove());
      
      // Tambahkan judul untuk print
      const titleDiv = document.createElement('div');
      titleDiv.style.textAlign = 'center';
      titleDiv.style.marginBottom = '20px';
      titleDiv.style.padding = '20px';
      titleDiv.innerHTML = `
        <h1 style="color: #f97316; font-size: 24px; margin-bottom: 5px;">🍹 Boba Bliss</h1>
        <h2 style="color: #333; margin-bottom: 5px;">Laporan Rincian Penjualan Produk</h2>
        <p style="color: #666;">Periode: {{ now()->format('d F Y') }}</p>
        <p style="color: #666;">Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
        <hr style="margin: 10px 0; border: 1px solid #ddd;">
      `;
      
      printContent.insertBefore(titleDiv, printContent.firstChild);
      
      // Styling untuk print
      const style = document.createElement('style');
      style.textContent = `
        table {
          width: 100%;
          border-collapse: collapse;
          font-size: 12px;
        }
        th, td {
          border: 1px solid #ddd;
          padding: 10px;
          text-align: left;
        }
        th {
          background-color: #f97316;
          color: white;
          font-weight: bold;
        }
        td {
          color: #333;
        }
        .text-center {
          text-align: center;
        }
        .text-right {
          text-align: right;
        }
        tfoot td {
          background-color: #fff7ed;
          font-weight: bold;
        }
        body {
          padding: 20px;
          font-family: Arial, sans-serif;
        }
      `;
      
      printContent.prepend(style);
      
      // Buka window print
      const printWindow = window.open('', '_blank');
      printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
          <title>Laporan Rincian Produk - Boba Bliss</title>
          <meta charset="UTF-8">
        </head>
        <body>
          ${printContent.outerHTML}
        </body>
        </html>
      `);
      
      printWindow.document.close();
      printWindow.print();
      printWindow.close();
    }
  </script>

</body>
</html>