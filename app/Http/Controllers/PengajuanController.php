<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PengajuanController extends Controller
{
    
public function index(Request $request)
{
    $user = Auth::user();

    // 1. Inisialisasi query dasar beserta relasinya
    $query = Pengajuan::with(['user', 'jenjang'])->latest();

    // 2. Logika Hak Akses (Admin vs User Biasa)
    if (!$user->role || $user->role->slug !== 'admin') {
        $query->whereHas('user', function ($q) use ($user) {
            $q->where('role_id', $user->role_id);
        });
    }

    // 3. Fitur Pencarian berdasarkan Nomor Pengajuan
    if ($request->filled('search')) {
        $query->where('no_pengajuan', 'like', '%' . $request->search . '%');
    }

    // 4. Fitur Filter berdasarkan Jenjang
    if ($request->filled('jenjang_id')) {
        $query->where('jenjang_id', $request->jenjang_id);
    }

    // 5. Eksekusi query
    $pengajuans = $query->get();

    // 6. Ambil data master jenjang untuk ditampilkan di dropdown filter
    $jenjangs = Jenjang::all();

    return view('pengajuan.index', compact('pengajuans', 'jenjangs'));
}

    public function create()
    {
        $jenjangs = Jenjang::all();
        return view('pengajuan.create', compact('jenjangs'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_barang.*' => 'required',
                'jumlah.*' => 'required|numeric|min:1',
                'harga_satuan.*' => 'required|numeric|min:0',
                'jenjang_id' => 'required|exists:jenjangs,id',
            ],
            [
                'jenjang_id.required' => 'Jenjang wajib diisi!',
            ],
        );

        try {
            DB::beginTransaction();

            // 1. Generate Nomor Pengajuan Otomatis (Contoh: REQ-20240306-0001)
            $today = Carbon::now()->format('Ymd');
            $count = Pengajuan::whereDate('created_at', Carbon::today())->count();
            $no_pengajuan = 'REQ-' . $today . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);

            // 2. Simpan Header Pengajuan
            $pengajuan = Pengajuan::create([
                'user_id' => Auth::id(),
                'no_pengajuan' => $no_pengajuan,
                'tanggal_pengajuan' => Carbon::now(),
                'status' => 'Pending',
                'total_biaya' => 0, // Akan diupdate setelah detail masuk
                'jenjang_id' => $request->jenjang_id,
            ]);

            $totalSemua = 0;

            // 3. Simpan Detail Barang (Looping)
            foreach ($request->nama_barang as $key => $nama) {
                $subtotal = $request->jumlah[$key] * $request->harga_satuan[$key];
                $totalSemua += $subtotal;

                PengajuanDetail::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_barang' => $nama,
                    'jumlah' => $request->jumlah[$key],
                    'harga_satuan' => $request->harga_satuan[$key],
                    'subtotal' => $subtotal,
                    'keterangan' => $request->keterangan[$key],
                    'spesifikasi' => $request->spesifikasi[$key],
                ]);
            }

            // 4. Update Total Biaya di Header
            $pengajuan->update(['total_biaya' => $totalSemua]);

            DB::commit();
            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dikirim!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Pengajuan $pengajuan)
    {
        $pengajuan->load(['user', 'details', 'jenjang']);
        return view('pengajuan.show', compact('pengajuan'));
    }

    // Fungsi khusus Admin untuk update status
    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:Pending,Disetujui,Ditolak,Selesai',
            'catatan_admin' => 'required_if:status,Ditolak',
        ]);

        $pengajuan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        // Pastikan hanya pemilik atau admin yang bisa hapus
        // Dan hanya bisa hapus jika status masih Pending
        if ($pengajuan->status !== 'Pending' && Auth::user()->role->slug !== 'admin') {
            return back()->with('error', 'Hanya pengajuan berstatus Pending yang dapat dihapus.');
        }

        $pengajuan->delete(); // Karena cascade, detail otomatis terhapus
        return redirect()->route('pengajuan.index')->with('success', 'Data pengajuan dihapus.');
    }
    public function edit(Pengajuan $pengajuan)
    {   
        $jenjangs = Jenjang::all();
        // Keamanan: Hanya pemohon yang bisa edit dan hanya jika status masih Pending
        if ($pengajuan->status !== 'Pending' && auth()->user()->role->slug !== 'admin') {
            return redirect()->route('pengajuan.index')->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $pengajuan->load(['jenjang', 'details']);
        return view('pengajuan.edit', compact('pengajuan', 'jenjangs'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $request->validate(
            [
                'nama_barang.*' => 'required',
                'jumlah.*' => 'required|numeric|min:1',
                'harga_satuan.*' => 'required|numeric|min:0',
                'jenjang_id' => 'required|exists:jenjangs,id',
            ],
            [
                'jenjang_id.required' => 'Jenjang wajib diisi!',
            ],
        );

        try {
            DB::beginTransaction();

            $pengajuan->update([
            'jenjang_id' => $request->jenjang_id,
        ]);
            // 1. Update Detail (Cara paling aman: hapus yang lama, masukkan yang baru)
            $pengajuan->details()->delete();

            $totalSemua = 0;
            foreach ($request->nama_barang as $key => $nama) {
                $subtotal = $request->jumlah[$key] * $request->harga_satuan[$key];
                $totalSemua += $subtotal;

                PengajuanDetail::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_barang' => $nama,
                    'jumlah' => $request->jumlah[$key],
                    'harga_satuan' => $request->harga_satuan[$key],
                    'subtotal' => $subtotal,
                    'keterangan' => $request->keterangan[$key],
                    'spesifikasi' => $request->spesifikasi[$key],
                ]);
            }

            // 2. Update Total Biaya di Header
            $pengajuan->update([
                'total_biaya' => $totalSemua,
            ]);

            DB::commit();
            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function cetakPdf(Pengajuan $pengajuan)
    {
        $pengajuan->load(['user', 'details']);
        $pdf = Pdf::loadView('pengajuan.pdf', compact('pengajuan'));
        return $pdf->setPaper('a4', 'portrait')->stream('Pengajuan_' . $pengajuan->no_pengajuan . '.pdf');
    }
}
