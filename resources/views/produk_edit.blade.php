<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk | Boba Bliss</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet" />
</head>
<body class="bg-orange-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-xl bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-3xl font-bold text-orange-600 mb-6 text-center">Edit Produk</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tambahkan ini di atas Nama Produk -->
<div class="mb-4">
    <label for="id" class="block text-gray-700 font-semibold mb-1">ID Produk</label>
    <input type="text" id="id" name="id"
        value="{{ $produk->id }}"
        readonly
        class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
</div>

        
            <div class="mb-4">
                <label for="nama_produk" class="block text-gray-700 font-semibold mb-1">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" required
                    value="{{ old('nama_produk', $produk->nama_produk) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="mb-4">
                <label for="harga" class="block text-gray-700 font-semibold mb-1">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" min="0" required
                    value="{{ old('harga', $produk->harga) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="mb-4">
                <label for="stok" class="block text-gray-700 font-semibold mb-1">Stok</label>
                <input type="number" id="stok" name="stok" min="0" required
                    value="{{ old('stok', $produk->stok) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="mb-4">
                <label for="gambar" class="block text-gray-700 font-semibold mb-1">Ganti Gambar Produk</label>
                <input type="file" id="gambar" name="gambar"
                    class="w-full px-4 py-2 border rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            @if($produk->gambar)
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1">Gambar Saat Ini:</label>
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" class="w-32 h-32 object-cover rounded-md">
                </div>
            @endif

            <div class="flex justify-between">
                <a href="{{ url('/produk') }}" class="flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-lg">
                    <span class="material-icons-outlined mr-2">arrow_back</span> Batal
                </a>
                <button type="submit" class="flex items-center bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg">
                    <span class="material-icons-outlined mr-2">save</span> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</body>
</html>
