<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            // Simpan URL yang dituju untuk redirect setelah login
            if ($request->is('dashboard') || $request->is('produk*') || $request->is('akun*') || $request->is('laporan*') || $request->is('monitor-transaksi*') || $request->is('log-activity*')) {
                session()->put('url.intended', $request->url());
            }
            
            // Redirect ke halaman login dengan pesan
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        return $next($request);
    }
}