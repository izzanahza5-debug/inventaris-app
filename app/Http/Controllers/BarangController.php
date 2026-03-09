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
use App\Models\Ruangan;
// use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel; // Untuk Excel
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangController extends Controller
{
private function filterQuery(Request $request)
{
    return Barang::with(['jenjang', 'kategori', 'gedung', 'sumberDana', 'ruang'])
        ->when($request->search, function ($query) use ($request) {
            // Dibungkus function agar "OR" tidak merusak filter gedung/kondisi
            $query->where(function($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('no_inventaris', 'like', '%' . $request->search . '%');
            });
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
    $gedungs = Gedung::get();
    // Ambil query dari fungsi private, lalu tambahkan paginate
    $barangs = $this->filterQuery($request)
    ->dataByRole()
    ->latest()
    ->paginate(10)
    ->withQueryString();

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
            'ruang_id' => 'required|exists:ruangans,id',
            'gedung_id' => 'required',
            'sumber_dana_id' => 'required',
            'tanggal_perolehan' => 'required|date',
            'harga_barang' => 'required|numeric',
            'kondisi' => 'required',
            'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);
        // dd($request->all());

        $data = $request->all();
        $data['user_id'] = Auth()->id();

        if ($request->hasFile('foto_barang')) {
            $data['foto_barang'] = $request->file('foto_barang')->store('barang-photos', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil didaftarkan ke sistem!');
    }

    public function edit($slug)
    {   
        
        $barang = Barang::where('nama_barang', $slug)->dataByRole()->firstOrFail();
        $jenjangs = Jenjang::all();
        $kategoris = Kategori::all();
        $gedungs = Gedung::all();
        $sumberDanas = SumberDana::all();
        $ruangan = Ruangan::all();
        return view('barang.edit', compact('barang','ruangan', 'jenjangs', 'kategoris', 'gedungs', 'sumberDanas'));
    }

    public function update(Request $request, $slug)
    {   
        $barang = Barang::where('nama_barang', $slug)->firstOrFail();
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'ruang_id' => 'required|exists:ruangans,id',
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

    public function destroy( $id)
    {   
        $barang = Barang::where('id', $id)->firstOrFail();
        // dd($barang);
        if ($barang->foto_barang) {
            Storage::disk('public')->delete($barang->foto_barang);
        }
        $barang->delete();
        return back()->with('success', 'Barang telah dihapus dari inventaris.');
    }
    public function show($slug)
{   
        $barang = Barang::where('nama_barang', $slug)->firstOrFail();
    // Load relasi agar data pembuat muncul
    $barang->load(['jenjang', 'kategori', 'gedung', 'sumberDana', 'user', 'ruang']);
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

public function cetakLabel(Request $request)
{
    // Cukup panggil filterQuery, tambahkan dataByRole, lalu ambil hasilnya
    $barangs = $this->filterQuery($request)->dataByRole()->get();

     $pdf = pdf::loadView('barang.label_pdf', compact('barangs'))
              ->setPaper('a4', 'portrait');
    return $pdf->download('Label_barang_'. now()->format('d-m-Y'). '.pdf');
}

public function getRuangan($gedung_id)
{
    // Sesuaikan 'Ruang' dengan nama Model Ruangan kamu
    $ruangan = Ruangan::where('gedung_id', $gedung_id)->get();
    return response()->json($ruangan);
}

public function cetakLabelSatuan($id)
{
    // Cari barang berdasarkan ID
    $barang = Barang::with(['kategori', 'jenjang', 'gedung', 'sumberDana'])->findOrFail($id);

    // Kita masukkan ke array agar view 'label_pdf' yang lama tetap bisa digunakan
    $barangs = [$barang];

    $pdf = Pdf::loadView('barang.label_pdf', compact('barangs'))
              ->setPaper([0, 0, 283.46, 141.73], 'portrait'); // Contoh ukuran custom (10x5 cm) atau pakai 'a4'

    return $pdf->download('Label-' . now()->format('d-m-Y'). '.pdf');
}

    public function showPublic($slug)
{
    // Cari barang berdasarkan slug (nama_barang)
    $barang = Barang::where('nama_barang', $slug)->firstOrFail();
    
    // Load relasi
    $barang->load(['jenjang', 'kategori', 'gedung', 'ruang', 'sumberDana', 'user']);
    
    // Gunakan view yang sama, atau buat view khusus 'barang.show_public'
    return view('barang.detail', compact('barang'));
}

}