@extends('layouts.app')

@section('content')
<style>
    .card-edit { 
        border-radius: 25px; 
        border: none; 
    }
    .input-box { 
        background-color: #f8f9fa; 
        border-radius: 15px; 
        padding: 12px 15px; 
        border: 2px solid transparent; 
        transition: 0.3s; 
    }
    .input-box:focus-within { 
        border-color: #0d6efd; 
        background-color: #fff; 
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1); 
    }
    .input-box input { 
        background: transparent; 
        border: none; 
        outline: none; 
        width: 100%; 
        font-weight: 500; 
    }
    .btn-update-blue { 
        background: linear-gradient(45deg, #0d6efd, #0dcaf0); 
        border: none; 
        border-radius: 15px; 
        padding: 12px; 
        font-weight: 600; 
        color: white; 
        transition: all 0.3s;
    }
    .btn-update-blue:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        color: white;
    }
</style>

<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('master.jenjang.index', $jenjang->slug) }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm text-muted text-decoration-none">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-edit shadow-lg p-4">
                <div class="card-body text-center">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-4">
                        <i class="fa-solid fa-graduation-cap fa-2x text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-2">Edit Jenjang</h3>
                    <p class="text-muted mb-4">Perbarui informasi tingkatan pendidikan sekolah.</p>

                    <form action="{{ route('master.jenjang.update', $jenjang->id) }}" method="POST" class="text-start">
                        @csrf 
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase ms-2">Kode Jenjang</label>
                            <div class="input-box d-flex align-items-center">
                                <i class="fa-solid fa-id-badge me-3 text-muted"></i>
                                <input type="text" name="kode_jenjang" value="{{ old('kode_jenjang', $jenjang->kode_jenjang) }}" placeholder="Contoh: SD" required>
                            </div>
                            @error('kode_jenjang')
                                <small class="text-danger ms-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase ms-2">Nama Jenjang Lengkap</label>
                            <div class="input-box d-flex align-items-center">
                                <i class="fa-solid fa-school me-3 text-muted"></i>
                                <input type="text" name="nama_jenjang" value="{{ old('nama_jenjang', $jenjang->nama_jenjang) }}" placeholder="Contoh: Sekolah Dasar" required>
                            </div>
                            @error('nama_jenjang')
                                <small class="text-danger ms-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4 px-2">
                            <div class="d-flex align-items-center p-3 bg-light rounded-4 border-0">
                                <i class="fa-solid fa-link text-muted me-3"></i>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">SLUG SAAT INI</small>
                                    <code class="text-primary fw-bold">{{ $jenjang->slug }}</code>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-update-blue shadow">
                                <i class="fa-solid fa-save me-2"></i> Perbarui Jenjang
                            </button>
                            <a href="{{ route('master.jenjang.index') }}" class="btn btn-link text-decoration-none text-muted fw-semibold">
                                Batalkan
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection