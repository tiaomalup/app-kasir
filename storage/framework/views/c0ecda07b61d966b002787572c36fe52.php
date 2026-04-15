<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="bg-gradient-to-r from-yellow-100 to-orange-200 font-sans min-h-screen flex justify-center items-center">
    <div class="w-full max-w-3xl bg-white shadow-xl rounded-lg p-8 relative border border-gray-300">
        <h1 class="text-4xl font-extrabold text-center text-orange-600">Order Summary</h1>
        <p class="text-center text-gray-600 mt-2">Review your order before confirming</p>

        <div class="mt-6 space-y-2">
            <h2 class="text-lg font-semibold text-gray-800">ID Pemesan: <span id="order-id" class="text-orange-600"></span></h2>
            <h2 class="text-lg font-semibold text-gray-800">Tipe Layanan: <span id="order-service" class="text-orange-600"></span></h2>
        </div>

        <div id="order-items" class="mt-6 space-y-4 border-t pt-4"></div>

        <p class="mt-6 text-2xl font-semibold text-center text-gray-800">Total: Rp<span id="order-total">0</span></p>

        <div class="mt-6 flex justify-between">
            <button onclick="goBack()" class="bg-gray-300 text-gray-800 py-3 px-6 rounded-lg text-sm hover:bg-gray-400 transition">Kembali</button>
            <button onclick="confirmPurchase()" class="bg-orange-500 text-white py-3 px-6 rounded-lg text-sm hover:bg-orange-600 transition shadow-md">Konfirmasi Pembelian</button>
        </div>
    </div>

    <script>
        let cart = [];
        let customerId = localStorage.getItem("customerId") || "CUST-" + Math.floor(Math.random() * 100000);
        let serviceType = localStorage.getItem("serviceType") || "Tidak Diketahui";
        localStorage.setItem("customerId", customerId);

        function loadOrder() {
            cart = JSON.parse(localStorage.getItem("cart")) || [];
            document.getElementById("order-id").textContent = customerId;
            document.getElementById("order-service").textContent = serviceType;

            const orderItems = document.getElementById("order-items");
            const orderTotal = document.getElementById("order-total");
            orderItems.innerHTML = "";
            let total = 0;

            cart.forEach(item => {
                total += item.price * item.quantity;
                const div = document.createElement("div");
                div.className = "flex justify-between items-center bg-orange-50 p-4 rounded-md shadow";
                div.innerHTML = `
                    <div class="text-gray-800">
                        <span class='font-medium block'>${item.name} x${item.quantity}</span>
                    </div>
                    <span class='font-bold text-orange-600'>Rp${(item.price * item.quantity).toLocaleString("id-ID")}</span>
                `;
                orderItems.appendChild(div);
            });

            orderTotal.textContent = total.toLocaleString("id-ID");
        }

        function goBack() {
            window.location.href = "/";
        }

        function confirmPurchase() {
            const totalText = document.getElementById("order-total").textContent;
const total = parseInt(totalText.replace(/\./g, "")); // Hilangkan titik ribuan

    const orderData = {
        customerId: customerId,
        cart: cart,
        total: total,
        serviceType: serviceType,
        status: "Pending"
    };

    console.log("Mengirim order:", orderData); // Tambahan debug log

    fetch("/orders", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(data => {
        alert("Pesanan berhasil dikirim!");
        localStorage.setItem("order", JSON.stringify(orderData));
        clearDataAndRedirect();
    })
    .catch(error => {
        alert("Terjadi kesalahan saat mengirim pesanan.");
        console.error(error);
    });
}


        function clearDataAndRedirect() {
            localStorage.removeItem("cart");
            localStorage.removeItem("order");
            localStorage.removeItem("customerId");
            localStorage.removeItem("serviceType");
            window.location.href = "/menus";
        }

        window.onload = loadOrder;
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\apk_boba\resources\views/user/order.blade.php ENDPATH**/ ?>