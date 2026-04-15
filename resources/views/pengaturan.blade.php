<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boba Bliss</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<!-- source https://gist.github.com/dsursulino/369a0998c0fc8c25e19962bce729674f -->

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
        <a href="another.html" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">file_copy</span>
          Another menu item
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="profil" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">face</span>
          Profile
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="pengaturan" class="inline-block text-gray-600 hover:text-black my-4 w-full">
          <span class="material-icons-outlined float-left pr-2">settings</span>
          Settings
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
      <h2 class="text-2xl font-bold mb-4">Pengaturan Admin</h2>
      <div class="bg-white rounded-xl shadow-lg p-6">
        <form>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nama Admin</label>
            <input type="text" class="w-full p-2 border rounded-lg" placeholder="Masukkan nama admin">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" class="w-full p-2 border rounded-lg" placeholder="Masukkan email admin">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Kata Sandi Baru</label>
            <input type="password" class="w-full p-2 border rounded-lg" placeholder="Masukkan kata sandi baru">
          </div>
          <button class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
