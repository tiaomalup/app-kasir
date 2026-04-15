<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $filterTanggal = $request->input('tanggal');

        // QUERY DASAR
        $query = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid');

        // HANYA FILTER JIKA ADA INPUT TANGGAL
        if ($filterTanggal) {
            $query->whereDate('orders.created_at', $filterTanggal);
        }

        $laporan = $query
            ->select(
                'order_items.name',
                'order_items.price',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_pendapatan')
            )
            ->groupBy('order_items.name', 'order_items.price')
            ->get();

        // TOTAL PENJUALAN
        $totalPenjualan = $laporan->sum('total_pendapatan');

        // JUMLAH PESANAN
        $jumlahPesanan = DB::table('orders')
            ->where('status', 'paid')
            ->when($filterTanggal, function ($query) use ($filterTanggal) {
                return $query->whereDate('created_at', $filterTanggal);
            })
            ->count();

        // PRODUK TERLARIS
        $produkTerlaris = $laporan->sortByDesc('total_qty')->first();

        // RINGKASAN MINGGUAN
        $mingguan = DB::table('orders')
            ->selectRaw('DAYNAME(created_at) as hari, COUNT(*) as jumlah, SUM(total) as total')
            ->where('status', 'paid')
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->groupByRaw('DAYNAME(created_at)')
            ->get();

        return view('admin.laporan', compact(
            'laporan',
            'totalPenjualan',
            'jumlahPesanan',
            'produkTerlaris',
            'mingguan',
            'filterTanggal'
        ));
    }
}