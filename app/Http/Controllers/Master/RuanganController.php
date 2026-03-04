<?php
namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Models\Gedung;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::with('gedung')->latest()->paginate(10);
        $gedungs = Gedung::all();
        return view('master.ruangan.index', compact('ruangans', 'gedungs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gedung_id' => 'required|exists:gedungs,id',
            'nama_ruangan' => 'required|string|max:255',
        ]);

        Ruangan::create($request->all());

        return redirect()->route('master.ruangan.index')
                         ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    // Fungsi ini untuk halaman edit terpisah sesuai permintaanmu
    public function edit($slug)
    {   
        $ruangan = Ruangan::where('nama_ruangan', $slug)->firstOrFail();
        $gedungs = Gedung::all();
        return view('master.ruangan.edit', compact('ruangan', 'gedungs'));
    }

    public function update(Request $request, $slug)
    {
        $ruangan = Ruangan::where('nama_ruangan', $slug)->firstOrFail();
        $request->validate([
            'gedung_id' => 'required|exists:gedungs,id',
            'nama_ruangan' => 'required|string|max:255',
        ]);

        $ruangan->update($request->all());

        return redirect()->route('master.ruangan.index')
                         ->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy(Ruangan $ruangan)
    {
        // Cek jika ruangan dipakai di tabel barang nantinya
        // if ($ruangan->barangs()->count() > 0) { ... }

        $ruangan->delete();
        return redirect()->route('master.ruangan.index')
                         ->with('success', 'Ruangan berhasil dihapus!');
    }

    // app/Http/Controllers/Master/RuanganController.php

public function getRuanganByGedung($gedungId)
{
    $ruangan = Ruangan::where('gedung_id', $gedungId)->get();
    return response()->json($ruangan);
}
}