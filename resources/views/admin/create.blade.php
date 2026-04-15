<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-xl bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-3xl font-bold text-orange-600 mb-6 text-center">Tambah Produk Baru</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
    <label class="block text-gray-700 font-semibold mb-1">Kode Produk</label>
    <input type="text" name="kode_produk" required
        placeholder="Contoh: PRD-001"
        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400">
</div>
            

            <div class="mb-4">
                <label for="nama_produk" class="block text-gray-700 font-semibold mb-1">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="mb-4">
                <label for="harga" class="block text-gray-700 font-semibold mb-1">Harga</label>
                <input type="number" id="harga" name="harga" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="mb-4">
                <label for="stok" class="block text-gray-700 font-semibold mb-1">Stok</label>
                <input type="number" id="stok" name="stok" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="mb-6">
                <label for="gambar" class="block text-gray-700 font-semibold mb-1">Gambar Produk</label>
                <input type="file" id="gambar" name="gambar"
                    class="w-full px-4 py-2 border rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="flex justify-between">
                <a href="{{ url('admin/produk') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</body>
</html>
