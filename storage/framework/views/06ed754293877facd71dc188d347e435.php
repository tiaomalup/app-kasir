<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Boba Bliss</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet" />
</head>
<body class="bg-orange-100 min-h-screen">

  <!-- Header -->
  <div class="fixed bg-white text-blue-800 px-10 py-1 z-10 w-full">
    <div class="flex items-center justify-between py-2">
      <div class="font-bold text-blue-900 text-xl">Admin<span class="text-orange-600"> Boba Bliss</span></div>
      <div class="flex items-center text-gray-500">
        <span class="material-icons-outlined p-2" style="font-size: 30px;">search</span>
        <span class="material-icons-outlined p-2" style="font-size: 30px;">notifications</span>
        <div class="bg-center bg-cover bg-no-repeat rounded-full h-12 w-12 ml-2" style="background-image: url(https://i.pinimg.com/564x/de/0f/3d/de0f3d06d2c6dbf29a888cf78e4c0323.jpg)"></div>
      </div>
    </div>
  </div>

  <!-- Sidebar & Main Content -->
  <div class="flex flex-row pt-24 px-10 pb-4">

    <!-- Sidebar -->
    <div class="w-2/12 mr-6">
      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="<?php echo e(url('/dashboard')); ?>" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">dashboard</span>
          Home
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="<?php echo e(url('/akun')); ?>" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">people</span>
          Kelola Akun Kasir
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="<?php echo e(url('/produk')); ?>" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">storefront</span>
          Manajemen Produk
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="<?php echo e(url('/transaksi')); ?>" class="inline-block text-gray-600 hover:text-black my-4 w-full">
  <span class="material-icons-outlined float-left pr-2">sync_alt</span>
  Pantau Transaksi
  <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
</a>
        <a href="<?php echo e(url('/laporan')); ?>" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">bar_chart</span>
          Laporan Analitik
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="<?php echo e(url('/log-activity')); ?>" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">bar_chart</span>
          Log Activity
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="<?php echo e(url('/profil')); ?>" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">face</span>
          Profile
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="logout.html" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">power_settings_new</span>
          Log out
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="w-10/12">
      <h2 class="text-2xl font-bold mb-4">Dashboard Admin</h2>

      <!-- Ringkasan Statistik -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <span class="material-icons-outlined text-orange-500 text-4xl mr-4">trending_up</span>
          <div>
            <p class="text-gray-500 text-sm">Total Penjualan</p>
            <p class="text-xl font-bold text-blue-900">1.620</p>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <span class="material-icons-outlined text-green-500 text-4xl mr-4">shopping_cart</span>
          <div>
            <p class="text-gray-500 text-sm">Pesanan Hari Ini</p>
            <p class="text-xl font-bold text-blue-900">48</p>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <span class="material-icons-outlined text-red-500 text-4xl mr-4">star</span>
          <div>
            <p class="text-gray-500 text-sm">Produk Terlaris</p>
            <p class="text-xl font-bold text-blue-900">Brown Sugar Boba</p>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <span class="material-icons-outlined text-purple-500 text-4xl mr-4">account_balance_wallet</span>
          <div>
            <p class="text-gray-500 text-sm">Pendapatan Bulan Ini</p>
            <p class="text-xl font-bold text-blue-900">Rp 12.450.000</p>
          </div>
        </div>
      </div>

      <!-- Grafik Penjualan -->
      <div class="bg-white rounded-xl shadow-lg p-6">
        <canvas id="salesChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Load Chart.js terlebih dahulu -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Script inisialisasi Chart -->
  <script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        datasets: [{
          label: 'Penjualan',
          data: [120, 190, 300, 500, 200, 300],
          backgroundColor: 'rgba(255, 159, 64, 0.5)',
          borderColor: 'rgba(255, 159, 64, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\apk_boba\resources\views/dashboard.blade.php ENDPATH**/ ?>