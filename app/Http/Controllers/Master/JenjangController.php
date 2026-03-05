<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JenjangController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        $jenjangs = Jenjang::latest()->paginate(5);
        return view('master.jenjang.index', compact('jenjangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jenjang' => 'required|unique:jenjangs,kode_jenjang|max:3',
            'nama_jenjang' => 'required',
        ]);

        Jenjang::create([
            'kode_jenjang' => strtoupper($request->kode_jenjang),
            'nama_jenjang' => $request->nama_jenjang,
            'slug' => Str::slug($request->nama_jenjang),
        ]);

        return back()->with('success', 'Jenjang baru berhasil ditambahkan!');
    }

    public function edit($slug)
    {
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        $jenjang = Jenjang::where('slug', $slug)->firstOrFail();
        return view('master.jenjang.edit', compact('jenjang'));
    }

    public function update(Request $request, $slug)
    {
        $jenjang = Jenjang::where('slug', $slug)->firstOrFail();
        $request->validate([
            'kode_jenjang' => 'required|unique:jenjangs,kode_jenjang,' . $jenjang->id,
            'nama_jenjang' => 'required',
        ]);

        $jenjang->update([
            'kode_jenjang' => strtoupper($request->kode_jenjang),
            'nama_jenjang' => $request->nama_jenjang,
            'slug' => Str::slug($request->nama_jenjang),
        ]);

        return redirect()->route('master.jenjang.index')->with('success', 'Data jenjang berhasil diperbarui!');
    }

    public function destroy(Jenjang $jenjang)
    {
        $jenjang->delete();
        return back()->with('success', 'Jenjang berhasil dihapus!');
    }
}
