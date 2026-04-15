<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-orange-100 to-yellow-200 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center text-orange-600">Login Kasir</h2>
        <p class="text-center text-gray-600 mb-6">Masukkan username dan password</p>

        <div>
            <label class="block text-gray-700">Username</label>
            <input id="username" type="text" class="w-full p-3 border rounded-lg mt-1" placeholder="Masukkan username">
        </div>

        <div class="mt-4">
            <label class="block text-gray-700">Password</label>
            <input id="password" type="password" class="w-full p-3 border rounded-lg mt-1" placeholder="Masukkan password">
        </div>

        <button onclick="loginKasir()" class="w-full bg-orange-500 text-white p-3 rounded-lg mt-6 hover:bg-orange-600 transition shadow-md">
            Login
        </button>

        <p id="error-message" class="text-red-500 text-center mt-3 hidden">Username atau password salah!</p>
    </div>

    <script>
        function loginKasir() {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;
            const errorMessage = document.getElementById("error-message");

            // Data akun kasir yang valid (bisa diubah sesuai kebutuhan)
            const validKasir = {
                username: "kasir1",
                password: "123456"
            };

            // Cek username dan password
            if (username === validKasir.username && password === validKasir.password) {
                // Simpan status login di sessionStorage agar login hilang setelah browser ditutup
                sessionStorage.setItem("kasirLogin", "true");
                window.location.href = "kasir"; // Arahkan ke halaman kasir
            } else {
                errorMessage.classList.remove("hidden");
            }
        }
    </script>
</body>
</html>
