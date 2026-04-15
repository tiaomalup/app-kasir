<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boba Bliss</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet" />

<div class="bg-orange-100 min-h-screen">
  <div class="fixed bg-white text-blue-800 px-10 py-1 z-10 w-full">
      <div class="flex items-center justify-between py-2 text-5x1">
        <div class="font-bold text-blue-900 text-xl">Admin<span class="text-orange-600"></span></div>
        <div class="flex items-center text-gray-500">
          <span class="material-icons-outlined p-2" style="font-size: 30px">search</span>
          <span class="material-icons-outlined p-2" style="font-size: 30px">notifications</span>
          <div class="bg-center bg-cover bg-no-repeat rounded-full inline-block h-12 w-12 ml-2" style="background-image: url(https://i.pinimg.com/564x/de/0f/3d/de0f3d06d2c6dbf29a888cf78e4c0323.jpg)"></div>
        </div>
    </div>
  </div>
  
  <div class="flex flex-row pt-24 px-10 pb-4">
    <div class="w-2/12 mr-6">
      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="dashboard" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">dashboard</span>
          Home
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/akun') }}" class="inline-block text-gray-600 hover:text-black my-4 w-full">
  <span class="material-icons-outlined float-left pr-2">people</span>
  Kelola Akun
  <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
</a>

        <a href="produk" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">storefront</span>
          Manajemen Produk
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="manajemen" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">receipt</span>
          Manajemen Pesanan
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="laporan" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">file_copy</span>
          Laporan Analitik
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="profil" class="inline-block text-gray-600 hover:text-black my-4 w-full">
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
    
    <div class="w-10/12">
      <h2 class="text-2xl font-bold mb-4">Manajemen Pesanan</h2>
      <div class="bg-white rounded-xl shadow-lg p-6">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr>
              <th class="border-b p-4">Nama Pelanggan</th>
              <th class="border-b p-4">Jumlah Item</th>
              <th class="border-b p-4">Total Harga</th>
              <th class="border-b p-4">Status</th>
              <th class="border-b p-4">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border-b p-4">John Doe</td>
              <td class="border-b p-4">3</td>
              <td class="border-b p-4">Rp 45.000</td>
              <td class="border-b p-4 text-yellow-500">Baru</td>
              <td class="border-b p-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded">Proses</button>
              </td>
            </tr>
            <tr>
              <td class="border-b p-4">Jane Smith</td>
              <td class="border-b p-4">2</td>
              <td class="border-b p-4">Rp 30.000</td>
              <td class="border-b p-4 text-blue-500">Diproses</td>
              <td class="border-b p-4">
                <button class="bg-orange-500 text-white px-4 py-2 rounded">Selesai</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
