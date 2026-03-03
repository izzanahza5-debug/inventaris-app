@extends('layouts.app')

@section('content')
<style>
    .detail-label { font-size: 0.75rem; color: #6c757d; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .detail-value { font-size: 1rem; color: #212529; font-weight: 600; }
    .img-detail { width: 100%; border-radius: 20px; object-fit: cover; max-height: 400px; }
    .info-card { background: #f8f9fa; border: none; border-radius: 15px; }
</style>

<div class="container-fluid">
    <div class="d-flex align-items-center mb-4" style="flex-wrap: wrap">
        <div class="">

            <a href="{{ route('barang.index') }}" class="btn btn-white shadow-sm rounded-circle me-3">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h3 class="fw-bold mb-0">Detail Inventaris</h3>
                <p class="text-muted mb-0">Nomor: <span class="text-primary fw-bold">{{ $barang->no_inventaris }}</span></p>
            </div>
        </div>
        <div class="ms-auto my-2">
            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-primary text-white px-4 rounded-pill fw-bold">
                <i class="fa-solid fa-pen-to-square me-2"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                @if($barang->foto_barang)
                    <img src="{{ asset('storage/'.$barang->foto_barang) }}" class="img-detail">
                @else
                    <div class="bg-light d-flex flex-column align-items-center justify-content-center" style="height: 350px;">
                        <i class="fa-solid fa-box-open fa-5x text-muted mb-3"></i>
                        <p class="text-muted">Foto tidak tersedia</p>
                    </div>
                @endif
                <div class="card-body bg-dark text-white p-4">
                    <div class="row text-center">
                        <div class="col-6 border-end border-secondary">
                            <small class="d-block opacity-75">Kondisi</small>
                            <span class="fw-bold">{{ $barang->kondisi }}</span>
                        </div>
                        <div class="col-6">
                            <small class="d-block opacity-75">Tahun</small>
                            <span class="fw-bold">{{ $barang->tanggal_perolehan->format('Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm rounded-4 mt-4 p-4 info-card">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="fa-solid fa-user-check text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Data diinput oleh:</small>
                        <h6 class="fw-bold mb-0">{{ $barang->user->name }}</h6>
                        <small class="text-muted small">Pada: {{ $barang->created_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Informasi Aset</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="detail-label">Nama Barang</label>
                        <div class="detail-value">{{ $barang->nama_barang }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="detail-label">Kategori / Kode</label>
                        <div class="detail-value">{{ $barang->kategori->nama_kategori }} ({{ $barang->kategori->kode_kategori }})</div>
                    </div>
                    <div class="col-md-6">
                        <label class="detail-label">Lokasi Penempatan</label>
                        <div class="detail-value"><i class="fa-solid fa-building me-1 text-muted"></i> {{ $barang->gedung->nama_gedung }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="detail-label">Ruangan</label>
                        <div class="detail-value">{{ $barang->ruang }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="detail-label">Jenjang</label>
                        <div class="detail-value">{{ $barang->jenjang->nama_jenjang }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="detail-label">Tanggal Perolehan</label>
                        <div class="detail-value">{{ $barang->tanggal_perolehan->format('d F Y') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="detail-label">Harga Perolehan</label>
                        <div class="detail-value text-success">Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="detail-label">Sumber Dana</label>
                        <div class="detail-value">{{ $barang->sumberDana->nama_sumber }}</div>
                    </div>
                    <div class="col-12">
                        <label class="detail-label">Keterangan Tambahan</label>
                        <div class="p-3 bg-light rounded-3 mt-1" style="min-height: 80px;">
                            {{ $barang->keterangan ?? 'Tidak ada catatan tambahan.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection