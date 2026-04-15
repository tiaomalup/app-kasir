<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Boba Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gradient-to-br from-purple-200 to-indigo-300 min-h-screen flex p-6">

    <!-- Sidebar -->
    <div class="w-64 bg-white rounded-lg shadow-xl p-6 mr-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-purple-900 mb-6">📋 Dashboard</h2>
            <ul class="space-y-4">
                <li><a href="dashboard.html" class="block text-lg text-gray-700 hover:text-purple-700">🏠 Beranda</a></li>
                <li><a href="menu" class="block text-lg text-gray-700 hover:text-purple-700">📋 Menu</a></li>
                <li><a href="kasir" class="block text-lg text-purple-900 font-semibold">🛒 Kasir</a></li>
                <li><a href="#riwayat" class="block text-lg text-gray-700 hover:text-purple-700">📜 Riwayat transaksi</a></li>
            </ul>
        </div>
        <button onclick="logout()" class="mt-10 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-lg">
            🔓 Logout
        </button>
    </div>

    <!-- Konten Utama -->
    <div class="flex-1 max-w-4xl w-full bg-white p-6 rounded-lg shadow-xl">
        <h1 class="text-4xl font-extrabold text-center text-purple-900 flex items-center justify-center gap-2">
            🛒 Kasir - Boba Store
        </h1>

        <table class="w-full mt-6 border-collapse border border-gray-300">
            <thead class="bg-purple-300 text-white">
                <tr>
                    <th class="p-2 border">Menu</th>
                    <th class="p-2 border">Size</th>
                    <th class="p-2 border">Harga</th>
                    <th class="p-2 border">Qty</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody id="order-list">
            </tbody>
        </table>

        <div class="mt-6">
            <p class="text-2xl font-semibold text-gray-800">Total: Rp <span id="total-price">0</span></p>
            <p class="text-gray-600">Pajak (10%): Rp <span id="tax">0</span></p>
            <p class="text-3xl font-bold text-purple-900">Grand Total: Rp <span id="grand-total">0</span></p>
        </div>

        <div class="mt-6">
            <input type="number" id="payment" placeholder="Masukkan jumlah pembayaran" class="p-3 border rounded w-full text-lg focus:ring-2 focus:ring-purple-500">
            <p class="mt-3 text-lg font-semibold text-gray-700">Kembalian: Rp <span id="change">0</span></p>
        </div>

        <div class="flex justify-between mt-6 gap-4">
            <button onclick="clearOrders()" class="text-lg px-6 py-3 bg-red-500 hover:bg-red-600 text-white w-1/2">Batalkan</button>
            <button onclick="completeOrder()" class="text-lg px-6 py-3 bg-green-500 hover:bg-green-600 text-white w-1/2">Selesaikan Transaksi</button>
        </div>

        <!-- Riwayat Pesanan -->
        <div id="riwayat" class="mt-10 p-6 bg-white rounded-lg shadow-lg border border-gray-300">
            <h2 class="text-2xl font-bold text-purple-900">📜 Riwayat Pesanan</h2>
            <table class="w-full mt-4 border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Total Harga</th>
                        <th class="p-2 border">Kembalian</th>
                    </tr>
                </thead>
                <tbody id="order-history">
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script -->
    <script>
        function logout() {
            window.location.href = 'loginn';
        }

        let orders = JSON.parse(localStorage.getItem("cart")) || [];
        let orderHistory = [];

        function updateOrderList() {
            const orderList = document.getElementById("order-list");
            orderList.innerHTML = "";
            let total = 0;
            orders.forEach(order => {
                total += order.price * order.quantity;
                orderList.innerHTML += `
                    <tr class="border">
                        <td class="p-2 border">${order.name}</td>
                        <td class="p-2 border">${order.size}</td>
                        <td class="p-2 border">Rp ${order.price.toLocaleString()}</td>
                        <td class="p-2 border">${order.quantity}</td>
                        <td class="p-2 border"><button class="text-red-500" onclick="removeOrder(${order.id})">🗑</button></td>
                    </tr>`;
            });
            document.getElementById("total-price").textContent = total.toLocaleString();
            document.getElementById("tax").textContent = (total * 0.1).toLocaleString();
            document.getElementById("grand-total").textContent = (total * 1.1).toLocaleString();
        }

        function removeOrder(id) {
            orders = orders.filter(order => order.id !== id);
            updateOrderList();
        }

        function clearOrders() {
            orders = [];
            updateOrderList();
        }

        function completeOrder() {
            const payment = parseInt(document.getElementById("payment").value);
            const grandTotal = parseInt(document.getElementById("grand-total").textContent.replace(/,/g, ""));
            if (payment >= grandTotal) {
                const change = payment - grandTotal;
                document.getElementById("change").textContent = change.toLocaleString();
                orderHistory.push({ id: Date.now(), total: grandTotal, change });
                updateOrderHistory();
                localStorage.setItem("cart", JSON.stringify([]));
                clearOrders();
                setTimeout(() => {
                    window.location.href = "kasir";
                }, 1500);
            } else {
                alert("Pembayaran tidak mencukupi!");
            }
        }

        function updateOrderHistory() {
            const historyList = document.getElementById("order-history");
            historyList.innerHTML = "";
            orderHistory.forEach(order => {
                historyList.innerHTML += `
                    <tr class="border">
                        <td class="p-2 border">${order.id}</td>
                        <td class="p-2 border">Rp ${order.total.toLocaleString()}</td>
                        <td class="p-2 border">Rp ${order.change.toLocaleString()}</td>
                    </tr>`;
            });
        }

        updateOrderList();
    </script>
</body>
</html>
