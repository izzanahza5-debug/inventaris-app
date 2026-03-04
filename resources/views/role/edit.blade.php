@extends('layouts.app')

@section('content')
<style>
    :root {
        --teal-primary: #20c997;
        --teal-dark: #1aa179;
    }

    .edit-container { max-width: 800px; margin: 2rem auto; }
    .card-edit { border: none; border-radius: 24px; background: #ffffff; box-shadow: 0 10px 40px rgba(0,0,0,0.04); overflow: hidden; }
    .card-header-gradient { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); padding: 3rem 2rem; text-align: center; color: white; }
    .icon-box { width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; border: 1px solid rgba(255, 255, 255, 0.3); }
    .form-label-custom { font-weight: 700; font-size: 0.8rem; color: #64748b; letter-spacing: 0.5px; margin-bottom: 0.75rem; display: block; }
    .input-custom { border-radius: 15px !important; padding: 12px 20px !important; border: 2px solid #f1f5f9 !important; background-color: #f8fafc !important; transition: all 0.3s ease; }
    .input-custom:focus { border-color: #4e73df !important; background-color: #fff !important; box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1) !important; }
    .btn-update { background: #4e73df; color: white; border: none; padding: 12px 30px; border-radius: 15px; font-weight: 600; transition: all 0.3s; box-shadow: 0 8px 20px rgba(78, 115, 223, 0.3); }
    .btn-update:hover { background: #224abe; color: white; transform: translateY(-2px); }
    .btn-cancel { color: #94a3b8; font-weight: 600; text-decoration: none; transition: all 0.3s; }
    .fade-up { animation: fadeUp 0.5s ease-out forwards; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container py-4 text-center">
    <div class="edit-container fade-up text-start">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('role.index') }}" class="btn-cancel small text-decoration-none">Master Role</a></li>
                <li class="breadcrumb-item active small">Update Role</li>
            </ol>
        </nav>

        <div class="card card-edit">
            <div class="card-header-gradient">
                <div class="icon-box">
                    <i class="fa-solid fa-user-gear fa-2x text-white"></i>
                </div>
                <h3 class="fw-bold mb-1">Konfigurasi Hak Akses</h3>
                <p class="mb-0 opacity-75 small">Sesuaikan nama identitas role pengguna</p>
            </div>

            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('role.update', $role->slug) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="col-md-12 mb-4">
                        <label class="form-label-custom text-uppercase">Nama Role Pengguna</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light rounded-start-4 ps-3">
                                <i class="fa-solid fa-tag text-muted"></i>
                            </span>
                            <input type="text" name="nama_role" value="{{ $role->nama_role }}" 
                                   class="form-control input-custom rounded-start-0" required>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-5">
                        <a href="{{ route('role.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-update px-5">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection