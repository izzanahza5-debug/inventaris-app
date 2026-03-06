<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDetail extends Model
{
    protected $guarded = [];

    // Relasi balik ke Pengajuan Induk
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
    }
}