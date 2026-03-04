<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id();
            // onDelete('restrict') adalah proteksi lapis pertama di level database
            $table->foreignId('gedung_id')->constrained('gedungs')->onDelete('restrict');
            $table->string('nama_ruangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};