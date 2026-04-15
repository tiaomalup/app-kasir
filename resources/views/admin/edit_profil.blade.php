<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-100 min-h-screen flex justify-center items-center">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Edit Profil</h2>

        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <!-- Gambar Profil -->
            <div class="mb-4">
                <label for="profile_picture" class="block font-medium text-gray-700">Foto Profil</label>
                <input type="file" id="profile_picture" name="profile_picture" class="w-full mt-1">
                @if ($admin->profile_picture)
                    <img src="{{ asset($admin->profile_picture) }}" alt="Profile" class="mt-3 w-24 h-24 object-cover rounded-full">
                @endif
            </div>

            <!-- Tombol Simpan -->
            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>
