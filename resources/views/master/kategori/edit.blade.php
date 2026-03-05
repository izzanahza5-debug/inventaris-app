@extends('layouts.app')

@section('content')
<style>
    :root {
        --indigo-primary: #6610f2;
        --indigo-dark: #520dc2;
        --indigo-light: #8540f5;
    }

    .edit-container { max-width: 800px; margin: 2rem auto; padding: 0 15px; }
    .card-edit { border: none; border-radius: 24px; background: #ffffff; box-shadow: 0 10px 40px rgba(0,0,0,0.04); overflow: hidden; }
    
    /* Header Gradient dengan Warna Ungu */
    .card-header-gradient { 
        background: linear-gradient(135deg, var(--indigo-primary) 0%, var(--indigo-dark) 100%); 
        padding: 3rem 2rem; 
        text-align: center; 
        color: white; 
    }

    .icon-box { 
        width: 80px; height: 80px; 
        background: rgba(255, 255, 255, 0.2); 
        backdrop-filter: blur(10px); 
        border-radius: 20px; 
        display: flex; align-items: center; justify-content: center; 
        margin: 0 auto 1.5rem; 
        border: 1px solid rgba(255, 255, 255, 0.3); 
    }

    /* Form Styling */
    .form-label-custom { font-weight: 700; font-size: 0.75rem; color: #64748b; letter-spacing: 0.5px; margin-bottom: 0.75rem; display: block; }
    .input-custom-group { background-color: #f8fafc; border: 2px solid #f1f5f9; border-radius: 15px; transition: 0.3s; padding-left: 15px; }
    .input-custom-group:focus-within { border-color: var(--indigo-primary); background-color: #fff; box-shadow: 0 0 0 4px rgba(102, 16, 242, 0.1); }
    .input-custom-group input { border: none; background: transparent; padding: 12px 15px; width: 100%; outline: none; font-weight: 500; }
    
    /* Button Styling */
    .btn-update { background: linear-gradient(45deg, var(--indigo-primary), var(--indigo-light)); color: white; border: none; padding: 12px 30px; border-radius: 15px; font-weight: 600; transition: all 0.3s; box-shadow: 0 8px 20px rgba(102, 16, 242, 0.3); }
    .btn-update:hover { transform: translateY(-2px); color: white; box-shadow: 0 12px 25px rgba(102, 16, 242, 0.4); }
    .btn-cancel { color: #94a3b8; font-weight: 600; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; }

    /* Responsive */
    @media (max-width: 576px) {
        .edit-container { margin: 1rem auto; }
        .card-header-gradient { padding: 2.5rem 1.5rem; }
        .icon-box { width: 65px; height: 65px; }
        .action-footer { flex-direction: column-reverse; gap: 1.2rem; }
        .btn-update, .btn-cancel { width: 100%; justify-content: center; }
    }

    .fade-up { animation: fadeUp 0.5s ease-out forwards; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container-fluid">
    <div class="edit-container fade-up">
        <nav aria-label="breadcrumb" class="mb-4 d-none d-sm-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master.kategori.index') }}" class="btn-cancel small">Master Kategori</a></li>
                <li class="breadcrumb-item active small text-muted">Edit Kategori</li>
            </ol>
        </nav>

        <div class="card card-edit">
            <div class="card-header-gradient">
                <div class="icon-box">
                    <i class="fa-solid fa-layer-group fa-2x text-white"></i>
                </div>
                <h3 class="fw-bold mb-1">Edit Master Kategori</h3>
                <p class="mb-0 opacity-75 small px-3">Pastikan kode kategori sesuai dengan standar klasifikasi aset</p>
            </div>

            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('master.kategori.update', $kategori->slug) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label-custom text-uppercase">Kode Kategori</label>
                            <div class="input-custom-group d-flex align-items-center">
                                <i class="fa-solid fa-hashtag text-muted"></i>
                                <input type="text" name="kode_kategori" 
                                       class="@error('kode_kategori') is-invalid @enderror" 
                                       value="{{ old('kode_kategori', $kategori->kode_kategori) }}" 
                                       maxlength="5" placeholder="CONTOH" required>
                            </div>
                            @error('kode_kategori')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-4">
                            <label class="form-label-custom text-uppercase">Nama Kategori Barang</label>
                            <div class="input-custom-group d-flex align-items-center">
                                <i class="fa-solid fa-box-open text-muted"></i>
                                <input type="text" name="nama_kategori" 
                                       class="@error('nama_kategori') is-invalid @enderror" 
                                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                       placeholder="Contoh: Peralatan Komputer" required>
                            </div>
                            @error('nama_kategori')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="p-3 rounded-4 mb-4" style="background: rgba(102, 16, 242, 0.05); border: 1px dashed rgba(102, 16, 242, 0.2);">
                        <div class="d-flex align-items-start">
                            <i class="fa-solid fa-circle-info mt-1 me-3" style="color: var(--indigo-primary);"></i>
                            <div>
                                <small class="text-dark d-block fw-bold">Penting!</small>
                                <small class="text-muted small">Perubahan kode kategori dapat mempengaruhi format nomor inventaris otomatis pada barang baru yang didaftarkan setelah ini.</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between action-footer">
                        <a href="{{ route('master.kategori.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-update px-5">
                            <i class="fa-solid fa-check-double me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection