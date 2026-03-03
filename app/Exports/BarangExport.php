<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BarangExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        // Menyimpan data request ke dalam property class
        $this->request = $request;
    }

    public function query()
    {
        // Gunakan $this->request untuk mengambil nilai filter
        $req = $this->request;

        return Barang::query()->with(['jenjang', 'kategori', 'gedung', 'sumberDana'])
            ->when($req->search, function ($query) use ($req) {
                $query->where('nama_barang', 'like', '%' . $req->search . '%')
                      ->orWhere('no_inventaris', 'like', '%' . $req->search . '%');
            })
            ->when($req->gedung, function ($query) use ($req) {
                $query->where('gedung_id', $req->gedung);
            })
            ->when($req->kondisi, function ($query) use ($req) {
                $query->where('kondisi', $req->kondisi);
            });
    }

    // Menentukan judul kolom di baris pertama Excel
    public function headings(): array
    {
        return [
            'No. Inventaris',
            'Nama Barang',
            'Kategori',
            'Lokasi/Gedung',
            'Tanggal Perolehan',
            'Kondisi',
            'Sumber Dana',
        ];
    }

    // Menentukan data apa saja yang masuk ke kolom (urutan harus sama dengan headings)
    public function map($barang): array
    {
        return [
            $barang->no_inventaris,
            $barang->nama_barang,
            $barang->kategori->nama_kategori ?? '-',
            $barang->gedung->nama_gedung ?? '-',
            $barang->tanggal_perolehan ? $barang->tanggal_perolehan->format('d/m/Y') : '-',
            $barang->kondisi,
            $barang->sumberDana->nama_sumber ?? '-',
        ];
    }
}