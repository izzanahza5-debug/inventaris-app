<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();
        
        // Contoh pemisahan logika sederhana
        if ($user->role == 'admin') {
            return redirect('/users'); 
        } elseif ($user->role == 'it') {
            return redirect('/barang');
        } else {
            return redirect('/dashboard');
        }
    }
    return back()->with('error', 'Login Gagal');
}
}
