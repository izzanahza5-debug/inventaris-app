<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Jenjang;
use App\Models\Kategori;
use App\Models\Gedung;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BarangExport;
// use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel; // Untuk Excel

class BarangController extends Controller
{
private function filterQuery(Request $request)
{
    return Barang::with(['jenjang', 'kategori', 'gedung', 'sumberDana'])
        ->when($request->search, function ($query) use ($request) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('no_inventaris', 'like', '%' . $request->search . '%');
        })
        ->when($request->gedung, function ($query) use ($request) {
            $query->where('gedung_id', $request->gedung);
        })
        ->when($request->kondisi, function ($query) use ($request) {
            $query->where('kondisi', $request->kondisi);
        });
}

public function index(Request $request)
{
    $gedungs = Gedung::all();
    // Ambil query dari fungsi private, lalu tambahkan paginate
    $barangs = $this->filterQuery($request)->latest()->paginate(10)->withQueryString();

    return view('barang.index', compact('barangs', 'gedungs'));
}

    public function create()
    {
        $jenjangs = Jenjang::all();
        $kategoris = Kategori::all();
        $gedungs = Gedung::all();
        $sumberDanas = SumberDana::all();
        return view('barang.create', compact('jenjangs', 'kategoris', 'gedungs', 'sumberDanas'));
    }

    public function store(Request $request)
    {
        // $userId = $request->user()->id;
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenjang_id' => 'required',
            // 'user_id' => $userId,
            'kategori_id' => 'required',
            'ruang' => 'required',
            'gedung_id' => 'required',
            'sumber_dana_id' => 'required',
            'tanggal_perolehan' => 'required|date',
            'harga_barang' => 'required|numeric',
            'kondisi' => 'required',
            'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth()->id();

        if ($request->hasFile('foto_barang')) {
            $data['foto_barang'] = $request->file('foto_barang')->store('barang-photos', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil didaftarkan ke sistem!');
    }

    public function edit(Barang $barang)
    {
        $jenjangs = Jenjang::all();
        $kategoris = Kategori::all();
        $gedungs = Gedung::all();
        $sumberDanas = SumberDana::all();
        return view('barang.edit', compact('barang', 'jenjangs', 'kategoris', 'gedungs', 'sumberDanas'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'ruang' => 'required',
            'tanggal_perolehan' => 'required|date',
            'harga_barang' => 'required|numeric',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_barang')) {
            if ($barang->foto_barang) {
                Storage::disk('public')->delete($barang->foto_barang);
            }
            $data['foto_barang'] = $request->file('foto_barang')->store('barang-photos', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->foto_barang) {
            Storage::disk('public')->delete($barang->foto_barang);
        }
        $barang->delete();
        return back()->with('success', 'Barang telah dihapus dari inventaris.');
    }
    public function show(Barang $barang)
{
    // Load relasi agar data pembuat muncul
    $barang->load(['jenjang', 'kategori', 'gedung', 'sumberDana', 'user']);
    return view('barang.show', compact('barang'));
}

public function exportPdf(Request $request)
    {
        $barangs = $this->filterQuery($request)->get();
        
        // Load view yang sudah kita buat tadi
        $pdf = Pdf::loadView('barang.pdf', compact('barangs'))
                  ->setPaper('a4', 'landscape'); // Landscape agar tabel lega

        return $pdf->download('Laporan_Inventaris_'.now()->format('d-m-Y').'.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new BarangExport($request), 'Laporan_Inventaris_'.now()->format('d-m-Y').'.xlsx');
    }

}