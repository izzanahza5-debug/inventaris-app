@extends('layouts.app')

@section('content')
<style>
    :root {
        --teal-main: #0fb9b1;
        --teal-hover: #20bf6b;
    }

    .edit-container { max-width: 800px; margin: 2rem auto; padding: 0 15px; }
    .card-edit { border: none; border-radius: 24px; background: #ffffff; box-shadow: 0 10px 40px rgba(0,0,0,0.04); overflow: hidden; }
    
    /* Header Gradient Teal */
    .card-header-gradient { 
        background: linear-gradient(135deg, var(--teal-main) 0%, var(--teal-hover) 100%); 
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
    .input-custom-group:focus-within { border-color: var(--teal-main); background-color: #fff; box-shadow: 0 0 0 4px rgba(15, 185, 177, 0.1); }
    .input-custom-group input { border: none; background: transparent; padding: 12px 15px; width: 100%; outline: none; font-weight: 500; }
    
    /* Button Styling */
    .btn-update { background: var(--teal-main); color: white; border: none; padding: 12px 30px; border-radius: 15px; font-weight: 600; transition: all 0.3s; box-shadow: 0 8px 20px rgba(15, 185, 177, 0.3); }
    .btn-update:hover { background: var(--teal-hover); color: white; transform: translateY(-2px); }
    .btn-cancel { color: #94a3b8; font-weight: 600; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; }

    /* Responsive */
    @media (max-width: 576px) {
        .edit-container { margin: 1rem auto; }
        .card-header-gradient { padding: 2.5rem 1.5rem; }
        .icon-box { width: 65px; height: 65px; }
        .action-footer { flex-direction: column-reverse; gap: 1.5rem; }
        .btn-update, .btn-cancel { width: 100%; justify-content: center; }
    }

    .fade-up { animation: fadeUp 0.5s ease-out forwards; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container-fluid">
    <div class="edit-container fade-up">
        <nav aria-label="breadcrumb" class="mb-4 d-none d-sm-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master.gedung.index') }}" class="btn-cancel small">Master Gedung</a></li>
                <li class="breadcrumb-item active small text-muted">Update Data</li>
            </ol>
        </nav>

        <div class="card card-edit">
            <div class="card-header-gradient">
                <div class="icon-box">
                    <i class="fa-solid fa-building-circle-check fa-2x text-white"></i>
                </div>
                <h3 class="fw-bold mb-1">Edit Informasi Gedung</h3>
                <p class="mb-0 opacity-75 small px-3">Pastikan kode gedung unik untuk identifikasi aset</p>
            </div>

            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('master.gedung.update', $gedung->slug) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-5 mb-4">
                            <label class="form-label-custom text-uppercase">Kode Gedung</label>
                            <div class="input-custom-group d-flex align-items-center">
                                <i class="fa-solid fa-hashtag text-muted"></i>
                                <input type="text" name="kode_gedung" value="{{ $gedung->kode_gedung }}" required placeholder="Contoh: GDA">
                            </div>
                        </div>

                        <div class="col-md-7 mb-4">
                            <label class="form-label-custom text-uppercase">Nama Gedung</label>
                            <div class="input-custom-group d-flex align-items-center">
                                <i class="fa-solid fa-building text-muted"></i>
                                <input type="text" name="nama_gedung" value="{{ $gedung->nama_gedung }}" required placeholder="Contoh: Gedung Utama">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 action-footer">
                        <a href="{{ route('master.gedung.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-arrow-left me-2"></i> Batal & Kembali
                        </a>
                        <button type="submit" class="btn btn-update px-5">
                            <i class="fa-solid fa-save me-2"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        {{-- <div class="text-center mt-4">
            <small class="text-muted italic">Terakhir diperbarui: {{ $gedung->updated_at->diffForHumans() }}</small>
        </div> --}}
    </div>
</div>
@endsection