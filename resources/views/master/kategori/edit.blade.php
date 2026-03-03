@extends('layouts.app')

@section('content')
<style>
    .card-edit {
        border-radius: 25px;
        border: none;
    }
    .input-group-custom {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 10px 15px;
        border: 2px solid transparent;
        transition: all 0.3s;
    }
    .input-group-custom:focus-within {
        border-color: #6610f2;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(102, 16, 242, 0.1);
    }
    .input-group-custom input {
        background: transparent;
        border: none;
        outline: none;
        width: 100%;
        font-weight: 500;
    }
    .btn-update {
        background: linear-gradient(45deg, #6610f2, #8540f5);
        border: none;
        border-radius: 15px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 16, 242, 0.4);
    }
</style>

<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('master.kategori.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-edit shadow-lg p-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <div class="bg-soft-indigo d-inline-block p-4 rounded-circle mb-3" style="background: rgba(102, 16, 242, 0.05);">
                            <i class="fa-solid fa-pen-nib fa-2x" style="color: #6610f2;"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Edit Kategori</h3>
                        <p class="text-muted">Perbarui informasi kode atau nama kategori barang Anda.</p>
                    </div>

                    <form action="{{ route('master.kategori.update', $kategori->slug) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-2 ms-2">Kode Kategori</label>
                            <div class="input-group-custom d-flex align-items-center">
                                <i class="fa-solid fa-hashtag me-3 text-muted"></i>
                                <input type="text" name="kode_kategori" 
                                       class="@error('kode_kategori') is-invalid @enderror" 
                                       value="{{ old('kode_kategori', $kategori->kode_kategori) }}" 
                                       maxlength="5" required>
                            </div>
                            @error('kode_kategori')
                                <small class="text-danger ms-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-2 ms-2">Nama Kategori Lengkap</label>
                            <div class="input-group-custom d-flex align-items-center">
                                <i class="fa-solid fa-box-open me-3 text-muted"></i>
                                <input type="text" name="nama_kategori" 
                                       class="@error('nama_kategori') is-invalid @enderror" 
                                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                       required>
                            </div>
                            @error('nama_kategori')
                                <small class="text-danger ms-2">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- <div class="alert alert-light border-0 rounded-4 p-3 mb-4">
                            <div class="d-flex">
                                <i class="fa-solid fa-circle-info mt-1 me-3 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Slug URL saat ini:</small>
                                    <code class="fw-bold">{{ $kategori->slug }}</code>
                                    <small class="text-muted d-block mt-1 italic">*Slug akan diperbarui otomatis mengikuti nama kategori.</small>
                                </div>
                            </div>
                        </div> --}}

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-update text-white shadow">
                                <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('master.kategori.index') }}" class="btn btn-link text-decoration-none text-muted fw-semibold">
                                Batalkan Perubahan
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection