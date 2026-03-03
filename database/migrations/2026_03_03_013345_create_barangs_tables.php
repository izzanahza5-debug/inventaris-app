<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Data Master (Komponen pembentuk No. Inventaris)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('jenjang_id')->constrained('jenjangs')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade'); // Kode Barang
            $table->foreignId('gedung_id')->constrained('gedungs')->onDelete('cascade');
            $table->foreignId('sumber_dana_id')->constrained('sumber_danas')->onDelete('cascade');

            // Data Utama
            $table->string('no_inventaris')->unique(); 
            $table->string('ruang');
            $table->string('nama_barang');
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->date('tanggal_perolehan');
            $table->integer('harga_barang')->default(0);
            
            $table->text('keterangan')->nullable();
            $table->string('foto_barang')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};