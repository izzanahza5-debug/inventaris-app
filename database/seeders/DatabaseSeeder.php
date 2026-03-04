<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jenjang;
use App\Models\Kategori;
use App\Models\Gedung;
use App\Models\SumberDana;
use App\Models\Barang;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
 public function run(): void
    {
        // 1. Buat Role Standar Terlebih Dahulu
        $roleAdmin = Role::create(['nama_role' => 'Administrator', 'slug' => 'admin']);
        $roleIt    = Role::create(['nama_role' => 'IT Support', 'slug' => 'it']);
        $roleUmum  = Role::create(['nama_role' => 'Umum', 'slug' => 'umum']);

        // 2. Buat Akun Admin Utama (Untuk kamu login pertama kali)
        User::create([
            'name'     => 'Admin Utama',
            'username' => 'admin',
            'password' => Hash::make('admin123'), // Password: admin123
            'role_id'  => $roleAdmin->id,
        ]);

        // 3. Buat 9 Akun Sampel Tambahan (Total 10 dengan Admin)
        $dataUser = [
            ['name' => 'Budi IT', 'user' => 'budi_it', 'role' => $roleIt],
            ['name' => 'Andi IT', 'user' => 'andi_it', 'role' => $roleIt],
            ['name' => 'Siska Umum', 'user' => 'siska_umum', 'role' => $roleUmum],
            ['name' => 'Rudi Umum', 'user' => 'rudi_umum', 'role' => $roleUmum],
            ['name' => 'Dewi IT', 'user' => 'dewi_it', 'role' => $roleIt],
            ['name' => 'Maya Umum', 'user' => 'maya_umum', 'role' => $roleUmum],
            ['name' => 'Fajar IT', 'user' => 'fajar_it', 'role' => $roleIt],
            ['name' => 'Rina Umum', 'user' => 'rina_umum', 'role' => $roleUmum],
            ['name' => 'Hendra Umum', 'user' => 'hendra_umum', 'role' => $roleUmum],
        ];

        foreach ($dataUser as $data) {
            User::create([
                'name'     => $data['name'],
                'username' => $data['user'],
                'password' => Hash::make('password'), // Password default: password
                'role_id'  => $data['role']->id,
            ]);
        }
    }
}