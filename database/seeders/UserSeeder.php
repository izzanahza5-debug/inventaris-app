<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
public function run(): void
{
    // Akun Utama untuk Testing
    \App\Models\User::create([
        'name' => 'Admin Utama',
        'username' => 'admin',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    // 14 User Random lainnya
    $roles = ['admin', 'it', 'umum'];
    for ($i = 1; $i <= 14; $i++) {
        $name = fake()->name();
        \App\Models\User::create([
            'name' => $name,
            'username' => 'user' . $i,
            'password' => bcrypt('password'),
            'role' => $roles[array_rand($roles)],
        ]);
    }
}
}
