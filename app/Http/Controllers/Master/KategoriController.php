<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('master.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategoris,kode_kategori|max:5',
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create([
            'kode_kategori' => strtoupper($request->kode_kategori),
            'nama_kategori' => $request->nama_kategori,
            'slug'          => Str::slug($request->nama_kategori),
        ]);

        return back()->with('success', 'Kategori barang berhasil ditambahkan!');
    }

    public function edit($slug)
    {   
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        return view('master.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $slug)
    {   
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        $request->validate([
            'kode_kategori' => 'required|max:5|unique:kategoris,kode_kategori,' . $kategori->id,
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->update([
            'kode_kategori' => strtoupper($request->kode_kategori),
            'nama_kategori' => $request->nama_kategori,
            'slug'          => Str::slug($request->nama_kategori),
        ]);

        return redirect()->route('master.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}