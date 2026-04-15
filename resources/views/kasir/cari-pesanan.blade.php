<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Pesanan - Kasir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Load Midtrans Snap JS -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ $midtransClientKey }}"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .payment-success {
            animation: success 0.5s ease-in-out;
        }
        @keyframes success {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .loading-content {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<!-- Navigation Header -->
<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-3">
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                </svg>
                <h1 class="text-xl font-bold text-gray-800">Sistem Kasir</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Kasir: {{ auth('kasir')->user()->name ?? 'Kasir' }}</span>
                <a href="{{ route('kasir.dashboard') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
                    Dashboard
                </a>
                <a href="{{ route('kasir.logout') }}" 
                   onclick="return confirm('Yakin logout dari kasir?')"
                   class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg transition duration-200">
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- DEBUG PANEL -->
<div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mx-4 mt-4">
    <div class="flex justify-between items-center">
        <div>
            <h3 class="font-bold text-yellow-800">🔧 DEBUG INFO - Order #{{ $order->id }}</h3>
            <div class="text-sm text-yellow-700 mt-1">
                <span class="inline-block mr-4"><strong>Status:</strong> 
                    @if($order->status == 'pending')
                        <span class="text-green-600 font-bold">PENDING (Tombol harus muncul)</span>
                    @else
                        <span class="text-red-600 font-bold">{{ strtoupper($order->status) }} (Tombol TIDAK muncul)</span>
                    @endif
                </span>
                <span class="inline-block mr-4"><strong>Payment Method:</strong> {{ $order->payment_method ?? 'null' }}</span>
                <span class="inline-block"><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
        @if($order->status == 'paid')
        <div>
            <a href="{{ route('kasir.struk', $order->id) }}" 
               class="inline-block bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 mr-2">
                Lihat Struk
            </a>
        </div>
        @endif
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <!-- Flash Messages -->
    @if(session('error'))
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="max-w-4xl mx-auto">
        <!-- Header Pesanan -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Detail Pesanan</h2>
                        <p class="text-blue-100">ID: ORD-{{ $order->id }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-4 py-2 rounded-full text-white font-bold
                            @if($order->status == 'pending') bg-yellow-500
                            @elseif($order->status == 'paid') bg-green-500
                            @else bg-gray-500 @endif">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Info Pesanan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold text-gray-700 mb-2">📋 Informasi Pesanan</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Customer ID:</span>
                                <span class="font-medium">{{ $order->customer_id ?? 'Guest' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode Pembayaran:</span>
                                <span class="font-medium">{{ $order->payment_method ? ucfirst($order->payment_method) : '-' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold text-gray-700 mb-2">💰 Informasi Pembayaran</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Tagihan:</span>
                                <span class="font-bold text-lg text-blue-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                            @if($order->uang_masuk)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Uang Masuk:</span>
                                <span class="font-medium">Rp {{ number_format($order->uang_masuk, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($order->kembalian)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kembalian:</span>
                                <span class="font-medium text-green-600">Rp {{ number_format($order->kembalian, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Daftar Items -->
                <div class="border-t pt-6">
                    <h3 class="font-bold text-lg mb-4">🛒 Daftar Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-3 px-4 text-left">Item</th>
                                    <th class="py-3 px-4 text-center">Qty</th>
                                    <th class="py-3 px-4 text-left">Harga</th>
                                    <th class="py-3 px-4 text-left">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <div class="font-medium">{{ $item->name }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-block bg-gray-100 px-3 py-1 rounded-full">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 font-medium">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="py-4 px-4 text-right font-bold">
                                        TOTAL
                                    </td>
                                    <td class="py-4 px-4 font-bold text-lg text-blue-600">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- PEMBAYARAN SECTION -->
        <div class="mb-8">
            @if($order->status == 'pending')
            <!-- Tombol Pembayaran Tampil -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Cash Payment -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden payment-success">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M3 8V7h2v1H3zm6 0V7h2v1H9zm-4 4v1h10v-1H5z" clip-rule="evenodd"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">💵 Bayar Cash</h2>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-3">Masukkan Uang Tunai</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" 
                                       id="uang_masuk" 
                                       placeholder="Contoh: 50000"
                                       min="{{ $order->total }}"
                                       step="1000"
                                       class="w-full border-2 border-gray-300 rounded-xl px-12 py-4 text-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200">
                            </div>
                            <p id="kembalian_info" class="text-sm mt-3 font-medium"></p>
                        </div>
                        
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <h4 class="font-bold text-green-800 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Informasi Cash
                            </h4>
                            <ul class="text-green-700 text-sm space-y-1">
                                <li>• Masukkan uang tunai yang diterima</li>
                                <li>• Sistem akan menghitung kembalian otomatis</li>
                                <li>• Minimal pembayaran: Rp {{ number_format($order->total, 0, ',', '.') }}</li>
                            </ul>
                        </div>
                        
                        <button onclick="bayarCash({{ $order->id }})"
                                id="btn-cash"
                                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-4 rounded-xl transition duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <span id="btn-cash-text">Proses Pembayaran Cash</span>
                        </button>
                    </div>
                </div>

                <!-- QRIS Payment -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden payment-success">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">📱 Bayar QRIS</h2>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <div class="inline-block p-4 bg-blue-50 rounded-full mb-4">
                                <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v8l4-2 4 2V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Pembayaran Digital</h3>
                            <p class="text-gray-600">Scan QR code dengan aplikasi e-wallet</p>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <h4 class="font-bold text-blue-800 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Cara Pembayaran QRIS
                            </h4>
                            <ol class="text-blue-700 text-sm space-y-2">
                                <li>1. Klik tombol "Bayar dengan QRIS"</li>
                                <li>2. Popup QR code akan muncul</li>
                                <li>3. Scan QR code dengan aplikasi e-wallet</li>
                                <li>4. Selesaikan pembayaran di aplikasi</li>
                                <li>5. Tunggu konfirmasi otomatis</li>
                            </ol>
                        </div>
                        
                        <button onclick="bayarQris({{ $order->id }})"
                                id="btn-qris"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-4 rounded-xl transition duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <span id="btn-qris-text">Bayar dengan QRIS</span>
                        </button>
                    </div>
                </div>
            </div>
            @else
            <!-- Jika sudah dibayar -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8 text-center">
                    <div class="inline-block p-4 bg-white bg-opacity-20 rounded-full mb-4">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Pembayaran Selesai!</h2>
                    <p class="text-green-100 mb-6">Pesanan ini sudah berhasil dibayar.</p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('kasir.struk', $order->id) }}" 
                           target="_blank"
                           class="bg-white text-green-600 hover:bg-gray-100 font-bold py-3 px-6 rounded-xl transition duration-200">
                            Cetak Struk
                        </a>
                        <a href="{{ route('kasir.dashboard') }}" 
                           class="bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-6 rounded-xl transition duration-200">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('kasir.dashboard') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                </svg>
                Kembali ke Dashboard
            </a>
            
            @if($order->status == 'paid')
            <div class="text-sm text-gray-500">
                Dibayar pada: {{ $order->paid_at ? $order->paid_at->format('d/m/Y H:i') : '-' }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-8 max-w-sm w-full mx-4">
        <div class="text-center">
            <div class="spinner"></div>
            <h3 class="text-lg font-bold text-gray-800 mb-2" id="loadingText">Memproses...</h3>
            <p class="text-gray-600" id="loadingSubtext">Mohon tunggu sebentar</p>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const totalAmount = {{ $order->total }};
const orderStatus = "{{ $order->status }}";

// Debug info
console.log('Order Status:', orderStatus);
console.log('Total Amount:', totalAmount);
console.log('CSRF Token:', csrfToken);

// Format currency
function formatCurrency(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

// Show loading modal
function showLoading(text = 'Memproses...', subtext = 'Mohon tunggu sebentar') {
    document.getElementById('loadingText').textContent = text;
    document.getElementById('loadingSubtext').textContent = subtext;
    document.getElementById('loadingModal').style.display = 'flex';
}

// Hide loading modal
function hideLoading() {
    document.getElementById('loadingModal').style.display = 'none';
}

// Hitung kembalian untuk cash (hanya jika ada input)
const uangMasukInput = document.getElementById('uang_masuk');
if (uangMasukInput) {
    uangMasukInput.addEventListener('input', function() {
        const uangMasuk = parseFloat(this.value) || 0;
        const btnCash = document.getElementById('btn-cash');
        const infoEl = document.getElementById('kembalian_info');
        
        if (uangMasuk >= totalAmount) {
            const kembalian = uangMasuk - totalAmount;
            infoEl.innerHTML = `<span class="text-green-600 font-bold">✅ Kembalian: ${formatCurrency(kembalian)}</span>`;
            btnCash.disabled = false;
        } else {
            const kurang = totalAmount - uangMasuk;
            infoEl.innerHTML = `<span class="text-red-600 font-bold">❌ Kurang: ${formatCurrency(kurang)}</span>`;
            btnCash.disabled = true;
        }
    });
}

// Bayar Cash
async function bayarCash(orderId) {
    const uangMasukInput = document.getElementById('uang_masuk');
    const uangMasuk = uangMasukInput.value;
    
    if (!uangMasuk || parseFloat(uangMasuk) < totalAmount) {
        alert('Masukkan uang yang cukup!');
        uangMasukInput.focus();
        return;
    }
    
    const uangMasukNum = parseFloat(uangMasuk);
    const kembalian = uangMasukNum - totalAmount;
    
    const confirmation = confirm(
        `Konfirmasi Pembayaran Cash:\n\n` +
        `Total: ${formatCurrency(totalAmount)}\n` +
        `Uang masuk: ${formatCurrency(uangMasukNum)}\n` +
        `Kembalian: ${formatCurrency(kembalian)}\n\n` +
        `Lanjutkan pembayaran?`
    );
    
    if (!confirmation) return;
    
    try {
        showLoading('Memproses Pembayaran Cash', 'Tunggu sebentar...');
        
        const btnCash = document.getElementById('btn-cash');
        btnCash.disabled = true;
        btnCash.innerHTML = '<span class="animate-pulse">Memproses...</span>';
        
        const response = await fetch('/kasir/bayar-cash', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                order_id: orderId,
                uang_masuk: uangMasukNum
            })
        });
        
        const data = await response.json();
        hideLoading();
        
        if (data.success) {
            alert(`✅ Pembayaran Cash Berhasil!\n\n` +
                  `Total: ${formatCurrency(totalAmount)}\n` +
                  `Uang masuk: ${formatCurrency(uangMasukNum)}\n` +
                  `Kembalian: ${formatCurrency(data.kembalian)}\n\n` +
                  `Halaman akan dialihkan ke struk...`);
            
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        } else {
            alert(`❌ Gagal: ${data.message}`);
            btnCash.disabled = false;
            btnCash.innerHTML = '<span>Proses Pembayaran Cash</span>';
        }
    } catch (error) {
        hideLoading();
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan pada server: ' + error.message);
        
        const btnCash = document.getElementById('btn-cash');
        if (btnCash) {
            btnCash.disabled = false;
            btnCash.innerHTML = '<span>Proses Pembayaran Cash</span>';
        }
    }
}

// Bayar QRIS
async function bayarQris(orderId) {
    const confirmation = confirm(
        `Konfirmasi Pembayaran QRIS\n\n` +
        `Total Tagihan: ${formatCurrency(totalAmount)}\n\n` +
        `Lanjutkan pembayaran dengan QRIS?`
    );

    if (!confirmation) return;

    try {
        showLoading('Menyiapkan QRIS', 'Menghubungkan ke Midtrans...');
        
        const btnQris = document.getElementById('btn-qris');
        btnQris.disabled = true;
        btnQris.innerHTML = '<span class="animate-pulse">Memproses...</span>';

        const response = await fetch('/kasir/bayar-qris', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                order_id: orderId
            })
        });

        const data = await response.json();
        hideLoading();

        console.log('QRIS Response:', data);

        if (!data.success) {
            alert(`❌ Gagal: ${data.message || 'Token Midtrans tidak ditemukan'}`);
            btnQris.disabled = false;
            btnQris.innerHTML = '<span>Bayar dengan QRIS</span>';
            return;
        }

        if (!data.token) {
            alert("❌ Token Midtrans tidak ditemukan");
            btnQris.disabled = false;
            btnQris.innerHTML = '<span>Bayar dengan QRIS</span>';
            return;
        }

        // Tampilkan popup pembayaran Midtrans
        if (typeof snap !== 'undefined') {
            snap.pay(data.token, {
                onSuccess: async function(result) {
                    console.log('Payment Success:', result);
                    
                    showLoading('Memproses Pembayaran', 'Mengupdate status pesanan...');
                    
                    try {
                        const updateResponse = await fetch('/kasir/update-status-qris', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                order_id: orderId,
                                transaction_id: result.transaction_id,
                                payment_type: result.payment_type
                            })
                        });
                        
                        const updateData = await updateResponse.json();
                        hideLoading();
                        
                        if (updateData.success) {
                            alert(`✅ Pembayaran QRIS Berhasil!\n\n` +
                                  `Total: ${formatCurrency(totalAmount)}\n` +
                                  `Order ID: #${orderId}\n\n` +
                                  `Halaman akan dialihkan ke struk...`);
                            
                            if (updateData.redirect) {
                                window.location.href = updateData.redirect;
                            } else {
                                window.location.reload();
                            }
                        } else {
                            alert(`⚠️ Pembayaran berhasil tapi update status gagal: ${updateData.message}`);
                            window.location.reload();
                        }
                    } catch (error) {
                        hideLoading();
                        console.error('Error updating status:', error);
                        alert('⚠️ Pembayaran berhasil, tapi terjadi kesalahan saat update status. Silakan refresh halaman.');
                        window.location.reload();
                    }
                },
                
                onPending: function(result) {
                    hideLoading();
                    console.log('Payment Pending:', result);
                    alert(`⏳ Menunggu pembayaran QRIS\n\n` +
                          `Silakan selesaikan pembayaran di aplikasi e-wallet Anda.\n` +
                          `Status: ${result.status_message || 'Menunggu pembayaran'}`);
                    
                    // Cek status secara berkala
                    checkPaymentStatus(orderId);
                },
                
                onError: function(result) {
                    hideLoading();
                    console.error('Payment Error:', result);
                    alert(`❌ Pembayaran QRIS Gagal!\n\n` +
                          `Error: ${result.status_message || 'Unknown error'}\n\n` +
                          `Silakan coba lagi.`);
                    
                    const btnQris = document.getElementById('btn-qris');
                    btnQris.disabled = false;
                    btnQris.innerHTML = '<span>Bayar dengan QRIS</span>';
                },
                
                onClose: function() {
                    hideLoading();
                    console.log('Payment popup closed');
                    alert('❌ Pembayaran dibatalkan');
                    
                    const btnQris = document.getElementById('btn-qris');
                    btnQris.disabled = false;
                    btnQris.innerHTML = '<span>Bayar dengan QRIS</span>';
                }
            });
        } else {
            alert('❌ Midtrans Snap tidak terload. Silakan refresh halaman.');
            btnQris.disabled = false;
            btnQris.innerHTML = '<span>Bayar dengan QRIS</span>';
        }

    } catch (error) {
        hideLoading();
        console.error('Error in bayarQris:', error);
        alert(`❌ Terjadi kesalahan: ${error.message || 'Unknown error'}`);
        
        const btnQris = document.getElementById('btn-qris');
        if (btnQris) {
            btnQris.disabled = false;
            btnQris.innerHTML = '<span>Bayar dengan QRIS</span>';
        }
    }
}

// Fungsi untuk mengecek status pembayaran
async function checkPaymentStatus(orderId) {
    let attempts = 0;
    const maxAttempts = 30; // 30 detik
    const interval = setInterval(async () => {
        attempts++;
        
        try {
            const response = await fetch(`/kasir/cek-status/${orderId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.status === 'paid') {
                clearInterval(interval);
                alert(`✅ Pembayaran QRIS Berhasil!\n\nTotal: ${formatCurrency(totalAmount)}`);
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.href = `/kasir/struk/${orderId}`;
                }
            } else if (attempts >= maxAttempts) {
                clearInterval(interval);
                alert('⏰ Waktu pengecekan habis. Silakan refresh halaman untuk melihat status terbaru.');
            }
        } catch (error) {
            console.error('Error checking payment status:', error);
        }
    }, 1000);
}

// Auto focus on cash input if pending
if (orderStatus === 'pending') {
    document.addEventListener('DOMContentLoaded', function() {
        const uangMasukInput = document.getElementById('uang_masuk');
        if (uangMasukInput) {
            uangMasukInput.focus();
            uangMasukInput.select();
        }
    });
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + 1 untuk focus cash input
    if (e.ctrlKey && e.key === '1') {
        e.preventDefault();
        const input = document.getElementById('uang_masuk');
        if (input) {
            input.focus();
            input.select();
        }
    }
    
    // Ctrl + 2 untuk bayar QRIS
    if (e.ctrlKey && e.key === '2') {
        e.preventDefault();
        const btn = document.getElementById('btn-qris');
        if (btn && !btn.disabled) {
            bayarQris({{ $order->id }});
        }
    }
    
    // Enter pada cash input untuk bayar cash
    if (e.key === 'Enter' && e.target.id === 'uang_masuk') {
        e.preventDefault();
        const btn = document.getElementById('btn-cash');
        if (btn && !btn.disabled) {
            bayarCash({{ $order->id }});
        }
    }
});
</script>

</body>
</html>