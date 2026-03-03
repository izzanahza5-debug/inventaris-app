<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SumberDanaController extends Controller
{
    public function index()
    {
        $sumberDanas = SumberDana::latest()->get();
        return view('master.sumber-dana.index', compact('sumberDanas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_sumber' => 'required|unique:sumber_danas,kode_sumber',
            'nama_sumber' => 'required|string|max:255',
        ]);

        SumberDana::create([
            'kode_sumber' => strtoupper($request->kode_sumber),
            'nama_sumber' => $request->nama_sumber,
            'slug'        => Str::slug($request->nama_sumber),
        ]);

        return back()->with('success', 'Sumber dana berhasil ditambahkan!');
    }

    public function edit($slug)
    {   
        $sumberDana = SumberDana::where('slug', operator: $slug)->firstOrFail();
        return view('master.sumber-dana.edit', compact('sumberDana'));
    }

    public function update(Request $request, $slug)
    {
        $sumberDana = SumberDana::where('slug', operator: $slug)->firstOrFail();
        $request->validate([
            'kode_sumber' => 'required|unique:sumber_danas,kode_sumber,' . $sumberDana->id,
            'nama_sumber' => 'required|string|max:255',
        ]);

        $sumberDana->update([
            'kode_sumber' => strtoupper($request->kode_sumber),
            'nama_sumber' => $request->nama_sumber,
            'slug'        => Str::slug($request->nama_sumber),
        ]);

        return redirect()->route('master.sumber-dana.index')->with('success', 'Sumber dana berhasil diperbarui!');
    }

    public function destroy(SumberDana $sumberDana)
    {
        $sumberDana->delete();
        return back()->with('success', 'Sumber dana berhasil dihapus!');
    }
}