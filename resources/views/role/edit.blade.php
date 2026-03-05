@extends('layouts.app')

@section('content')
<style>
    :root {
        --teal-primary: #20c997;
        --teal-dark: #1aa179;
        --indigo-main: #4e73df;
        --indigo-hover: #224abe;
    }

    .edit-container { max-width: 800px; margin: 2rem auto; padding: 0 15px; }
    .card-edit { border: none; border-radius: 24px; background: #ffffff; box-shadow: 0 10px 40px rgba(0,0,0,0.04); overflow: hidden; }
    
    /* Header Gradient */
    .card-header-gradient { 
        background: linear-gradient(135deg, var(--indigo-main) 0%, var(--indigo-hover) 100%); 
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
    .form-label-custom { font-weight: 700; font-size: 0.8rem; color: #64748b; letter-spacing: 0.5px; margin-bottom: 0.75rem; display: block; }
    .input-custom { border-radius: 15px !important; padding: 12px 20px !important; border: 2px solid #f1f5f9 !important; background-color: #f8fafc !important; transition: all 0.3s ease; }
    .input-custom:focus { border-color: var(--indigo-main) !important; background-color: #fff !important; box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1) !important; }
    
    /* Button Styling */
    .btn-update { background: var(--indigo-main); color: white; border: none; padding: 12px 30px; border-radius: 15px; font-weight: 600; transition: all 0.3s; box-shadow: 0 8px 20px rgba(78, 115, 223, 0.3); }
    .btn-update:hover { background: var(--indigo-hover); color: white; transform: translateY(-2px); }
    .btn-cancel { color: #94a3b8; font-weight: 600; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; }
    .btn-cancel:hover { color: #64748b; }

    /* Responsive Adjustment */
    @media (max-width: 576px) {
        .edit-container { margin: 1rem auto; }
        .card-header-gradient { padding: 2rem 1.5rem; }
        .icon-box { width: 60px; height: 60px; margin-bottom: 1rem; }
        .icon-box i { font-size: 1.5rem; }
        .card-header-gradient h3 { font-size: 1.25rem; }
        
        .card-body { padding: 1.5rem !important; }
        
        /* Tombol tumpuk di mobile */
        .action-footer {
            flex-direction: column-reverse; /* Simpan di atas, Kembali di bawah */
            gap: 1.5rem;
        }
        .btn-update { width: 100%; }
        .btn-cancel { width: 100%; justify-content: center; }
    }

    .fade-up { animation: fadeUp 0.5s ease-out forwards; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container-fluid">
    <div class="edit-container fade-up">
        <nav aria-label="breadcrumb" class="mb-4 d-none d-sm-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('role.index') }}" class="btn-cancel small">Master Role</a></li>
                <li class="breadcrumb-item active small" aria-current="page text-muted">Update Role</li>
            </ol>
        </nav>

        <div class="card card-edit">
            <div class="card-header-gradient">
                <div class="icon-box">
                    <i class="fa-solid fa-user-gear fa-2x text-white"></i>
                </div>
                <h3 class="fw-bold mb-1">Edit Role</h3>
                <p class="mb-0 opacity-75 small px-3">Perbarui nama identitas hak akses sistem</p>
            </div>

            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('role.update', $role->slug) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label-custom text-uppercase">Nama Role Pengguna</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light rounded-start-4 ps-3">
                                <i class="fa-solid fa-tag text-muted"></i>
                            </span>
                            <input type="text" name="nama_role" value="{{ $role->nama_role }}" 
                                   class="form-control input-custom rounded-start-0" 
                                   placeholder="Contoh: Administrator" required>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 mt-lg-5 action-footer">
                        <a href="{{ route('role.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar
                        </a>
                        <button type="submit" class="btn btn-update">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4 p-3 rounded-4 bg-light d-flex align-items-center border">
            <i class="fa-solid fa-circle-info text-primary me-3 fs-5"></i>
            <p class="mb-0 small text-muted">
                Nama role memengaruhi pengelompokan pengguna. Pastikan nama yang dimasukkan sudah sesuai standar operasional.
            </p>
        </div>
    </div>
</div>
@endsection