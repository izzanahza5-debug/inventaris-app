<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_details', function (Blueprint $table) {
            $table->id();
            // onDelete('cascade') artinya jika pengajuan dihapus, detail barangnya ikut terhapus otomatis
            $table->foreignId('pengajuan_id')->constrained('pengajuans')->onDelete('cascade'); 
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->bigInteger('harga_satuan');
            $table->bigInteger('subtotal');
            $table->text('keterangan')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_details');
    }
};