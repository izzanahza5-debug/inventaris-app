@extends('layouts.app')

@section('content')
<style>
    :root {
        --teal-primary: #20c997;
        --teal-dark: #1aa179;
        --soft-bg: #f8fafc;
    }

    .edit-container {
        max-width: 800px;
        margin: 2rem auto;
    }

    .card-edit {
        border: none;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .card-header-gradient {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
        padding: 3rem 2rem;
        text-align: center;
        color: white;
    }

    .icon-box {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .form-label-custom {
        font-weight: 700;
        font-size: 0.8rem;
        color: #64748b;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
        display: block;
    }

    .input-custom {
        border-radius: 15px !important;
        padding: 12px 20px !important;
        border: 2px solid #f1f5f9 !important;
        background-color: #f8fafc !important;
        transition: all 0.3s ease;
    }

    .input-custom:focus {
        border-color: var(--teal-primary) !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(32, 201, 151, 0.1) !important;
    }

    .btn-update {
        background: var(--teal-primary);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 15px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 8px 20px rgba(32, 201, 151, 0.3);
    }

    .btn-update:hover {
        background: var(--teal-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(32, 201, 151, 0.4);
    }

    .btn-cancel {
        color: #94a3b8;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        color: #64748b;
    }

    /* Animasi masuk */
    .fade-up {
        animation: fadeUp 0.5s ease-out forwards;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container py-4">
    <div class="edit-container fade-up">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master.ruangan.index') }}" class="btn-cancel small">Master Ruangan</a></li>
                <li class="breadcrumb-item active small" aria-current="page">Update Data</li>
            </ol>
        </nav>

        <div class="card card-edit">
            <div class="card-header-gradient">
                <div class="icon-box">
                    <i class="fa-solid fa-door-open fa-2x text-white"></i>
                </div>
                <h3 class="fw-bold mb-1">Edit Konfigurasi Ruangan</h3>
                <p class="mb-0 opacity-75 small">Sesuaikan penempatan gedung dan identitas ruangan</p>
            </div>

            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('master.ruangan.update', $ruangan->nama_ruangan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label-custom text-uppercase">Lokasi Gedung Saat Ini</label>
                            <div class="position-relative">
                                <select name="gedung_id" class="form-select input-custom" required>
                                    @foreach($gedungs as $gedung)
                                        <option value="{{ $gedung->id }}" {{ $ruangan->gedung_id == $gedung->id ? 'selected' : '' }}>
                                            🏢 {{ $gedung->nama_gedung }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-custom text-uppercase">Label / Nama Ruangan</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light rounded-start-4 ps-3">
                                    <i class="fa-solid fa-tag text-muted"></i>
                                </span>
                                <input type="text" name="nama_ruangan" value="{{ $ruangan->nama_ruangan }}" 
                                       class="form-control input-custom rounded-start-0" 
                                       placeholder="Misal: Lab Bahasa" required>
                            </div>
                            <div class="form-text text-muted ps-2 mt-2" style="font-size: 0.75rem;">
                                *Gunakan penamaan yang spesifik agar memudahkan inventarisir barang.
                            </div>
                        </div>

                        <div class="col-md-12 mt-5">
                            <div style="flex-wrap: wrap" class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('master.ruangan.index') }}" class="btn-cancel">
                                    <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-update">
                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i> Perbarui Data
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4 p-3 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-10 d-flex align-items-center">
            <i class="fa-solid fa-circle-info text-primary me-3 fs-4"></i>
            <p class="mb-0 small text-primary">
                Perubahan nama ruangan akan otomatis terupdate pada semua <strong>Aset/Barang</strong> yang terdaftar di ruangan ini.
            </p>
        </div>
    </div>
</div>
@endsection