<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boba Bliss - Manajemen Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-orange-100 min-h-screen">

<!-- HEADER -->
<div class="fixed bg-white text-blue-800 px-10 py-1 z-10 w-full shadow-md">
    <div class="flex items-center justify-between py-2">
        <div class="font-bold text-blue-900 text-xl">
            Admin<span class="text-orange-600"> Boba Bliss</span>
        </div>

        <div class="flex items-center text-gray-500">
            <span class="material-icons-outlined p-2">search</span>
            <span class="material-icons-outlined p-2">notifications</span>
            <div class="bg-center bg-cover rounded-full h-10 w-10 ml-2 border-2 border-orange-500"
                style="background-image: url(https://i.pinimg.com/564x/de/0f/3d/de0f3d06d2c6dbf29a888cf78e4c0323.jpg)">
            </div>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="flex flex-row pt-24 px-10 pb-4">

    <!-- SIDEBAR -->
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
    
    <!-- MAIN CONTENT -->
    <div class="w-10/12">

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- BUTTON -->
        <a href="{{ route('produk.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg mb-4 inline-block shadow">
            + Tambah Produk
        </a>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="w-full text-left">

                <thead class="bg-orange-200">
                    <tr>
                        <th class="p-4">Gambar</th>
                        <th class="p-4">Kode Produk</th>
                        <th class="p-4">Nama Produk</th>
                        <th class="p-4">Harga</th>
                        <th class="p-4">Stok</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($produk as $item)
                    <tr class="border-b hover:bg-orange-50">

                        <!-- Gambar -->
                        <td class="p-4">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                     class="w-16 h-16 rounded object-cover">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </td>

                        <!-- KODE -->
                        <td class="p-4">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $item->kode_produk }}
                            </span>
                        </td>

                        <!-- Nama -->
                        <td class="p-4 font-medium">
                            {{ $item->nama_produk }}
                        </td>

                        <!-- Harga -->
                        <td class="p-4 text-green-600 font-semibold">
                            Rp{{ number_format($item->harga, 0, ',', '.') }}
                        </td>

                        <!-- Stok -->
                        <td class="p-4">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $item->stok }}
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="p-4 text-center">
                            <!-- Tombol Tambah Stok -->
                            <button onclick="openStockModal({{ $item->id }}, '{{ $item->nama_produk }}', {{ $item->stok }})"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded transition duration-200"
                                    title="Tambah Stok">
                                <i class="fas fa-plus-circle"></i> 
                            </button>

                            <a href="{{ route('produk.edit', $item->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded transition duration-200"
                               title="Edit Produk">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ url('/admin/produk/' . $item->id) }}"
                                  method="POST" class="inline" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $item->nama_produk }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded transition duration-200" title="Hapus Produk">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center p-6 text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-2 block"></i>
                            Belum ada produk
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- MODAL TAMBAH STOK -->
<div id="stockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    <i class="fas fa-plus-circle text-green-500 mr-2"></i>
                    Tambah Stok Produk
                </h3>
                <button onclick="closeStockModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="stockForm" method="POST" action="">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                    <p id="productName" class="text-gray-800 font-semibold text-lg"></p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stok Saat Ini</label>
                    <p id="currentStock" class="text-blue-600 font-bold text-xl"></p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Jumlah Stok Ditambahkan
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="tambah_stok" 
                           id="tambahStok"
                           required 
                           min="1"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
                    <p class="text-xs text-gray-500 mt-1">Masukkan angka positif untuk menambah stok</p>
                </div>
                
                <div class="mb-4 bg-blue-50 p-3 rounded">
                    <p class="text-sm text-gray-700">Stok setelah ditambahkan:</p>
                    <p id="newStock" class="text-green-600 font-bold text-lg"></p>
                </div>
                
                <div class="flex justify-between gap-3 mt-4">
                    <button type="button" onclick="closeStockModal()"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none transition duration-200">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none transition duration-200">
                        <i class="fas fa-save mr-1"></i> Tambah Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentStockValue = 0;
    
    function openStockModal(productId, productName, currentStock) {
        const modal = document.getElementById('stockModal');
        const productNameSpan = document.getElementById('productName');
        const currentStockSpan = document.getElementById('currentStock');
        const form = document.getElementById('stockForm');
        const tambahStokInput = document.getElementById('tambahStok');
        
        productNameSpan.textContent = productName;
        currentStockSpan.textContent = currentStock;
        currentStockValue = currentStock;
        tambahStokInput.value = '';
        
        // Set form action URL dengan prefix /admin
        form.action = '/admin/produk/' + productId;
        
        // Hitung stok baru saat input berubah
        tambahStokInput.oninput = function() {
            const added = parseInt(this.value) || 0;
            const newStock = currentStockValue + added;
            document.getElementById('newStock').textContent = newStock;
        };
        
        // Trigger initial calculation
        tambahStokInput.dispatchEvent(new Event('input'));
        
        modal.classList.remove('hidden');
    }
    
    function closeStockModal() {
        const modal = document.getElementById('stockModal');
        modal.classList.add('hidden');
        // Reset form
        document.getElementById('tambahStok').value = '';
        document.getElementById('newStock').textContent = '';
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('stockModal');
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    }
</script>

</body>
</html>