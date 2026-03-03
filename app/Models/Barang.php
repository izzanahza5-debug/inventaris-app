<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barang extends Model
{
    protected $guarded = [];

    // Cast tanggal agar otomatis menjadi objek Carbon
    protected $casts = [
        'tanggal_perolehan' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function jenjang() { return $this->belongsTo(Jenjang::class); }
    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function gedung() { return $this->belongsTo(Gedung::class); }
    public function SumberDana() { return $this->belongsTo(SumberDana::class); }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($barang) {
            // 1. Ambil Tahun dari Tanggal Perolehan
            $tahun = Carbon::parse($barang->tanggal_perolehan)->format('Y');

            // 2. Ambil Kode dari Relasi (Eager Loading disarankan di Controller)
            $kodeJenjang = $barang->jenjang->kode_jenjang;
            $kodeKategori = $barang->kategori->kode_kategori;
            $gedung = $barang->gedung->kode_gedung;

            // 3. Cari nomor urut terakhir di tahun tersebut
            // Kita hitung berdasarkan total barang yang sudah ada di tahun tersebut
            $lastCount = self::whereYear('tanggal_perolehan', $tahun)
                             ->where('kategori_id', $barang->kategori_id)
                             ->count();

            $nextNumber = $lastCount + 1;
            $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // 4. Gabungkan jadi No Inventaris: JENJANG/KATEGORI/URUTAN/TAHUN
            // Contoh: SD/LAPTOP/001/2024
            $barang->no_inventaris = "{$gedung}/{$kodeJenjang}/{$kodeKategori}/{$formattedNumber}/{$tahun}";
            // OTOMATIS: Mengisi siapa user yang sedang login saat input data
            $barang->user_id = auth()->id();
        });
    }
}