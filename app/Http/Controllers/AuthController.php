<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {   
        
        return view('auth.login');
    }

public function login(Request $request)
{
    // 1. Validasi Input
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required'],
    ]);

    $remember = $request->has('remember');

    // 2. Percobaan Autentikasi
    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();

        // Ambil data user yang baru login
        $user = Auth::user();

        // 3. Logika Pengalihan Berdasarkan Role (Opsional jika ingin dashboard berbeda)
            return redirect()->intended('dashboard')->with('success', "Selamat datang kembali, {$user->name}!");
        // Jika semua role masuk ke dashboard yang sama, cukup redirect()->intended()
        
    }

    // 4. Gagal Login
    return back()->withErrors([
        'username' => 'Data yang Anda masukkan tidak cocok dengan data kami.',
    ])->onlyInput('username');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}