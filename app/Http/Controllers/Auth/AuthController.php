<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah input 'login' adalah email atau username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Siapkan credentials untuk Auth::attempt
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        // Attempt login dengan fitur "Remember Me"
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role (sesuaikan route name dengan routing Anda)
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } 
            if (Auth::user()->role === 'petugas') {
                return redirect()->intended(route('petugas.dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        // Jika gagal, kembali ke halaman login dengan error
        return back()->withErrors([
            'login' => 'Username/Email atau password salah.',
        ])->onlyInput('login');
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