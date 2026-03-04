<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gedung;
use App\Models\Kategori;
use App\Models\SumberDana;

// use App\Models\Barang; // (Buka komentar ini nanti kalau model Barang sudah dibuat)

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total data untuk ditampilkan di Dashboard
        $totalUser = User::count();
        $totalGedung = Gedung::count();
        $totalKategori = Kategori::count();
        $sumberDana = SumberDana::count();
        
        // Dummy data untuk barang (Nanti ganti dengan: Barang::count())
        $totalBarang = Barang::count();
        
        $recentBarangs = Barang::dataByRole()->latest()->take(5)->get();

        return view('dashboard', compact('totalUser','sumberDana', 'totalGedung', 'totalKategori', 'totalBarang', 'recentBarangs'));
    }
}