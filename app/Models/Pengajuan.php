<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];

    // Relasi ke User (Siapa yang mengajukan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function jenjang()
{
    return $this->belongsTo(Jenjang::class);
}
    // Relasi ke Detail Barang (One-to-Many)
    public function details()
    {
        return $this->hasMany(PengajuanDetail::class, 'pengajuan_id');
    }
}