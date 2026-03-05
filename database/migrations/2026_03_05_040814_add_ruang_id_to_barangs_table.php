<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRuangIdToBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::table('barangs', function (Blueprint $table) {
        // Hapus kolom string 'ruang' yang lama
        $table->dropColumn('ruang');
        
        // Tambah kolom foreignId baru
        // pastikan nama tabelnya 'ruangs' atau 'ruangans' sesuai database kamu
        $table->foreignId('ruang_id')->after('gedung_id')->constrained('ruangans')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('barangs', function (Blueprint $table) {
        $table->dropForeign(['ruang_id']);
        $table->dropColumn('ruang_id');
        $table->string('ruang')->after('no_inventaris');
    });
}
}
