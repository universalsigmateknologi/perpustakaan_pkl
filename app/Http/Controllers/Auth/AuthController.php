<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Proses autentikasi
    public function login(Request $request)
    {
        // Validasi input, kita namai fieldnya "login" agar bisa terima username atau email
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required'
        ]);

        // Cek apakah inputan berformat email atau username
        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Masukkan ke array untuk proses Auth::attempt
        $auth_credentials = [
            $login_type => $request->input('login'),
            'password' => $request->input('password')
        ];

        // Coba melakukan login
        if (Auth::attempt($auth_credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->with('error', 'Username/Email atau Password salah!')->withInput();
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}