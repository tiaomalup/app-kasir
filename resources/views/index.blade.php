<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boba Bliss</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen w-full">
    <div class="w-full min-h-screen bg-white shadow-2xl flex flex-col md:flex-row">
        <div class="w-full md:w-2/3 p-8">
            <div class="flex items-center space-x-3">
                <img src="boba.png" class="w-12" alt="McDonald's">
                <h1 class="text-3xl font-bold">Boba Bliss</h1>
            </div>
            <h2 class="text-xl font-bold mt-6">Popular</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-3" id="menu-container"></div>
        </div>

        <div id="cart" class="w-full md:w-1/3 bg-gray-100 p-6 min-h-screen shadow-lg overflow-y-auto">
            <h3 class="text-lg font-bold border-b pb-2">Keranjang</h3>
            <p id="customer-id" class="text-sm font-semibold text-gray-600 mt-2 hidden"></p>
            <ul id="cart-items" class="mt-4 space-y-2"></ul>
            <p class="mt-4 font-bold">Total: Rp<span id="cart-total">0</span></p>
            <p id="customer-id" class="mt-2 text-sm text-gray-600"></p> <!-- ID pelanggan muncul di sini -->
        <button onclick="confirmOrder()" class="mt-4 w-full bg-green-500 text-white py-2 rounded-lg text-sm hover:bg-green-600">Konfirmasi Pesanan</button>

        </div>
    </div>

    <script>
        const menuItems = [
            { name: "Brown sugar milk tea", price: 18000, img: "https://i.pinimg.com/736x/19/c1/6b/19c16bf3a1e42ad169da42eb1d3334ad.jpg" },
            { name: "Taro Bubble Tea", price: 15000, img: "https://i.pinimg.com/736x/03/95/dd/0395dda224662961f630ee6ac4f85d52.jpg" },
            { name: "Matcha Latte", price: 15000, img: "https://i.pinimg.com/736x/81/7f/04/817f04596563ac8e61d06e0101b9781d.jpg" },
            { name: "Strawberry Milk Tea", price: 15000, img: "https://i.pinimg.com/736x/fa/f0/f6/faf0f650d5090cb0d2e9cdeba4e3e50f.jpg" },
            { name: "Permen Karet Boba", price: 15000, img: "https://i.pinimg.com/736x/3e/8a/51/3e8a51becff60065460e09d37a48caeb.jpg" },
            { name: "Thai Tea Boba", price: 15000, img: "https://i.pinimg.com/736x/56/e7/50/56e750b6d8c9999f297a96aca32394cd.jpg" },
            { name: "Chocolate Boba", price: 15000, img: "https://i.pinimg.com/736x/67/05/df/6705df2a868541ef24d100db518af40f.jpg" },
            { name: "Milk Tea", price: 15000, img: "https://i.pinimg.com/736x/31/02/b5/3102b5426fd29374a55abe73e27dcd43.jpg" }
        ];

        let cart = [];
        let customerId = localStorage.getItem("customerId") || "CUST-" + Math.floor(Math.random() * 100000);
        localStorage.setItem("customerId", customerId);
        
        function renderMenu() {
            const menuContainer = document.getElementById("menu-container");
            menuContainer.innerHTML = "";
            menuItems.forEach(item => {
                menuContainer.innerHTML += `
                    <div class="bg-white shadow-lg rounded-lg p-4 text-center transform hover:scale-105 transition">
                        <img src="${item.img}" class="w-full h-48 object-cover rounded-md" alt="${item.name}">
                        <p class="text-sm mt-2 font-semibold">${item.name}</p>
                        <p class="text-yellow-500 font-semibold">Rp${item.price.toLocaleString("id-ID")}</p>
                        <div class="flex items-center justify-center space-x-2 mt-2">
                            <button onclick="updateCart('${item.name}', ${item.price}, -1)" class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600">-</button>
                            <span id="qty-${item.name}" class="font-bold">0</span>
                            <button onclick="updateCart('${item.name}', ${item.price}, 1)" class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-600">+</button>
                        </div>
                    </div>
                `;
            });
        }

        function updateCart(itemName, itemPrice, change) {
    let found = cart.find(item => item.name === itemName);
    let menuItem = menuItems.find(item => item.name === itemName);

    if (found) {
        found.quantity += change;
        if (found.quantity <= 0) {
            cart = cart.filter(item => item.name !== itemName);
        }
    } else if (change > 0) {
        cart.push({ name: itemName, price: itemPrice, quantity: 1, image: menuItem.img });
        document.getElementById("customer-id").textContent = `ID Pelanggan: ${customerId}`;
        document.getElementById("customer-id").classList.remove("hidden");
    }
    renderCart();
}

        function renderCart() {
            const cartItems = document.getElementById("cart-items");
            const cartTotal = document.getElementById("cart-total");
            cartItems.innerHTML = "";
            let total = 0;

            cart.forEach(item => {
                total += item.price * item.quantity;
                cartItems.innerHTML += `
                    <li class="flex justify-between items-center bg-white p-2 rounded-md shadow">
                        <span>${item.name} x${item.quantity} <span class='font-bold'>Rp${(item.price * item.quantity).toLocaleString("id-ID")}</span></span>
                        <button onclick="updateCart('${item.name}', ${item.price}, -1)" class='bg-red-500 text-white px-2 py-1 rounded text-xs'>Hapus</button>
                    </li>
                `;
                document.getElementById(`qty-${item.name}`).textContent = item.quantity;
            });
            cartTotal.textContent = total.toLocaleString("id-ID");
        }

        function confirmOrder() {
            localStorage.setItem("cart", JSON.stringify(cart));
            window.location.href = "order";
        }

        window.onload = renderMenu;
    </script>
</body>
</html>
