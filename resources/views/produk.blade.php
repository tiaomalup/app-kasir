<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manajemen Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

  <div class="flex">

    <!-- Sidebar -->
    <div class="w-2/12 mr-6 px-4 py-6">
      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="{{ url('/dashboard') }}" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">dashboard</span>
          Home
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/akun') }}" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">people</span>
          Kelola Akun Kasir
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/produk') }}" class="inline-block text-gray-900 font-bold my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">storefront</span>
          Manajemen Produk
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/manajemen') }}" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">receipt</span>
          Manajemen Pesanan
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/laporan') }}" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">bar_chart</span>
          Laporan Analitik
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="{{ url('/profil') }}" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">face</span>
          Profile
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/logout') }}" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">power_settings_new</span>
          Log out
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
      </div>
    </div>

    <!-- Konten Manajemen Produk -->
    <div class="w-10/12 px-6 py-6">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Produk</h1>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Kartu Produk -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
          <img src="https://via.placeholder.com/300x200" alt="Produk" class="w-full h-48 object-cover">
          <div class="p-4 space-y-2">
            <p class="text-sm text-gray-400">ID: #001</p>
            <h2 class="text-xl font-semibold text-gray-800">Boba Brown Sugar</h2>
            <p class="text-gray-600">Harga: Rp25.000</p>
            <p class="text-gray-600">Stok: 12</p>
            <div class="flex justify-between mt-4">
              <a href="#" class="text-blue-500 hover:underline">Edit</a>
              <a href="#" class="text-red-500 hover:underline">Hapus</a>
            </div>
          </div>
        </div>

        <!-- Tambah produk lainnya di sini -->
        <!-- Bisa gunakan @foreach dalam Laravel untuk loop -->

      </div>
    </div>

  </div>

</body>
</html>
