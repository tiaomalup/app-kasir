<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Boba Bliss - Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet" />
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="bg-orange-100 min-h-screen">

  <!-- Header -->
  <div class="fixed bg-white text-blue-800 px-10 py-1 z-10 w-full shadow-md">
    <div class="flex items-center justify-between py-2">
      <div class="font-bold text-blue-900 text-xl">Admin<span class="text-orange-600"> Boba Bliss</span></div>
      <div class="flex items-center text-gray-500">
        <span class="material-icons-outlined p-2 cursor-pointer hover:bg-gray-100 rounded-full" style="font-size: 30px;">search</span>
        <span class="material-icons-outlined p-2 cursor-pointer hover:bg-gray-100 rounded-full" style="font-size: 30px;">notifications</span>
        <div class="bg-center bg-cover bg-no-repeat rounded-full h-12 w-12 ml-2 border-2 border-orange-500" style="background-image: url(https://i.pinimg.com/564x/de/0f/3d/de0f3d06d2c6dbf29a888cf78e4c0323.jpg)"></div>
      </div>
    </div>
  </div>

  <!-- Sidebar & Main Content -->
  <div class="flex flex-row pt-24 px-10 pb-4">

    <!-- Sidebar -->
    <div class="w-2/12 mr-6">
      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="<?php echo e(url('/admin/dashboard')); ?>" class="inline-block text-orange-600 bg-orange-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">dashboard</span>
          Home
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="<?php echo e(url('/admin/akun')); ?>" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">people</span>
          Kelola Akun Kasir
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="<?php echo e(url('/admin/produk')); ?>" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">storefront</span>
          Kelola Produk
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="<?php echo e(url('/admin/transaksi')); ?>" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">sync_alt</span>
          Pantau Transaksi
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="<?php echo e(url('/admin/laporan')); ?>" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">bar_chart</span>
          Laporan Transaksi
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="<?php echo e(url('/admin/log-activity')); ?>" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">history</span>
          Log Activity
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="<?php echo e(url('/admin/profil')); ?>" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2">
          <span class="material-icons-outlined float-left pr-2">face</span>
          Profile
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline-block w-full">
          <?php echo csrf_field(); ?>
          <button type="submit" class="text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2 text-left">
            <span class="material-icons-outlined float-left pr-2">power_settings_new</span>
            Log out
            <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Main Content -->
    <div class="w-10/12">
      <h2 class="text-2xl font-bold mb-4 text-gray-800">Dashboard Admin</h2>

      <!-- Ringkasan Statistik -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4 flex items-center hover:shadow-lg transition-shadow">
          <span class="material-icons-outlined text-orange-500 text-4xl mr-4">trending_up</span>
          <div>
            <p class="text-gray-500 text-sm">Total Penjualan</p>
            <p class="text-xl font-bold text-blue-900"><?php echo e(number_format($totalPenjualan, 0, ',', '.')); ?></p>
            <p class="text-xs text-gray-400">Transaksi</p>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 flex items-center hover:shadow-lg transition-shadow">
          <span class="material-icons-outlined text-green-500 text-4xl mr-4">shopping_cart</span>
          <div>
            <p class="text-gray-500 text-sm">Pesanan Hari Ini</p>
            <p class="text-xl font-bold text-blue-900"><?php echo e($pesananHariIni); ?></p>
            <p class="text-xs text-gray-400">Rp <?php echo e(number_format($revenueHariIni, 0, ',', '.')); ?></p>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 flex items-center hover:shadow-lg transition-shadow">
          <span class="material-icons-outlined text-red-500 text-4xl mr-4">star</span>
          <div>
            <p class="text-gray-500 text-sm">Produk Terlaris</p>
            <p class="text-xl font-bold text-blue-900">
              <?php echo e($produkTerlaris ? $produkTerlaris->name : 'Belum Ada'); ?>

            </p>
            <p class="text-xs text-gray-400">
              <?php echo e($produkTerlaris ? $produkTerlaris->total_quantity . ' pcs terjual' : ''); ?>

            </p>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 flex items-center hover:shadow-lg transition-shadow">
          <span class="material-icons-outlined text-purple-500 text-4xl mr-4">account_balance_wallet</span>
          <div>
            <p class="text-gray-500 text-sm">Pendapatan Bulan Ini</p>
            <p class="text-xl font-bold text-blue-900">Rp <?php echo e(number_format($pendapatanBulanIni, 0, ',', '.')); ?></p>
            <p class="text-xs text-gray-400"><?php echo e(Carbon\Carbon::now()->format('F Y')); ?></p>
          </div>
        </div>
      </div>

      <!-- Statistik Tambahan -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow p-4 text-white">
          <div class="flex justify-between items-center">
            <div>
              <p class="text-sm opacity-90">Total Produk</p>
              <p class="text-2xl font-bold"><?php echo e($statistics['total_products']); ?></p>
            </div>
            <span class="material-icons-outlined text-4xl opacity-80">inventory_2</span>
          </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow p-4 text-white">
          <div class="flex justify-between items-center">
            <div>
              <p class="text-sm opacity-90">Total Kasir</p>
              <p class="text-2xl font-bold"><?php echo e($statistics['total_kasir']); ?></p>
            </div>
            <span class="material-icons-outlined text-4xl opacity-80">people</span>
          </div>
        </div>
        
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow p-4 text-white">
          <div class="flex justify-between items-center">
            <div>
              <p class="text-sm opacity-90">Pesanan Pending</p>
              <p class="text-2xl font-bold"><?php echo e($statistics['pending_orders']); ?></p>
            </div>
            <span class="material-icons-outlined text-4xl opacity-80">pending</span>
          </div>
        </div>
      </div>

      <!-- Grafik Penjualan -->
      <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Grafik Penjualan 2 Bulan Terakhir</h3>
        <canvas id="salesChart"></canvas>
      </div>

      <!-- Transaksi Terbaru -->
      <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Transaksi Terbaru</h3>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">ID</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Items</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Total</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Metode</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2 text-sm">#<?php echo e($order->id); ?></td>
                <td class="px-4 py-2 text-sm"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                <td class="px-4 py-2 text-sm"><?php echo e($order->items->sum('quantity')); ?> item</td>
                <td class="px-4 py-2 text-sm font-semibold text-green-600">
                  Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                </td>
                <td class="px-4 py-2 text-sm">
                  <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                    <?php echo e(strtoupper($order->payment_method ?? 'CASH')); ?>

                  </span>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada transaksi</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Data dari controller
    const chartData = <?php echo json_encode($chartData, 15, 512) ?>;
    
    // Inisialisasi Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: chartData.map(item => item.month),
        datasets: [{
          label: 'Pendapatan (Rp)',
          data: chartData.map(item => item.total),
          backgroundColor: 'rgba(255, 159, 64, 0.7)',
          borderColor: 'rgba(255, 159, 64, 1)',
          borderWidth: 2,
          borderRadius: 8,
          barPercentage: 0.7
        }, {
          label: 'Jumlah Transaksi',
          data: chartData.map(item => item.count),
          backgroundColor: 'rgba(54, 162, 235, 0.7)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 2,
          borderRadius: 8,
          barPercentage: 0.7,
          yAxisID: 'y1'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label === 'Pendapatan (Rp)') {
                  return label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                }
                return label + ': ' + context.raw + ' transaksi';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Pendapatan (Rp)',
              font: {
                weight: 'bold'
              }
            },
            ticks: {
              callback: function(value) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
              }
            }
          },
          y1: {
            position: 'right',
            beginAtZero: true,
            title: {
              display: true,
              text: 'Jumlah Transaksi',
              font: {
                weight: 'bold'
              }
            },
            grid: {
              drawOnChartArea: false
            }
          }
        }
      }
    });
    
    // Auto refresh data setiap 30 detik (opsional)
    setInterval(function() {
      fetch('<?php echo e(url("/dashboard/realtime-data")); ?>')
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update statistik cards
            document.querySelectorAll('.bg-white.rounded-xl.shadow.p-4')[0].querySelector('.text-xl').innerText = 
              new Intl.NumberFormat('id-ID').format(data.data.total_penjualan);
            document.querySelectorAll('.bg-white.rounded-xl.shadow.p-4')[1].querySelector('.text-xl').innerText = 
              data.data.pesanan_hari_ini;
            document.querySelectorAll('.bg-white.rounded-xl.shadow.p-4')[3].querySelector('.text-xl').innerHTML = 
              'Rp ' + new Intl.NumberFormat('id-ID').format(data.data.pendapatan_bulan_ini);
          }
        })
        .catch(error => console.error('Error:', error));
    }, 30000);
  </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\apk_boba\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>