<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisTables extends Migration
{
    public function up()
    {
        // 1. Master Jenjang
        Schema::create('jenjangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenjang'); // TK, SD, SMP
            $table->timestamps();
        });

        // 2. Master Kode Barang (Kategori)
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kategori')->unique(); // Input manual
            $table->string('nama_kategori');
            $table->timestamps();
        });

        // 3. Master Gedung
        Schema::create('gedungs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gedung');
            $table->timestamps();
        });

        // 4. Master Sumber Dana (Data Pembelian)
        Schema::create('sumber_danas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sumber'); // BOS, Yayasan, dll
            $table->timestamps();
        });

        // 5. Tabel Barang (Utama)
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique(); // Input manual
            $table->string('nama_barang');
            $table->foreignId('jenjang_id')->constrained('jenjangs');
            $table->foreignId('kategori_id')->constrained('kategoris');
            $table->foreignId('gedung_id')->constrained('gedungs');
            $table->foreignId('sumber_dana_id')->constrained('sumber_danas');
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangs');
        Schema::dropIfExists('sumber_danas');
        Schema::dropIfExists('gedungs');
        Schema::dropIfExists('kategoris');
        Schema::dropIfExists('jenjangs');
    }
}