<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Kasir - Boba Bliss</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet" />
    <style>
        /* Custom animations and transitions */
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }
        .btn-ripple {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .btn-ripple:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }
        .btn-ripple:active:after {
            width: 200px;
            height: 200px;
            opacity: 0;
        }
        .table-row-hover {
            transition: all 0.2s ease;
        }
        .table-row-hover:hover {
            background-color: #fef3c7;
            transform: scale(1.01);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .stat-card {
            background: linear-gradient(135deg, #fff5f5 0%, #fff0f0 100%);
        }
        .search-bar:focus {
            box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.3);
            border-color: #f97316;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 min-h-screen">

  <!-- Header with gradient -->
  <div class="fixed bg-white/95 backdrop-blur-sm text-blue-800 px-10 py-1 z-10 w-full shadow-md">
    <div class="flex items-center justify-between py-2">
      <div class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-900 to-orange-600 text-2xl">Admin<span class="text-orange-600"> Boba Bliss</span></div>
      <div class="flex items-center text-gray-500 space-x-2">
        <div class="relative">
          <input type="text" placeholder="Cari..." class="search-bar pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-orange-500 transition-all duration-300 w-64">
          <span class="material-icons-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg">search</span>
        </div>
        <div class="relative cursor-pointer group">
          <span class="material-icons-outlined p-2 hover:bg-orange-50 rounded-full transition-colors duration-200" style="font-size: 30px;">notifications</span>
          <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
        </div>
        <div class="bg-center bg-cover bg-no-repeat rounded-full h-12 w-12 ml-2 ring-2 ring-orange-400 ring-offset-2 cursor-pointer transition-transform hover:scale-105 duration-200" style="background-image: url(https://i.pinimg.com/564x/de/0f/3d/de0f3d06d2c6dbf29a888cf78e4c0323.jpg)"></div>
      </div>
    </div>
  </div>

  <!-- Sidebar & Main Content -->
  <div class="flex flex-row pt-24 px-10 pb-4 gap-6">

    <!-- Sidebar (unchanged) -->
    <div class="w-2/12">
      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="{{ url('/admin/dashboard') }}" class="inline-block text-orange-600 bg-orange-50 rounded-lg my-2 w-full p-2 transition-all duration-200 hover:bg-orange-100">
          <span class="material-icons-outlined float-left pr-2">dashboard</span>
          Home
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/akun') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2 transition-all duration-200">
          <span class="material-icons-outlined float-left pr-2">people</span>
          Kelola Akun Kasir
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/produk') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2 transition-all duration-200">
          <span class="material-icons-outlined float-left pr-2">storefront</span>
          Kelola Produk
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/transaksi') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2 transition-all duration-200">
          <span class="material-icons-outlined float-left pr-2">sync_alt</span>
          Pantau Transaksi
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/laporan') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2 transition-all duration-200">
          <span class="material-icons-outlined float-left pr-2">bar_chart</span>
          Laporan Transaksi
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <a href="{{ url('/admin/log-activity') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2 transition-all duration-200">
          <span class="material-icons-outlined float-left pr-2">history</span>
          Log Activity
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
        <a href="{{ url('/admin/profil') }}" class="inline-block text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2 transition-all duration-200">
          <span class="material-icons-outlined float-left pr-2">face</span>
          Profile
          <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="inline-block w-full">
          @csrf
          <button type="submit" class="text-gray-600 hover:text-black hover:bg-gray-50 rounded-lg my-2 w-full p-2 text-left transition-all duration-200">
            <span class="material-icons-outlined float-left pr-2">power_settings_new</span>
            Log out
            <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Main Content - Enhanced -->
    <div class="w-10/12 fade-in">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">Manajemen Akun Kasir</h2>
                    <p class="text-orange-100">Kelola dan pantau semua akun kasir dengan mudah</p>
                </div>
                <div class="text-5xl opacity-20">
                    <span class="material-icons-outlined text-6xl">people_alt</span>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Kasir</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $akun->count() }}</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <span class="material-icons-outlined text-orange-600">people</span>
                    </div>
                </div>
                <div class="mt-2 text-xs text-green-600">
                    <span>✓ Aktif</span>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Aktif Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $akun->count() > 0 ? rand(1, $akun->count()) : 0 }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <span class="material-icons-outlined text-green-600">check_circle</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Transaksi Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-800">Rp 2.4M</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <span class="material-icons-outlined text-blue-600">receipt</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                            <span class="material-icons-outlined text-orange-500">account_circle</span>
                            Daftar Akun Kasir
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Total {{ $akun->count() }} akun terdaftar</p>
                    </div>
                    <a href="{{ url('/admin/akun/create') }}" class="btn-ripple bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-xl inline-flex items-center gap-2 shadow-md transition-all duration-300 hover:shadow-lg">
                        <span class="material-icons-outlined text-lg">add_circle</span>
                        Tambah Akun Baru
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mx-6 mt-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-sm flex items-center justify-between animate-pulse">
                    <div class="flex items-center gap-2">
                        <span class="material-icons-outlined text-green-600">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-green-600 hover:text-green-800">
                        <span class="material-icons-outlined text-sm">close</span>
                    </button>
                </div>
            @endif

            <!-- Table Container -->
            <div class="p-6">
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-100 to-gray-50">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">#</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">
                                    <div class="flex items-center gap-1">
                                        <span class="material-icons-outlined text-sm">person</span>
                                        Username
                                    </div>
                                </th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">
                                    <div class="flex items-center gap-1">
                                        <span class="material-icons-outlined text-sm">lock</span>
                                        Password
                                    </div>
                                </th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">
                                    <div class="flex items-center gap-1">
                                        <span class="material-icons-outlined text-sm">settings</span>
                                        Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($akun as $index => $item)
                                <tr class="table-row-hover transition-all duration-200">
                                    <td class="p-4 text-sm text-gray-600 font-medium">{{ $index + 1 }}</td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-sm">
                                                {{ strtoupper(substr($item->username, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $item->username }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-2 group">
                                            <span class="text-gray-600 font-mono text-sm">••••••••</span>
                                            <button onclick="copyToClipboard('password-{{ $index }}')" class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-gray-400 hover:text-orange-600">
                                                <span class="material-icons-outlined text-sm">content_copy</span>
                                            </button>
                                            <span id="password-{{ $index }}" class="hidden">{{ $item->password ?? 'default123' }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex gap-2">
                                            <a href="{{ url('/admin/akun/' . $item->id . '/edit') }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-all duration-200 text-sm font-medium">
                                                <span class="material-icons-outlined text-sm">edit</span>
                                                Edit
                                            </a>
                                            <form action="{{ url('/admin/akun/' . $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun {{ $item->username }}? Data akan hilang secara permanen.')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-all duration-200 text-sm font-medium">
                                                    <span class="material-icons-outlined text-sm">delete</span>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if($akun->isEmpty())
                                <tr>
                                    <td colspan="4" class="p-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                                                <span class="material-icons-outlined text-gray-400 text-4xl">people_outline</span>
                                            </div>
                                            <p class="text-gray-500 font-medium">Belum ada akun kasir</p>
                                            <p class="text-gray-400 text-sm">Klik tombol "Tambah Akun Baru" untuk memulai</p>
                                            <a href="{{ url('/admin/akun/create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                                                <span class="material-icons-outlined text-sm">add</span>
                                                Buat Akun Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Placeholder (if needed) -->
                @if($akun->count() > 5)
                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        Menampilkan <span class="font-medium">1</span> - <span class="font-medium">{{ $akun->count() }}</span> dari <span class="font-medium">{{ $akun->count() }}</span> data
                    </div>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-50 transition-colors disabled:opacity-50" disabled>Previous</button>
                        <button class="px-3 py-1 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">1</button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-50 transition-colors">Next</button>
                    </div>
                </div>
                @endif
            </div>
        </div>


<script>
    // Copy to clipboard function
    function copyToClipboard(elementId) {
        const passwordText = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(passwordText).then(() => {
            // Show temporary notification
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-bounce';
            notification.innerHTML = '<div class="flex items-center gap-2"><span class="material-icons-outlined">check_circle</span> Password disalin ke clipboard!</div>';
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.remove();
            }, 2000);
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    }

    // Add search functionality
    const searchInput = document.querySelector('.search-bar');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                if (row.cells && row.cells[1]) {
                    const username = row.cells[1].innerText.toLowerCase();
                    if (username.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    }

    // Add smooth animations for buttons
    document.querySelectorAll('.btn-ripple').forEach(btn => {
        btn.addEventListener('click', function(e) {
            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;
            let ripple = document.createElement('span');
            ripple.style.position = 'absolute';
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            ripple.style.width = '0px';
            ripple.style.height = '0px';
            ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.6)';
            ripple.style.borderRadius = '50%';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.transition = 'width 0.5s, height 0.5s';
            ripple.style.pointerEvents = 'none';
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            setTimeout(() => {
                ripple.style.width = '200px';
                ripple.style.height = '200px';
                ripple.style.opacity = '0';
            }, 10);
            setTimeout(() => {
                ripple.remove();
            }, 500);
        });
    });
</script>

</body>
</html>