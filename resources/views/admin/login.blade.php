<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Boba App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-yellow-100 to-pink-200 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-2xl rounded-2xl p-10 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-pink-600">Boba Login</h1>
            <p class="text-sm text-gray-500">Silakan login untuk melanjutkan</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 text-red-600 px-4 py-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Email</label>
                <input type="email" name="email" class="w-full p-3 rounded-lg border focus:ring-2 focus:ring-pink-400" required autofocus>
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Password</label>
                <input type="password" name="password" class="w-full p-3 rounded-lg border focus:ring-2 focus:ring-pink-400" required>
            </div>
            <button type="submit" class="w-full bg-pink-500 text-white font-semibold py-3 rounded-lg hover:bg-pink-600 transition duration-200">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
