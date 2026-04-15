<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-tr from-yellow-100 via-pink-100 to-yellow-200 flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-10 relative border border-yellow-300">
        
        <!-- Ilustrasi boba -->
        <div class="flex justify-center mb-6">
            <div class="bg-yellow-200 p-4 rounded-full shadow-md animate-bounce">
                <img src="https://cdn-icons-png.flaticon.com/512/685/685352.png" 
                     alt="boba" 
                     class="w-16 h-16">
            </div>
        </div>

        <h2 class="text-3xl font-extrabold text-center text-pink-600 mb-1">Selamat Datang!</h2>
        <p class="text-center text-gray-500 mb-6 text-sm">Masuk sebagai kasir untuk mulai melayani pelanggan</p>

        {{-- Notifikasi --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('kasir.login.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="username" class="block text-gray-700 font-semibold mb-1">👤 Username</label>
                <input type="text" id="username" name="username" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400 shadow-sm"
                    placeholder="Masukkan username" value="{{ old('username') }}">
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-1">🔒 Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400 shadow-sm"
                    placeholder="Masukkan password">
            </div>

            <button type="submit"
                class="w-full bg-pink-500 text-white font-bold py-3 rounded-xl hover:bg-pink-600 transition duration-300 shadow-md">
                Masuk sebagai Kasir 🍹
            </button>
        </form>

        <p class="mt-6 text-center text-gray-400 text-xs">© {{ date('Y') }} Kasir Boba Ceria</p>
    </div>

</body>
</html>
