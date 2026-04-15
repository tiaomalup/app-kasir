<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasir;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AkunController extends Controller
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

    /**
     * =========================
     * TAMPILKAN DATA KASIR
     * =========================
     */
    public function index()
    {
        $akun = Kasir::orderBy('id', 'desc')->get();
        
        $this->logActivity(
            'VIEW KASIR ACCOUNTS',
            'Admin melihat daftar akun kasir (Total: ' . $akun->count() . ' akun)'
        );
        
        return view('admin.akun', compact('akun'));
    }

    /**
     * =========================
     * FORM TAMBAH KASIR
     * =========================
     */
    public function create()
    {
        $this->logActivity(
            'VIEW CREATE KASIR FORM',
            'Admin membuka form tambah akun kasir'
        );
        
        return view('admin.create_akun');
    }

    /**
     * =========================
     * SIMPAN DATA KASIR
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:kasirs,username',
            'password' => 'required|string|min:5',
        ]);

        $kasir = Kasir::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // WAJIB hash
        ]);

        $this->logActivity(
            'CREATE KASIR ACCOUNT',
            'Admin menambahkan akun kasir baru: ' . $request->username . ' (ID: ' . $kasir->id . ')'
        );

        return redirect('/admin/akun')->with('success', 'Akun kasir berhasil ditambahkan.');
    }

    /**
     * =========================
     * FORM EDIT KASIR
     * =========================
     */
    public function edit($id)
    {
        $akun = Kasir::findOrFail($id);
        
        $this->logActivity(
            'VIEW EDIT KASIR FORM',
            'Admin membuka form edit akun kasir: ' . $akun->username . ' (ID: ' . $id . ')'
        );
        
        return view('admin.edit_akun', compact('akun'));
    }

    /**
     * =========================
     * UPDATE DATA KASIR
     * =========================
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:kasirs,username,' . $id,
            'password' => 'nullable|string|min:5',
        ]);

        $akun = Kasir::findOrFail($id);
        
        // Simpan data lama untuk log
        $oldUsername = $akun->username;
        $passwordChanged = false;

        $data = [
            'username' => $request->username,
        ];

        // jika password diisi, update password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $passwordChanged = true;
        }

        $akun->update($data);

        // Prepare log description
        $changes = [];
        if ($oldUsername != $request->username) {
            $changes[] = "Username: '{$oldUsername}' → '{$request->username}'";
        }
        if ($passwordChanged) {
            $changes[] = "Password diperbarui";
        }
        
        $description = "Admin mengupdate akun kasir ID: {$id}";
        if (!empty($changes)) {
            $description .= " (" . implode(', ', $changes) . ")";
        }

        $this->logActivity('UPDATE KASIR ACCOUNT', $description);

        return redirect('/admin/akun')->with('success', 'Akun kasir berhasil diperbarui.');
    }

    /**
     * =========================
     * HAPUS DATA KASIR
     * =========================
     */
    public function destroy($id)
    {
        $akun = Kasir::findOrFail($id);
        $username = $akun->username;
        
        // Optional: Prevent admin from deleting their own account
        if (auth()->check() && auth()->user()->id == $id) {
            $this->logActivity(
                'DELETE KASIR ACCOUNT FAILED',
                'Admin mencoba menghapus akun sendiri: ' . $username
            );
            
            return redirect('/admin/akun')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        
        $akun->delete();

        $this->logActivity(
            'DELETE KASIR ACCOUNT',
            'Admin menghapus akun kasir: ' . $username . ' (ID: ' . $id . ')'
        );

        return redirect('/admin/akun')->with('success', 'Akun kasir berhasil dihapus.');
    }

    /**
     * =========================
     * RESET PASSWORD KASIR
     * =========================
     */
    public function resetPassword($id)
    {
        try {
            $akun = Kasir::findOrFail($id);
            $defaultPassword = 'password123'; // You can change this or make it configurable
            
            $akun->update([
                'password' => Hash::make($defaultPassword)
            ]);
            
            $this->logActivity(
                'RESET KASIR PASSWORD',
                'Admin mereset password akun kasir: ' . $akun->username . ' (ID: ' . $id . ')'
            );
            
            return redirect('/admin/akun')->with('success', 'Password berhasil direset menjadi: ' . $defaultPassword);
            
        } catch (\Exception $e) {
            Log::error('Reset Password Error: ' . $e->getMessage());
            
            $this->logActivity(
                'RESET PASSWORD FAILED',
                'Gagal mereset password akun ID: ' . $id . ' - Error: ' . $e->getMessage()
            );
            
            return redirect('/admin/akun')->with('error', 'Gagal mereset password: ' . $e->getMessage());
        }
    }

    /**
     * =========================
     * TOGGLE AKUN STATUS (Aktif/Nonaktif)
     * =========================
     */
    public function toggleStatus($id)
    {
        try {
            $akun = Kasir::findOrFail($id);
            
            // Prevent admin from deactivating their own account
            if (auth()->check() && auth()->user()->id == $id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menonaktifkan akun sendiri'
                ], 403);
            }
            
            $newStatus = !$akun->is_active; // Assuming you have 'is_active' column
            $akun->update(['is_active' => $newStatus]);
            
            $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            
            $this->logActivity(
                'TOGGLE KASIR STATUS',
                'Admin ' . $statusText . ' akun kasir: ' . $akun->username . ' (ID: ' . $id . ')'
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Status akun berhasil diperbarui',
                'is_active' => $newStatus
            ]);
            
        } catch (\Exception $e) {
            Log::error('Toggle Status Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status akun'
            ], 500);
        }
    }

    /**
     * =========================
     * BULK DELETE KASIR ACCOUNTS
     * =========================
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:kasirs,id'
            ]);
            
            $ids = $request->ids;
            $count = count($ids);
            
            // Prevent deleting own account
            if (auth()->check() && in_array(auth()->user()->id, $ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menghapus akun sendiri'
                ], 403);
            }
            
            // Get usernames for logging
            $usernames = Kasir::whereIn('id', $ids)->pluck('username')->implode(', ');
            
            Kasir::whereIn('id', $ids)->delete();
            
            $this->logActivity(
                'BULK DELETE KASIR ACCOUNTS',
                'Admin menghapus ' . $count . ' akun kasir: ' . $usernames
            );
            
            return response()->json([
                'success' => true,
                'message' => $count . ' akun kasir berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Bulk Delete Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus akun: ' . $e->getMessage()
            ], 500);
        }
    }
}