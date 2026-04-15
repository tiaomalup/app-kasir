<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function handleLogin(event) {
            event.preventDefault();
            window.location.href = 'dashboard';
        }
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>
        <form onsubmit="handleLogin(event)">
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" placeholder="Masukkan email" class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" placeholder="Masukkan password" class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring focus:ring-blue-300" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Login</button>
        </form>
        <p class="text-center text-gray-600 mt-4">Belum punya akun? <a href="#" class="text-blue-500 hover:underline">Daftar</a></p>
    </div>
</body>
</html>
