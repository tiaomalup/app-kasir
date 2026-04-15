<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirLoginController extends Controller
{
    public function showLoginForm()
{
    return view('kasir.login_kasir'); // sesuai dengan letak file kamu
}


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('kasir')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            return redirect()->intended('/kasir/menus');
        }

        return back()->with('error', 'Username atau password salah');
    }
}
