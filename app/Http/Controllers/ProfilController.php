<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;

class ProfilController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $admin = Auth::user();
        return view('admin.profil', compact('admin'));
    }

    // Menampilkan form edit profil
    public function edit()
    {
        $admin = Auth::user();
        return view('admin.edit_profil', compact('admin'));
    }

    // Memproses update profil
    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('uploads', 'public');
            $admin->profile_picture = 'storage/' . $path;
        }

        $admin->save();

        return redirect()->route('profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
