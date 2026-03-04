<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Hapus kolom role yang lama
            $table->dropColumn('role');

            // 2. Tambah kolom role_id baru setelah password
            // constrained() otomatis mencari tabel 'roles' dan kolom 'id'
            $table->foreignId('role_id')->after('password')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Balikkan jika rollback
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->enum('role', ['admin', 'umum', 'it'])->default('umum');
        });
    }
};