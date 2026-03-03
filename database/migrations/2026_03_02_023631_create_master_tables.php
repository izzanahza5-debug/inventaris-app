<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTables extends Migration
{
    public function up()
    {
        // Master Jenjang
        Schema::create('jenjangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jenjang')->unique();
            $table->string('nama_jenjang');
            $table->string('slug')->unique(); // Tambahan Slug
            $table->timestamps();
        });

        // Master Kategori (Kode Barang)
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kategori')->unique();
            $table->string('nama_kategori');
            $table->string('slug')->unique(); // Tambahan Slug
            $table->timestamps();
        });

        // Master Gedung
        Schema::create('gedungs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gedung')->unique();
            $table->string('nama_gedung');
            $table->string('slug')->unique(); // Tambahan Slug
            $table->timestamps();
        });

        // Master Sumber Dana (Data Pembelian)
        Schema::create('sumber_danas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sumber')->unique();
            $table->string('nama_sumber');
            $table->string('slug')->unique(); // Tambahan Slug
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sumber_danas');
        Schema::dropIfExists('gedungs');
        Schema::dropIfExists('kategoris');
        Schema::dropIfExists('jenjangs');
    }
}