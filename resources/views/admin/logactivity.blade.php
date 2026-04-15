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


    <div class="bg-white shadow rounded-lg overflow-hidden">

<!-- Header -->
<div class="p-5 border-b flex justify-between items-center">
    <h2 class="text-xl font-semibold text-gray-700">
        Daftar Aktivitas
    </h2>

    <a href="{{ url('/dashboard') }}"
       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
       Kembali
    </a>
</div>


<!-- Table -->
<div class="overflow-x-auto">

    <table class="min-w-full text-sm text-gray-700">

        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">User</th>
                <th class="px-6 py-3 text-left">Action</th>
                <th class="px-6 py-3 text-left">Description</th>
                <th class="px-6 py-3 text-left">IP Address</th>
                <th class="px-6 py-3 text-left">Tanggal</th>
            </tr>
        </thead>

        <tbody class="divide-y">

            @forelse($logs as $log)

            <tr class="hover:bg-gray-50 transition">

                <td class="px-6 py-4 font-medium">
                    {{ $loop->iteration }}
                </td>

                <td class="px-6 py-4">
                    {{ $log->user_id ?? '-' }}
                </td>

                <td class="px-6 py-4">
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                        {{ $log->action }}
                    </span>
                </td>

                <td class="px-6 py-4">
                    {{ $log->description ?? '-' }}
                </td>

                <td class="px-6 py-4 font-mono text-xs text-gray-500">
                    {{ $log->ip_address }}
                </td>

                <td class="px-6 py-4 text-gray-500">
                    {{ $log->created_at->format('d M Y H:i') }}
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="6" class="text-center py-8 text-gray-400">
                    Belum ada aktivitas
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

</div>
</body>
</html>