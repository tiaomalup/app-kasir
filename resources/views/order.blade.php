<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-yellow-100 to-orange-200 font-sans min-h-screen flex justify-center items-center">
    <div class="w-full max-w-3xl bg-white shadow-xl rounded-lg p-8 relative border border-gray-300">
        <h1 class="text-4xl font-extrabold text-center text-orange-600">Order Summary</h1>
        <p class="text-center text-gray-600 mt-2">Review your order before confirming</p>
        
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-800">ID Pemesan: <span id="order-id" class="text-orange-600"></span></h2>
        </div>
        
        <div id="order-items" class="mt-6 space-y-4 border-t pt-4"></div>
        
        <p class="mt-6 text-2xl font-semibold text-center text-gray-800">Total: Rp<span id="order-total">0</span></p>
        
        <div class="mt-6 border-t pt-4">
            <h2 class="text-xl font-semibold text-gray-800">Payment Method</h2>
            <select id="payment-method" class="mt-2 w-full p-3 border rounded-lg">
                <option value="credit-card">Credit Card</option>
                <option value="bank-transfer">Bank Transfer</option>
                <option value="ewallet">E-Wallet</option>
                <option value="cod">Cash on Delivery</option>
            </select>
        </div>
        
        <div class="mt-6 flex justify-between">
            <button onclick="goBack()" class="bg-gray-300 text-gray-800 py-3 px-6 rounded-lg text-sm hover:bg-gray-400 transition">kembali</button>
            <button onclick="confirmPurchase()" class="bg-orange-500 text-white py-3 px-6 rounded-lg text-sm hover:bg-orange-600 transition shadow-md">konfirmasi</button>
        </div>
        
        <button id="print-receipt" onclick="printReceipt()" class="hidden mt-6 w-full bg-blue-500 text-white py-3 px-6 rounded-lg text-sm hover:bg-blue-600 transition shadow-md">Cetak Struk</button>
    </div>

    <script>
    let cart = [];
    let customerId = localStorage.getItem("customerId") || "CUST-" + Math.floor(Math.random() * 100000);
    localStorage.setItem("customerId", customerId);

    function loadOrder() {
        cart = JSON.parse(localStorage.getItem("cart")) || [];
        document.getElementById("order-id").textContent = customerId;
        
        const orderItems = document.getElementById("order-items");
        const orderTotal = document.getElementById("order-total");
        orderItems.innerHTML = "";
        let total = 0;

        cart.forEach(item => { 
            total += item.price * item.quantity;

            const div = document.createElement("div");
            div.className = "flex items-center bg-orange-50 p-4 rounded-md shadow space-x-4";
            div.innerHTML = `
                <img src="${item.image ? item.image : 'https://via.placeholder.com/64?text=No+Image'}" 
                    alt="${item.name}" 
                    class="w-16 h-16 rounded-md object-cover">
                <div class="flex-1">
                    <span class='font-medium text-gray-800 block'>${item.name} x${item.quantity}</span>
                    <span class='font-bold text-orange-600'>Rp${(item.price * item.quantity).toLocaleString("id-ID")}</span>
                </div>
            `;

            orderItems.appendChild(div);
        });

        orderTotal.textContent = total.toLocaleString("id-ID");
    }

    function goBack() {
        window.location.href = "index";
    }

    function confirmPurchase() {
        const paymentMethod = document.getElementById("payment-method").value;
        const orderData = {
            customerId: customerId,
            cart: cart,
            total: document.getElementById("order-total").textContent,
            paymentMethod: paymentMethod,
            status: paymentMethod === "cod" ? "Pending Payment" : "Awaiting Payment"
        };

        localStorage.setItem("order", JSON.stringify(orderData));
        
        if (paymentMethod === "cod") {
            alert("Pesanan telah dikonfirmasi! Pembayaran dilakukan di tempat.");
            document.getElementById("print-receipt").classList.remove("hidden");
        } else {
            simulatePayment();
        }
    }

    function simulatePayment() {
        setTimeout(() => {
            alert("Pembayaran berhasil! Pesanan sedang diproses.");
            let order = JSON.parse(localStorage.getItem("order"));
            order.status = "Paid";
            localStorage.setItem("order", JSON.stringify(order));
            document.getElementById("print-receipt").classList.remove("hidden");
        }, 2000);
    }

    function printReceipt() {
        let order = JSON.parse(localStorage.getItem("order"));
        let receiptWindow = window.open('', '', 'width=400,height=600');
        receiptWindow.document.write('<html><head><title>Struk Pembayaran</title></head><body>');
        receiptWindow.document.write('<h2>Struk Pembayaran</h2>');
        receiptWindow.document.write('<p>ID Pemesan: ' + order.customerId + '</p>');
        receiptWindow.document.write('<ul>');
        order.cart.forEach(item => {
            receiptWindow.document.write('<li>' + item.name + ' x' + item.quantity + ' - Rp' + (item.price * item.quantity).toLocaleString("id-ID") + '</li>');
        });
        receiptWindow.document.write('</ul>');
        receiptWindow.document.write('<p>Total: Rp' + order.total + '</p>');
        receiptWindow.document.write('<p>Metode Pembayaran: ' + order.paymentMethod + '</p>');
        receiptWindow.document.write('</body></html>');
        receiptWindow.document.close();
        receiptWindow.print();
    }

    window.onload = loadOrder;
    </script>
</body>
</html>
