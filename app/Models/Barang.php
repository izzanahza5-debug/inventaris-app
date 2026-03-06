<?php

// NEW CODE



namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barang extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tanggal_perolehan' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function jenjang() { return $this->belongsTo(Jenjang::class); }
    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function gedung() { return $this->belongsTo(Gedung::class); }
    public function sumberDana() { return $this->belongsTo(SumberDana::class, 'sumber_dana_id'); }
    public function ruang() { return $this->belongsTo(Ruangan::class, 'ruang_id'); }

    public function getRouteKeyName()
    {
        return 'nama_barang';
    }

    public function scopeDataByRole($query)
    {
        $user = auth()->user();
        if (!$user) return $query;

        // Perbaikan: Karena kolom 'role' sudah dihapus, cek lewat relasi role atau slug
        if ($user->role && $user->role->slug === 'admin') {
            return $query;
        }

        return $query->whereHas('user', function ($q) use ($user) {
            $q->where('role_id', $user->role_id);
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($barang) {
            // 1. Ambil Tahun
            $tahun = Carbon::parse($barang->tanggal_perolehan)->format('Y');

            // 2. Ambil Kode dari Relasi
            // Catatan: Pastikan relasi sudah terisi sebelum save
            $kodeJenjang = $barang->jenjang->kode_jenjang ?? 'NA';
            $kodeKategori = $barang->kategori->kode_kategori ?? 'NA';
            $gedung = $barang->gedung->kode_gedung ?? 'NA';
            $sumber = $barang->sumberDana->kode_sumber ?? 'NA';

            // 3. Nomor Urut
            $lastCount = self::whereYear('tanggal_perolehan', $tahun)
                             ->where('kategori_id', $barang->kategori_id)
                             ->count();

            $nextNumber = $lastCount + 1;
            $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // 4. Set No Inventaris
            $barang->no_inventaris = "{$gedung}/{$kodeJenjang}/{$kodeKategori}/{$sumber}/{$formattedNumber}/{$tahun}";

            // PERBAIKAN USER_ID:
            // Hanya isi otomatis jika user_id belum diisi (misal oleh Seeder)
            if (empty($barang->user_id)) {
                $barang->user_id = auth()->id();
            }
        });
    }
}

//END NEW CODE

// OLD CODE

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Carbon\Carbon;

// class Barang extends Model
// {
//     protected $guarded = [];

//     // Cast tanggal agar otomatis menjadi objek Carbon
//     protected $casts = [
//         'tanggal_perolehan' => 'date',
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }
//     public function jenjang()
//     {
//         return $this->belongsTo(Jenjang::class);
//     }
//     public function kategori()
//     {
//         return $this->belongsTo(Kategori::class);
//     }
//     public function gedung()
//     {
//         return $this->belongsTo(Gedung::class);
//     }
//     public function SumberDana()
//     {
//         return $this->belongsTo(SumberDana::class);
//     }
//     public function ruang()
// {
//     return $this->belongsTo(Ruangan::class, 'ruang_id');
// }
//     // app/Models/Barang.php

//     public function getRouteKeyName()
// {
//     return 'nama_barang'; // Laravel akan mencari data berdasarkan kolom ini, bukan ID
// }

//     public function scopeDataByRole($query)
//     {
//         $user = auth()->user();

//         // Jika admin, tampilkan semua tanpa filter
//         if ($user->role === 'admin') {
//             return $query;
//         }

//         // Jika bukan admin, cari barang yang pemiliknya punya role sama dengan user login
//         return $query->whereHas('user', function ($q) use ($user) {
//             $q->where('role_id', $user->role_id);
//         });
//     }

//     protected static function boot()
//     {
//         parent::boot();

//         static::creating(function ($barang) {
//             // 1. Ambil Tahun dari Tanggal Perolehan
//             $tahun = Carbon::parse($barang->tanggal_perolehan)->format('Y');

//             // 2. Ambil Kode dari Relasi (Eager Loading disarankan di Controller)
//             $kodeJenjang = $barang->jenjang->kode_jenjang;
//             $kodeKategori = $barang->kategori->kode_kategori;
//             $gedung = $barang->gedung->kode_gedung;
//             $sumber = $barang->sumberDana->kode_sumber;

//             // 3. Cari nomor urut terakhir di tahun tersebut
//             // Kita hitung berdasarkan total barang yang sudah ada di tahun tersebut
//             $lastCount = self::whereYear('tanggal_perolehan', $tahun)->where('kategori_id', $barang->kategori_id)->count();

//             $nextNumber = $lastCount + 1;
//             $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

//             // 4. Gabungkan jadi No Inventaris: JENJANG/KATEGORI/URUTAN/TAHUN
//             // Contoh: SD/LAPTOP/001/2024
//             $barang->no_inventaris = "{$gedung}/{$kodeJenjang}/{$kodeKategori}/{$sumber}/{$formattedNumber}/{$tahun}";
//             // OTOMATIS: Mengisi siapa user yang sedang login saat input data
//             $barang->user_id = auth()->id();
//         });
//     }
// }

//END OLD CODE
