<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jenjang;
use App\Models\Kategori;
use App\Models\Gedung;
use App\Models\SumberDana;
use App\Models\Barang;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Data User (3 Role Berbeda)
        // Kita simpan ke variabel $admin untuk mengambil ID-nya nanti
        $admin = User::create([
            'name' => 'Administrator Utama',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staf IT',
            'username' => 'staf_it',
            'password' => Hash::make('it123'),
            'role' => 'it',
        ]);

        User::create([
            'name' => 'Petugas Umum',
            'username' => 'petugas_umum',
            'password' => Hash::make('umum123'),
            'role' => 'umum',
        ]);

        // 2. Seed Data Master Jenjang
        $sd = Jenjang::create(['nama_jenjang' => 'SD', 'kode_jenjang' => 'SD', 'slug' => 'SD']);
        $smp = Jenjang::create(['nama_jenjang' => 'SMP', 'kode_jenjang' => 'SMP', 'slug' => 'SMP']);
        $sma = Jenjang::create(['nama_jenjang' => 'TK', 'kode_jenjang' => 'TK', 'slug' => 'TK']);

        // 3. Seed Data Master Kategori (Kode Barang)
        $laptop = Kategori::create(['nama_kategori' => 'Laptop / Komputer', 'kode_kategori' => 'LPT', 'slug' => 'LPT']);
        $meja = Kategori::create(['nama_kategori' => 'Meja Siswa', 'kode_kategori' => 'MEJ', 'slug' => 'MEJ']);
        $proyektor = Kategori::create(['nama_kategori' => 'Proyektor', 'kode_kategori' => 'PRJ', 'slug' => 'PRJ']);

        // 4. Seed Data Master Gedung
        $gedungA = Gedung::create(['nama_gedung' => 'Gedung A', 'kode_gedung' => 'G1','slug' => 'G1']);
        $gedungB = Gedung::create(['nama_gedung' => 'Gedung B', 'kode_gedung' => 'G2','slug' => 'G2']);

        // 5. Seed Data Master Sumber Dana
        $bos = SumberDana::create(['nama_sumber' => 'BOS Reguler','slug' => 'BOS', 'kode_sumber' => 'BOS']);
        $yayasan = SumberDana::create(['nama_sumber' => 'Dana Yayasan','slug' => 'Y', 'kode_sumber' => 'Y']);

        // Ambil ID admin yang baru dibuat
$adminId = User::where('username', 'admin')->first()->id;

        // 6. Seed Data Barang (Ditambahkan user_id agar tidak error saat seeding)
        Barang::create([
            'nama_barang' => 'MacBook Air M2',
            'user_id' => $adminId, // Tambahkan ini
            'jenjang_id' => $sd->id,
            'kategori_id' => $laptop->id,
            'ruang' => 'Ruang IT',
            'gedung_id' => $gedungA->id,
            'sumber_dana_id' => $bos->id,
            'tanggal_perolehan' => '2026-01-15',
            'harga_barang' => 18500000,
            'kondisi' => 'Baik',
            'keterangan' => 'Inventaris Lab Komputer'
        ]);

        Barang::create([
            'nama_barang' => 'Meja Kayu Jati',
            'user_id' => $adminId, // Tambahkan ini
            'jenjang_id' => $smp->id,
            'kategori_id' => $meja->id,
            'ruang' => 'Ruang TU',
            'gedung_id' => $gedungB->id,
            'sumber_dana_id' => $yayasan->id,
            'tanggal_perolehan' => '2026-02-10',
            'harga_barang' => 750000,
            'kondisi' => 'Baik',
            'keterangan' => 'Meja kelas 8A'
        ]);

        Barang::create([
            'nama_barang' => 'Epson EB-X400',
            'user_id' => $adminId, // Tambahkan ini
            'jenjang_id' => $sma->id,
            'kategori_id' => $proyektor->id,
            'ruang' => 'Ruang Lab',
            'gedung_id' => $gedungA->id,
            'sumber_dana_id' => $bos->id,
            'tanggal_perolehan' => '2026-02-28',
            'harga_barang' => 5200000,
            'kondisi' => 'Rusak Ringan',
            'keterangan' => 'Lampu mulai redup'
        ]);
    }
}