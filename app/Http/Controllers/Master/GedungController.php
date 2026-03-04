<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GedungController extends Controller
{
    public function index()
    {
        $gedungs = Gedung::latest()->paginate(5);
        return view('master.gedung.index', compact('gedungs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_gedung' => 'required|unique:gedungs,kode_gedung|max:3',
            'nama_gedung' => 'required|string|max:255',
        ]);

        Gedung::create([
            'kode_gedung' => strtoupper($request->kode_gedung),
            'nama_gedung' => $request->nama_gedung,
            'slug'        => Str::slug($request->nama_gedung),
        ]);

        return back()->with('success', 'Data Gedung berhasil ditambahkan!');
    }

    public function edit($slug)
    {   
        $gedung = Gedung::where('slug', $slug)->firstOrFail();
        return view('master.gedung.edit', compact('gedung'));
    }

    public function update(Request $request, $slug)
    {   
        $gedung = Gedung::where('slug', $slug)->firstOrFail();

        $request->validate([
            'kode_gedung' => 'required|unique:gedungs,kode_gedung,' . $gedung->id,
            'nama_gedung' => 'required|string|max:255',
        ]);

        $gedung->update([
            'kode_gedung' => strtoupper($request->kode_gedung),
            'nama_gedung' => $request->nama_gedung,
            'slug'        => Str::slug($request->nama_gedung),
        ]);

        return redirect()->route('master.gedung.index')->with('success', 'Data Gedung berhasil diperbarui!');
    }

    public function destroy(Gedung $gedung)
    {
        if($gedung->ruangans->count() > 0){
            return back()->with('error', 'Gedung tidak bisa dihapus karena sudah memiliki ruangan di dalamnya!');
        }
        $gedung->delete();
        return back()->with('success', 'Gedung berhasil dihapus!');
    }
}