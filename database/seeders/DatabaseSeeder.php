<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Jenjang;
use App\Models\Kategori;
use App\Models\Gedung;
use App\Models\Ruangan;
use App\Models\SumberDana;
use App\Models\Barang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Roles
        $roles = [['nama_role' => 'Administrator', 'slug' => 'admin'], ['nama_role' => 'IT Support', 'slug' => 'it'], ['nama_role' => 'Staf Sarpras', 'slug' => 'sarpras'], ['nama_role' => 'Kepala Ruangan', 'slug' => 'umum'], ['nama_role' => 'Bendahara', 'slug' => 'bendahara']];
        foreach ($roles as $r) {
            Role::create($r);
        }

        // 2. Seed Users
        $adminRole = Role::where('slug', 'admin')->first();
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "User Petugas $i",
                'username' => "petugas$i",
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]);
        }
        // 2. Seed Users
        $adminRoles = Role::where('slug', 'it')->first();
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "IT $i",
                'username' => "IT $i",
                'password' => Hash::make('password'),
                'role_id' => $adminRoles->id,
            ]);
        }

        // 3. Seed Jenjang
        $jenjangs = ['SD', 'SMP', 'SMA', 'SMK', 'Universitas'];
        foreach ($jenjangs as $j) {
            Jenjang::create([
                'kode_jenjang' => strtoupper(Str::random(3)),
                'nama_jenjang' => $j,
                'slug' => Str::slug($j),
            ]);
        }

        // 4. Seed Kategori (Kode Barang)
        $kategoris = [['nama' => 'Elektronik', 'kode' => 'ELK'], ['nama' => 'Mebel', 'kode' => 'MBL'], ['nama' => 'Alat Olahraga', 'kode' => 'OLR'], ['nama' => 'Buku Perpustakaan', 'kode' => 'BKS'], ['nama' => 'Kendaraan', 'kode' => 'KND']];
        foreach ($kategoris as $k) {
            Kategori::create([
                'kode_kategori' => $k['kode'],
                'nama_kategori' => $k['nama'],
                'slug' => Str::slug($k['nama']),
            ]);
        }

        // 5. Seed Gedung
        $gedungs = ['Gedung A', 'Gedung B', 'Gedung C', 'Lab Terpadu', 'Sport Hall'];
        foreach ($gedungs as $g) {
            Gedung::create([
                'kode_gedung' => strtoupper(Str::random(2)),
                'nama_gedung' => $g,
                'slug' => Str::slug($g),
            ]);
        }

        // 6. Seed Ruangan (Tergantung Gedung)
        $allGedungs = Gedung::all();
        foreach ($allGedungs as $gedung) {
            for ($i = 1; $i <= 2; $i++) {
                Ruangan::create([
                    'gedung_id' => $gedung->id,
                    'nama_ruangan' => 'Ruang ' . $gedung->nama_gedung . " - 0$i",
                ]);
            }
        }

        // 7. Seed Sumber Dana
        $sumber = ['BOS Reguler', 'BOS Daerah', 'Yayasan', 'Hibah Pemerintah', 'Iuran Komite'];
        foreach ($sumber as $s) {
            SumberDana::create([
                'kode_sumber' => strtoupper(Str::random(3)),
                'nama_sumber' => $s,
                'slug' => Str::slug($s),
            ]);
        }

        // 8. Seed Barang (Mengambil ID dari semua tabel di atas)
        $faker = \Faker\Factory::create('id_ID');
        $kategoriIds = Kategori::pluck('id')->toArray();
        $jenjangIds = Jenjang::pluck('id')->toArray();
        $sumberIds = SumberDana::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        for ($i = 1; $i <= 15; $i++) {
            // Ambil gedung random, lalu ambil ruangan yang ada di gedung tersebut
            $randomGedung = Gedung::inRandomOrder()->first();
            $randomRuang = Ruangan::where('gedung_id', $randomGedung->id)->inRandomOrder()->first();

            Barang::create([
                'user_id' => $faker->randomElement($userIds),
                'jenjang_id' => $faker->randomElement($jenjangIds),
                'kategori_id' => $faker->randomElement($kategoriIds),
                'gedung_id' => $randomGedung->id,
                'ruang_id' => $randomRuang->id,
                'sumber_dana_id' => $faker->randomElement($sumberIds),
                'no_inventaris' => 'INV-' . strtoupper(Str::random(8)),
                'nama_barang' => $faker->randomElement(['Laptop ASUS', 'Kursi Guru', 'Meja Siswa', 'Proyektor BenQ', 'Printer Epson']),
                'kondisi' => $faker->randomElement(['Baik', 'Rusak Ringan', 'Rusak Berat']),
                'tanggal_perolehan' => $faker->date(),
                'harga_barang' => $faker->numberBetween(100000, 15000000),
                'keterangan' => 'Data dummy untuk testing sistem.',
                'foto_barang' => null,
            ]);
        }

        // 9. Seed Pengajuan & PengajuanDetail
        $faker = \Faker\Factory::create('id_ID');
        $jenjangIds = Jenjang::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // Kita buat 20 data pengajuan random
        for ($i = 1; $i <= 20; $i++) {
            $tanggalRandom = $faker->dateTimeBetween('-2 months', 'now');
            $status = $faker->randomElement(['Pending', 'Disetujui', 'Ditolak', 'Selesai']);

            // 1. Create Header Pengajuan
            $pengajuan = \App\Models\Pengajuan::create([
                'user_id' => $faker->randomElement($userIds),
                'jenjang_id' => $faker->randomElement($jenjangIds),
                'no_pengajuan' => 'REQ-' . $tanggalRandom->format('dmY') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'tanggal_pengajuan' => $tanggalRandom,
                'status' => $status,
                'total_biaya' => 0, // Akan diupdate setelah detail dibuat
                'catatan_admin' => $status == 'Ditolak' ? $faker->sentence() : null,
                'created_at' => $tanggalRandom,
                'updated_at' => $tanggalRandom,
            ]);

            $totalBiayaHeader = 0;
            $jumlahBarang = rand(1, 4); // Tiap pengajuan punya 1-4 jenis barang

            // 2. Create Detail Barang untuk tiap Pengajuan
            for ($j = 1; $j <= $jumlahBarang; $j++) {
                $qty = rand(1, 10);
                $harga = $faker->randomElement([50000, 100000, 250000, 500000, 1000000, 2000000]);
                $subtotal = $qty * $harga;
                $totalBiayaHeader += $subtotal;

                \App\Models\PengajuanDetail::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_barang' => $faker->randomElement(['Proyektor', 'Kabel LAN', 'Kursi Kantor', 'Papan Tulis', 'AC Split', 'Tinta Printer']),
                    'spesifikasi' => 'Spek: ' . $faker->word() . ' ' . $faker->word(),
                    'jumlah' => $qty,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal,
                    'keterangan' => 'Urgent untuk kegiatan sekolah',
                ]);
            }

            // 3. Update total_biaya di header pengajuan
            $pengajuan->update(['total_biaya' => $totalBiayaHeader]);
        }
    }
}
