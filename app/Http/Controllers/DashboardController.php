<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Produk;
use App\Models\Kasir;
use App\Models\LogActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * =============================
     * SIMPAN LOG ACTIVITY
     * =============================
     */
    private function logActivity($action, $description = null)
    {
        try {
            LogActivity::create([
                'user_id' => auth()->check() ? auth()->user()->id : null,
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip()
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Log Activity Error: ' . $e->getMessage());
        }
    }

    /**
     * =============================
     * DASHBOARD UTAMA
     * =============================
     */
    public function index()
    {
        // Statistik Total Penjualan (semua waktu)
        $totalPenjualan = Order::where('status', 'paid')->count();
        $totalRevenue = Order::where('status', 'paid')->sum('total');
        
        // Statistik Hari Ini
        $today = Carbon::today();
        $pesananHariIni = Order::whereDate('created_at', $today)
                               ->where('status', 'paid')
                               ->count();
        $revenueHariIni = Order::whereDate('created_at', $today)
                               ->where('status', 'paid')
                               ->sum('total');
        
        // Produk Terlaris
        $produkTerlaris = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->select(
                'order_items.name',
                DB::raw('SUM(order_items.quantity) as total_quantity')
            )
            ->groupBy('order_items.name')
            ->orderBy('total_quantity', 'desc')
            ->first();
        
        // Pendapatan Bulan Ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $pendapatanBulanIni = Order::where('status', 'paid')
                                   ->whereDate('created_at', '>=', $startOfMonth)
                                   ->sum('total');
        
        // Data untuk grafik (6 bulan terakhir)
        $chartData = $this->getChartData();
        
        // Statistik tambahan
        $statistics = [
            'total_products' => Produk::count(),
            'total_kasir' => Kasir::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock_products' => Produk::where('stok', '<=', 10)->count(),
        ];
        
        // Transaksi terbaru
        $recentOrders = Order::with('items')
                            ->where('status', 'paid')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
        
        // Log activity
        $this->logActivity('VIEW DASHBOARD', 'Admin membuka halaman dashboard');
        
        return view('admin.dashboard', compact(
            'totalPenjualan',
            'totalRevenue',
            'pesananHariIni',
            'revenueHariIni',
            'produkTerlaris',
            'pendapatanBulanIni',
            'chartData',
            'statistics',
            'recentOrders'
        ));
    }
    
    /**
     * =============================
     * GET DATA UNTUK GRAFIK (6 Bulan Terakhir)
     * =============================
     */
    private function getChartData()
    {
        $months = collect();
        $currentDate = Carbon::now();
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M');
            
            $total = Order::where('status', 'paid')
                         ->whereYear('created_at', $date->year)
                         ->whereMonth('created_at', $date->month)
                         ->sum('total');
            
            $count = Order::where('status', 'paid')
                         ->whereYear('created_at', $date->year)
                         ->whereMonth('created_at', $date->month)
                         ->count();
            
            $months->push([
                'month' => $monthName,
                'total' => $total,
                'count' => $count
            ]);
        }
        
        return $months;
    }
    
    /**
     * =============================
     * GET DATA REAL-TIME UNTUK AJAX
     * =============================
     */
    public function getRealtimeData()
    {
        try {
            $today = Carbon::today();
            
            $data = [
                'total_penjualan' => Order::where('status', 'paid')->count(),
                'pesanan_hari_ini' => Order::whereDate('created_at', $today)->where('status', 'paid')->count(),
                'revenue_hari_ini' => Order::whereDate('created_at', $today)->where('status', 'paid')->sum('total'),
                'pendapatan_bulan_ini' => Order::where('status', 'paid')
                                               ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
                                               ->sum('total'),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'total_products' => Produk::count(),
                'low_stock' => Produk::where('stok', '<=', 10)->count(),
            ];
            
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data real-time'
            ], 500);
        }
    }
}