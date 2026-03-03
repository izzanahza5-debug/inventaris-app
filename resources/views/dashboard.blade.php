@extends('layouts.app')

@section('content')
<style>
    /* Styling Dasar & Efek Transisi */
    .dashboard-card {
        border: none;
        border-radius: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
    }
    
    /* Gradasi Warna untuk Kartu Statistik (Sesuai tema menu sebelumnya) */
    .bg-gradient-blue { background: linear-gradient(135deg, #0d6efd, #0dcaf0); }   /* Untuk Barang */
    .bg-gradient-purple { background: linear-gradient(135deg, #6610f2, #8540f5); } /* Untuk Kategori */
    .bg-gradient-teal { background: linear-gradient(135deg, #0fb9b1, #20bf6b); }   /* Untuk Gedung */
    .bg-gradient-dark { background: linear-gradient(135deg, #2c3e50, #34495e); }   /* Untuk User */

    /* Ikon Latar Belakang Transparan di dalam Kartu */
    .card-icon-bg {
        position: absolute;
        right: -10px;
        bottom: -15px;
        font-size: 6rem;
        opacity: 0.15;
        transform: rotate(-15deg);
        transition: all 0.3s;
    }
    .dashboard-card:hover .card-icon-bg {
        transform: rotate(0deg) scale(1.1);
        opacity: 0.25;
    }

    /* Styling Tabel Quick Action */
    .table-recent th {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6c757d;
        border-bottom: 2px solid #f8f9fa;
    }
    .btn-quick-action {
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-quick-action:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
</style>

<div class="container-fluid py-2">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8 mb-3 mb-md-0">
            <h2 class="fw-bold text-dark mb-1">
                👋 Halo, {{ Auth::user()->name }}!
            </h2>
            <p class="text-muted mb-0">Selamat datang di Panel Utama Sistem Inventaris Sekolah.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="bg-white p-3 rounded-4 shadow-sm d-inline-block border border-light">
                <i class="fa-regular fa-calendar-check text-primary me-2"></i>
                <span class="fw-bold text-dark">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card dashboard-card bg-gradient-blue text-white shadow-sm h-100 position-relative">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-semibold mb-3 opacity-75">Total Barang</h6>
                    <h2 class="fw-bold display-5 mb-0">{{ $totalBarang }}</h2>
                    <div class="mt-3 small">
                        <i class="fa-solid fa-arrow-trend-up me-1"></i> Data inventaris aktif
                    </div>
                </div>
                <i class="fa-solid fa-boxes-stacked card-icon-bg"></i>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card dashboard-card bg-gradient-purple text-white shadow-sm h-100 position-relative">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-semibold mb-3 opacity-75">Kategori Barang</h6>
                    <h2 class="fw-bold display-5 mb-0">{{ $totalKategori }}</h2>
                    <div class="mt-3 small">
                        <i class="fa-solid fa-tags me-1"></i> Klasifikasi terdaftar
                    </div>
                </div>
                <i class="fa-solid fa-tags card-icon-bg"></i>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card dashboard-card bg-gradient-teal text-white shadow-sm h-100 position-relative">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-semibold mb-3 opacity-75">Lokasi / Gedung</h6>
                    <h2 class="fw-bold display-5 mb-0">{{ $totalGedung }}</h2>
                    <div class="mt-3 small">
                        <i class="fa-solid fa-building-circle-check me-1"></i> Ruangan tersedia
                    </div>
                </div>
                <i class="fa-solid fa-building card-icon-bg"></i>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card dashboard-card bg-gradient-dark text-white shadow-sm h-100 position-relative">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-semibold mb-3 opacity-75">Pengguna Sistem</h6>
                    <h2 class="fw-bold display-5 mb-0">{{ $totalUser }}</h2>
                    <div class="mt-3 small">
                        <i class="fa-solid fa-users-gear me-1"></i> Akun terotorisasi
                    </div>
                </div>
                <i class="fa-solid fa-users card-icon-bg"></i>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card dashboard-card bg-white shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Barang Ditambahkan Terakhir</h5>
                    <a href="#" class="btn btn-sm btn-light rounded-pill px-3 text-primary fw-bold">Lihat Semua</a>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-recent align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Kode Inventaris</th>
                                    <th>Nama Barang</th>
                                    <th>Tgl Masuk</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="bg-light d-inline-block p-3 rounded-circle mb-3">
                                            <i class="fa-solid fa-box-open fa-2x"></i>
                                        </div>
                                        <p class="mb-0">Belum ada data barang yang diinput.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card dashboard-card bg-white shadow-sm border-0 mb-4">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 d-inline-block p-4 rounded-circle mb-3">
                        <i class="fa-solid fa-user-shield fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                    <span class="badge bg-dark text-uppercase px-3 py-2 rounded-pill shadow-sm">
                        Akses: {{ Auth::user()->role }}
                    </span>
                </div>
            </div>

            <div class="card dashboard-card bg-white shadow-sm border-0">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0 text-dark text-uppercase"><i class="fa-solid fa-bolt text-warning me-2"></i> Akses Cepat</h6>
                </div>
                <div class="card-body p-3">
                    <a href="#" class="btn btn-quick-action w-100 text-start text-dark text-decoration-none d-flex align-items-center mb-2">
                        <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                            <i class="fa-solid fa-plus fa-fw"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Input Barang Baru</div>
                            <small class="text-muted">Generate nomor inventaris</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('master.kategori.index') }}" class="btn btn-quick-action w-100 text-start text-dark text-decoration-none d-flex align-items-center mb-2">
                        <div class="bg-purple bg-opacity-10 text-purple rounded p-2 me-3" style="color: #6610f2;">
                            <i class="fa-solid fa-tags fa-fw"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Kelola Kategori</div>
                            <small class="text-muted">Tambah kode klasifikasi</small>
                        </div>
                    </a>

                    <a href="#" class="btn btn-quick-action w-100 text-start text-dark text-decoration-none d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                            <i class="fa-solid fa-file-pdf fa-fw"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Cetak Laporan</div>
                            <small class="text-muted">Unduh rekap data PDF/Excel</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection