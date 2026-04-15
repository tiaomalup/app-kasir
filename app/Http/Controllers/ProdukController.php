<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProdukController extends Controller
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
            Log::error('Log Activity Error: ' . $e->getMessage());
        }
    }

    // Menampilkan semua produk
    public function index()
    {
        $produk = Produk::all(); // Mengambil semua produk
        $this->logActivity('VIEW PRODUCTS', 'Admin melihat daftar produk');
        return view('admin.produk', compact('produk'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        $this->logActivity('VIEW CREATE FORM', 'Admin membuka form tambah produk');
    
        // Ambil ID terakhir + 1
        $lastId = Produk::max('id') ?? 0;
        $lastId = $lastId + 1;
    
        return view('admin.create', compact('lastId'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produk,kode_produk',
            'nama_produk' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $gambar,
        ]);

        $this->logActivity(
            'CREATE PRODUCT',
            'Admin menambahkan produk baru: ' . $request->nama_produk . 
            ' (Harga: Rp ' . number_format($request->harga, 0, ',', '.') . 
            ', Stok: ' . $request->stok . ')'
        );

        return redirect('/admin/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Menampilkan form edit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $this->logActivity(
            'VIEW EDIT FORM',
            'Admin membuka form edit produk: ' . $produk->nama_produk . ' (ID: ' . $id . ')'
        );
        return view('admin.produk_edit', compact('produk'));
    }

    
    // Menyimpan perubahan produk
public function update(Request $request, $id)
{
    $produk = Produk::findOrFail($id);
    
    // CEK APAKAH INI REQUEST TAMBAH STOK
    if ($request->has('tambah_stok') && $request->tambah_stok > 0) {
        $oldStok = $produk->stok;
        $produk->stok += $request->tambah_stok;
        $produk->save();
        
        $this->logActivity(
            'ADD STOCK',
            'Admin menambah stok produk: ' . $produk->nama_produk . 
            ' (Stok lama: ' . $oldStok . 
            ', Ditambah: ' . $request->tambah_stok . 
            ', Stok baru: ' . $produk->stok . ')'
        );
        
        return redirect('/admin/produk')->with('success', 'Stok berhasil ditambahkan!');
    }
    
    // JIKA BUKAN TAMBAH STOK, MAKA UPDATE BIASA
    $request->validate([
        'kode_produk' => 'required|unique:produk,kode_produk,' . $id,
        'nama_produk' => 'required',
        'harga' => 'required',
        'stok' => 'required',
    ]);
    
    // Simpan data lama untuk log
    $oldData = [
        'nama_produk' => $produk->nama_produk,
        'harga' => $produk->harga,
        'stok' => $produk->stok
    ];

    if ($request->hasFile('gambar')) {
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }
        $produk->gambar = $request->file('gambar')->store('produk', 'public');
    }

    $produk->update([
        'kode_produk' => $request->kode_produk,
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'gambar' => $produk->gambar,
    ]);

    // Log perubahan
    $changes = [];
    if ($oldData['nama_produk'] != $request->nama_produk) {
        $changes[] = "Nama: '{$oldData['nama_produk']}' → '{$request->nama_produk}'";
    }
    if ($oldData['harga'] != $request->harga) {
        $changes[] = "Harga: Rp " . number_format($oldData['harga'], 0, ',', '.') . 
                    " → Rp " . number_format($request->harga, 0, ',', '.');
    }
    if ($oldData['stok'] != $request->stok) {
        $changes[] = "Stok: {$oldData['stok']} → {$request->stok}";
    }
    if ($request->hasFile('gambar')) {
        $changes[] = "Gambar diperbarui";
    }

    $this->logActivity(
        'UPDATE PRODUCT',
        'Admin mengupdate produk ID ' . $id . ': ' . implode(', ', $changes)
    );

    return redirect('/admin/produk')->with('success', 'Produk berhasil diperbarui.');
}

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Simpan data produk untuk log
        $productInfo = $produk->nama_produk . ' (ID: ' . $id . ')';

        // Hapus gambar dari storage jika ada
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        $this->logActivity(
            'DELETE PRODUCT',
            'Admin menghapus produk: ' . $productInfo
        );

        return redirect('/admin/produk')->with('success', 'Produk berhasil dihapus!');
    }
}

