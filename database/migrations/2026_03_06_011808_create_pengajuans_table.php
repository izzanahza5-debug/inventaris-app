<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pembuat pengajuan
            $table->string('no_pengajuan')->unique();
            $table->date('tanggal_pengajuan');
            $table->bigInteger('total_biaya')->default(0);
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak', 'Selesai'])->default('Pending');
            $table->text('catatan_admin')->nullable(); // ALASAN PENOLAKAN DISINI
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};