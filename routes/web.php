<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KasirLoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KasirTransaksiController;
use App\Http\Controllers\MonitorTransaksiController;

// =============================
// AUTH (Login Admin) - TANPA MIDDLEWARE
// =============================
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman login kasir
Route::get('/kasir/login', [KasirLoginController::class, 'showLoginForm'])->name('kasir.login');
Route::post('/kasir/login', [KasirLoginController::class, 'login'])->name('kasir.login.submit');

// =============================
// REDIRECT ROOT
// =============================
Route::get('/', function () {
    // Jika sudah login sebagai admin, redirect ke dashboard admin
    if (Auth::guard('web')->check()) {
        return redirect('/admin/dashboard');
    }
    // Jika sudah login sebagai kasir, redirect ke dashboard kasir
    if (Auth::guard('kasir')->check()) {
        return redirect('/kasir/dashboard');
    }
    // Jika belum login, redirect ke halaman login admin
    return redirect('/admin/login');
});

// =============================
// ROUTE ADMIN (Protected with auth:web & prefix admin)
// =============================
Route::prefix('admin')->middleware(['auth:web'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/realtime-data', [DashboardController::class, 'getRealtimeData'])->name('dashboard.realtime');
    
    // Manajemen Pesanan
    Route::get('/manajemen', [PesananController::class, 'index'])->name('manajemen.index');
    Route::get('/manajemen/create', [PesananController::class, 'create'])->name('manajemen.create');
    Route::post('/manajemen', [PesananController::class, 'store'])->name('manajemen.store');
    Route::get('/manajemen/{id}/edit', [PesananController::class, 'edit'])->name('manajemen.edit');
    Route::put('/manajemen/{id}', [PesananController::class, 'update'])->name('manajemen.update');
    Route::delete('/manajemen/{id}', [PesananController::class, 'destroy'])->name('manajemen.destroy');

    // Manajemen Produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/produk/{namaProduk}', [LaporanController::class, 'detailProduk'])->name('laporan.detail-produk');
    Route::get('/laporan/tahunan', [LaporanController::class, 'tahunan'])->name('laporan.tahunan');

    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');

    // Manajemen Akun Kasir
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::get('/akun/create', [AkunController::class, 'create'])->name('akun.create');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
    Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])->name('akun.edit');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');
    
    // Tambahan route akun
    Route::get('/akun-cari', [AkunController::class, 'cari'])->name('akun.cari');
    Route::post('/akun/{id}/status', [AkunController::class, 'ubahStatus'])->name('akun.status');
    Route::post('/akun/{id}/reset-password', [AkunController::class, 'resetPassword'])->name('akun.resetPassword');
    Route::get('/akun-export', [AkunController::class, 'export'])->name('akun.export');
    Route::post('/akun/bulk-delete', [AkunController::class, 'bulkDelete'])->name('akun.bulk-delete');

    // Pantau Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::put('/transaksi/{id}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.update-status');
    Route::get('/transaksi/{id}/print', [TransaksiController::class, 'print'])->name('transaksi.print');
    Route::get('/transaksi/export', [TransaksiController::class, 'export'])->name('transaksi.export');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    
    // Monitor Transaksi (Alternatif)
    Route::get('/monitor-transaksi', [MonitorTransaksiController::class, 'index'])->name('monitor-transaksi.index');
    Route::get('/monitor-transaksi/{id}', [MonitorTransaksiController::class, 'show'])->name('monitor-transaksi.show');
    Route::put('/monitor-transaksi/{id}/status', [MonitorTransaksiController::class, 'updateStatus'])->name('monitor-transaksi.update-status');
    Route::get('/monitor-transaksi/{id}/print', [MonitorTransaksiController::class, 'print'])->name('monitor-transaksi.print');
    Route::get('/monitor-transaksi/export', [MonitorTransaksiController::class, 'export'])->name('monitor-transaksi.export');
    Route::delete('/monitor-transaksi/{id}', [MonitorTransaksiController::class, 'destroy'])->name('monitor-transaksi.destroy');
    Route::get('/monitor-transaksi/realtime/data', [MonitorTransaksiController::class, 'getRealtimeData'])->name('monitor-transaksi.realtime');
    
    // Log Activity
    Route::get('/log-activity', [KasirController::class, 'activity'])->name('log.activity');
});

// =============================
// ROUTE KASIR (Protected with auth:kasir)
// =============================
Route::middleware(['auth:kasir'])->group(function () {
    
    // Dashboard Kasir
    Route::get('/kasir/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
    
    // Cari Pesanan
    Route::get('/kasir/cari-pesanan', [KasirController::class, 'cariPesanan'])->name('kasir.cariPesanan');
    
    // Reset Order
    Route::get('/kasir/reset-order/{id}', [KasirController::class, 'resetOrder'])->name('kasir.reset-order');
    
    // Proses Pembayaran
    Route::post('/kasir/proses-pembayaran', [KasirController::class, 'prosesPembayaran'])->name('kasir.prosesPembayaran');
    
    // Pembayaran Cash
    Route::post('/kasir/bayar-cash', [KasirController::class, 'bayarCash'])->name('kasir.bayar-cash');
    
    // Pembayaran QRIS
    Route::post('/kasir/bayar-qris', [KasirController::class, 'bayarQris'])->name('kasir.bayar-qris');
    
    // Struk Pembayaran
    Route::get('/kasir/struk/{id}', [KasirController::class, 'struk'])->name('kasir.struk');
    
    // Riwayat Transaksi
    Route::get('/kasir/riwayat', [KasirController::class, 'riwayat'])->name('kasir.riwayat');
    
    Route::post('/kasir/logout', [KasirController::class, 'logout'])->name('kasir.logout');
});

// =============================
// ROUTE PUBLIK (Tanpa Middleware)
// =============================

// QRIS Payment
Route::post('/kasir/update-status-qris', [KasirController::class, 'updateStatusQris']);
Route::get('/kasir/cek-status/{id}', [KasirController::class, 'cekStatus']);

// Midtrans Callback (Webhook)
Route::post('/midtrans/callback', [KasirController::class, 'callback'])->name('midtrans.callback');

// API Publik untuk Menu & Order (User/Customer)
Route::middleware(['auth:kasir'])->group(function () {
    Route::get('/kasir/menus', [MenuController::class, 'index'])->name('kasir.menus');
});
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders', function () {
    return view('user.order');
})->name('orders.view');
Route::post('/orders/{id}/bayar', [OrderController::class, 'bayar']);

// =============================
// FALLBACK ROUTE (404)
// =============================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});