<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InventarisSeeder extends Seeder
{
    public function run()
    {
        // Seeder Users
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'User Umum',
                'email' => 'umum@mail.com',
                'password' => Hash::make('password'),
                'role' => 'umum',
            ],
            [
                'name' => 'User IT',
                'email' => 'it@mail.com',
                'password' => Hash::make('password'),
                'role' => 'it',
            ],
        ]);

        // Seeder Jenjang
        DB::table('jenjangs')->insert([
            ['nama_jenjang' => 'TK'],
            ['nama_jenjang' => 'SD'],
            ['nama_jenjang' => 'SMP'],
        ]);

        // Seeder Gedung
        DB::table('gedungs')->insert([
            ['nama_gedung' => 'Gedung A'],
            ['nama_gedung' => 'Gedung B'],
            ['nama_gedung' => 'Lab Sentral'],
        ]);

        // Seeder Sumber Dana
        DB::table('sumber_danas')->insert([
            ['nama_sumber' => 'Dana BOS'],
            ['nama_sumber' => 'Iuran Yayasan'],
            ['nama_sumber' => 'Hibah/Sponsorship'],
        ]);

        // Seeder Kategori
        DB::table('kategoris')->insert([
            ['kode_kategori' => 'ELK', 'nama_kategori' => 'Elektronik'],
            ['kode_kategori' => 'MBL', 'nama_kategori' => 'Mebeul'],
            ['kode_kategori' => 'ATK', 'nama_kategori' => 'Alat Tulis Kantor'],
        ]);
    }
}
