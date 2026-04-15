<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Boba Bliss - Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .active-service { background-color: #fbbf24 !important; color: white; border-color: #fbbf24 !important; transform: scale(1.02); }
        
        /* Transisi mulus untuk sidebar emoji */
        .emoji-sidebar {
            transition: all 0.2s ease;
        }
        .emoji-sidebar a {
            transition: all 0.2s ease;
        }
        .emoji-sidebar a:hover {
            transform: scale(1.1);
            background-color: #fef3c7;
        }
    </style>

    <script>
        const produkData = JSON.parse(`@json($produk)`);
    </script>
</head>

<body class="bg-slate-50 min-h-screen">
<div class="flex min-h-screen">

    <!-- ========== SIDEBAR KIRI (EMOJI ONLY, TIDAK LEBAR) ========== -->
    <aside class="emoji-sidebar w-16 bg-white border-r border-gray-200 flex flex-col items-center py-6 space-y-6 shadow-sm">
        <!-- Menu (rumah/daftar menu) -->
        <a href="#" class="flex flex-col items-center justify-center w-10 h-10 rounded-xl text-gray-600 hover:bg-amber-50 hover:text-amber-500 transition-all duration-200" title="Menu">
            <span class="text-2xl">🍽️</span>
        </a>
        
        <!-- Kasir (ikon kasir / mesin) -->
        <a href="/kasir/dashboard" class="flex flex-col items-center justify-center w-10 h-10 rounded-xl text-gray-600 hover:bg-amber-50 hover:text-amber-500 transition-all duration-200" title="Kasir">
            <span class="text-2xl">💰</span>
        </a>
        
        <!-- Transaksi (riwayat / nota) - SEKARANG LANGSUNG KE HALAMAN RIWAYAT TRANSAKSI -->
        <a href="/kasir/riwayat" class="flex flex-col items-center justify-center w-10 h-10 rounded-xl text-gray-600 hover:bg-amber-50 hover:text-amber-500 transition-all duration-200" title="Transaksi">
            <span class="text-2xl">📋</span>
        </a>
        
        <!-- Logout (keluar) -->
        <a href="#" class="flex flex-col items-center justify-center w-10 h-10 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-500 transition-all duration-200 mt-auto" title="Logout">
            <span class="text-2xl">🚪</span>
        </a>
    </aside>

    <!-- ========== SIDEBAR LAMA (BRAND + TIPE LAYANAN) ========== -->
    <aside class="w-full md:w-64 bg-white border-r border-gray-100 p-6 flex flex-col">
        <div class="flex items-center space-x-3 mb-10">
            <img src="{{ asset('boba.png') }}" class="w-10 h-10 object-contain" />
            <h1 class="text-xl font-bold text-gray-800">Boba <span class="text-yellow-500">Bliss</span></h1>
        </div>

        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Tipe Layanan</h2>
        <div class="space-y-3">
            <button id="dinein-btn" onclick="selectServiceType('Dine In')"
                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl border border-gray-200 transition-all duration-200 hover:bg-gray-50 text-gray-600 font-medium">
                <i class="fas fa-utensils"></i>
                <span>Dine In</span>
            </button>

            <button id="takeaway-btn" onclick="selectServiceType('Take Away')"
                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl border border-gray-200 transition-all duration-200 hover:bg-gray-50 text-gray-600 font-medium">
                <i class="fas fa-shopping-bag"></i>
                <span>Take Away</span>
            </button>
        </div>
    </aside>

    <!-- ========== MAIN CONTENT (MENU) ========== -->
    <main class="flex-1 p-4 md:p-8">
        <header class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Menu</h2>
            <p class="text-gray-500 text-sm">Pilih minuman favoritmu di bawah ini</p>
        </header>

        <div id="menu-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <!-- Menu items diisi oleh JS -->
        </div>
    </main>

    <!-- ========== KERANJANG (CART) ========== -->
    <aside class="w-full md:w-80 bg-white border-l border-gray-100 p-6 flex flex-col shadow-xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Keranjang</h3>
            <span id="cart-count" class="bg-yellow-100 text-yellow-600 text-xs font-bold px-2.5 py-0.5 rounded-full">0</span>
        </div>

        <div id="selected-service-info" class="hidden mb-4 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
            <p class="text-xs text-yellow-700 font-semibold" id="selected-service-text"></p>
        </div>

        <div id="cart-empty" class="flex-1 flex flex-col items-center justify-center text-gray-400 space-y-2 py-10 text-center">
            <i class="fas fa-shopping-basket text-4xl mb-2 opacity-20"></i>
            <p class="text-sm italic">Keranjang belanja<br>masih kosong</p>
        </div>

        <ul id="cart-items" class="flex-1 space-y-3 overflow-y-auto custom-scroll pr-2 hidden">
        </ul>

        <div class="mt-6 border-t border-gray-100 pt-6">
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500 font-medium">Total</span>
                <span class="text-xl font-bold text-gray-800">Rp<span id="cart-total">0</span></span>
            </div>

            <button onclick="confirmOrder()"
                class="w-full bg-green-500 text-white py-4 rounded-2xl font-bold transition-all hover:bg-green-600 hover:shadow-lg active:scale-95 flex items-center justify-center space-x-2">
                <span>Konfirmasi Pesanan</span>
                <i class="fas fa-check-circle"></i>
            </button>
        </div>
    </aside>

</div>

<script>
let cart = [];
let serviceType = "";

const menuItems = (produkData || []).map(item => ({
    id: item.id,
    nama: item.nama_produk,
    harga: parseInt(item.harga),
    gambar: item.gambar,
    stok: item.stok
}));

function selectServiceType(type) {
    serviceType = type;
    const infoBox = document.getElementById("selected-service-info");
    const infoText = document.getElementById("selected-service-text");
    
    infoBox.classList.remove("hidden");
    infoText.textContent = "📍 Mode: " + type;

    document.getElementById("dinein-btn").classList.remove("active-service");
    document.getElementById("takeaway-btn").classList.remove("active-service");

    if (type === "Dine In") {
        document.getElementById("dinein-btn").classList.add("active-service");
    } else {
        document.getElementById("takeaway-btn").classList.add("active-service");
    }
}

function loadMenu() {
    const menuContainer = document.getElementById("menu-container");
    menuContainer.innerHTML = "";

    menuItems.forEach(item => {
        const isOutOfStock = item.stok == 0;
        menuContainer.innerHTML += `
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                <div class="relative overflow-hidden rounded-2xl mb-4 bg-gray-50">
                    <img src="/storage/${item.gambar}" 
                         onerror="this.src='/default.png'"
                         class="w-full h-52 object-cover ${isOutOfStock ? 'grayscale opacity-50' : ''}" />
                </div>
                
                <h3 class="font-bold text-gray-800 text-base mb-1">${item.nama}</h3>
                <p class="text-yellow-600 font-bold text-lg mb-4">Rp${item.harga.toLocaleString("id-ID")}</p>
                
                <div class="flex items-center justify-between">
                    <span class="text-xs ${isOutOfStock ? 'text-red-500 font-bold' : 'text-gray-400'}">
                        ${isOutOfStock ? 'Stok Habis' : 'Tersedia: ' + item.stok}
                    </span>
                    
                    ${isOutOfStock ? '' : `
                        <div class="flex items-center bg-gray-100 rounded-xl p-1">
                            <button onclick="updateCart(${item.id}, -1)" class="w-8 h-8 flex items-center justify-center bg-white rounded-lg shadow-sm text-gray-500 hover:text-red-500">-</button>
                            <span id="qty-${item.id}" class="mx-3 font-bold text-gray-700 text-sm">0</span>
                            <button onclick="updateCart(${item.id}, 1)" class="w-8 h-8 flex items-center justify-center bg-yellow-400 rounded-lg shadow-sm text-white hover:bg-yellow-500">+</button>
                        </div>
                    `}
                </div>
            </div>
        `;
    });
}

function updateCart(id, change) {
    const product = menuItems.find(p => p.id === id);
    let found = cart.find(item => item.id === id);

    if (change > 0 && found && found.quantity >= product.stok) {
        alert("Stok tidak mencukupi!");
        return;
    }

    if (found) {
        found.quantity += change;
        if (found.quantity <= 0) {
            cart = cart.filter(item => item.id !== id);
        }
    } else if (change > 0) {
        cart.push({ id: product.id, name: product.nama, price: product.harga, quantity: 1 });
    }

    renderCart();
}

function renderCart() {
    const cartItemsEl = document.getElementById("cart-items");
    const cartTotal = document.getElementById("cart-total");
    const cartCount = document.getElementById("cart-count");
    const emptyState = document.getElementById("cart-empty");

    if (cart.length === 0) {
        cartItemsEl.classList.add("hidden");
        emptyState.classList.remove("hidden");
    } else {
        cartItemsEl.classList.remove("hidden");
        emptyState.classList.add("hidden");
    }

    cartItemsEl.innerHTML = "";
    let total = 0;
    let totalItems = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;
        totalItems += item.quantity;
        cartItemsEl.innerHTML += `
            <li class="flex justify-between items-center bg-gray-50 p-3 rounded-xl border border-gray-100">
                <div class="pr-2">
                    <p class="text-xs font-bold text-gray-800">${item.name}</p>
                    <p class="text-[10px] text-gray-400">${item.quantity} x Rp${item.price.toLocaleString("id-ID")}</p>
                </div>
                <span class="text-xs font-bold text-gray-700">Rp${(item.price * item.quantity).toLocaleString("id-ID")}</span>
            </li>
        `;
        
        const qtyEl = document.getElementById(`qty-${item.id}`);
        if (qtyEl) qtyEl.textContent = item.quantity;
    });

    // Reset qty if removed
    menuItems.forEach(mi => {
        if (!cart.find(c => c.id === mi.id)) {
            const el = document.getElementById(`qty-${mi.id}`);
            if (el) el.textContent = "0";
        }
    });

    cartTotal.textContent = total.toLocaleString("id-ID");
    cartCount.textContent = totalItems;
}

function confirmOrder() {
    if (!serviceType) { alert("Pilih tipe layanan!"); return; }
    if (cart.length === 0) { alert("Keranjang kosong!"); return; }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    fetch("/orders", {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
        body: JSON.stringify({
            customerId: "CUST-" + Math.floor(Math.random() * 100000),
            cart: cart,
            total: total,
            serviceType: serviceType,
            status: "pending"
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(`✅ Pesanan #${data.order_id} dikirim ke kasir.`);
            window.location.href = "/kasir/dashboard";
        } else {
            alert("Gagal memproses pesanan. Silakan coba lagi.");
        }
    })
    .catch(err => {
        console.error(err);
        alert("Terjadi kesalahan jaringan. Pastikan backend menyala.");
    });
}

// Event listener untuk sidebar tambahan (menu scroll & logout)
document.addEventListener("DOMContentLoaded", () => {
    loadMenu();
    
    // Ikon menu (🍽️) -> scroll ke menu container
    const menuEmoji = document.querySelector('.emoji-sidebar a[title="Menu"]');
    if (menuEmoji) {
        menuEmoji.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('main').scrollIntoView({ behavior: 'smooth' });
        });
    }
    
    // Ikon transaksi (📋) sekarang sudah menggunakan href="/kasir/riwayat" langsung di HTML
    // Tapi kita tambahkan sedikit fallback untuk memastikan navigasi berjalan tanpa konflik JS
    const transaksiEmoji = document.querySelector('.emoji-sidebar a[title="Transaksi"]');
    if (transaksiEmoji) {
        // Hapus event default jika ada yang bentrok, namun karena href sudah ada, biarkan saja
        // Namun kita pastikan tidak ada preventDefault yang mengganggu
        transaksiEmoji.addEventListener('click', (e) => {
            // Tidak melakukan preventDefault, biarkan href berjalan
            // Tapi jika ada event dari luar, kita biarkan navigasi default
            // Namun karena di struktur HTML sudah ada href="/kasir/riwayat", maka akan langsung pindah
            // Kode ini hanya untuk memastikan tidak ada error
        });
    }
    
    // Ikon logout (🚪) -> konfirmasi logout dan arahkan ke route logout
    const logoutEmoji = document.querySelector('.emoji-sidebar a[title="Logout"]');
    if (logoutEmoji) {
        logoutEmoji.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirm("Yakin ingin logout?")) {
                // Arahkan ke route logout Laravel (biasanya POST, tapi bisa juga pakai link GET jika disediakan)
                // Karena logout biasanya method POST dengan CSRF, kita buat form dinamis untuk keperluan demo
                const logoutForm = document.createElement('form');
                logoutForm.method = 'POST';
                logoutForm.action = '/logout';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                
                logoutForm.appendChild(csrfInput);
                document.body.appendChild(logoutForm);
                logoutForm.submit();
            }
        });
    }
});
</script>
</body>
</html>