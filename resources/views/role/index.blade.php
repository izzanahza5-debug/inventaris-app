@extends('layouts.app')

@section('content')
<style>
    .card-master {
        border-radius: 24px;
        border: none;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
        transition: all 0.3s ease;
    }
    
    .btn-gradient-indigo {
        background: linear-gradient(135deg, #4e73df, #224abe);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-gradient-indigo:hover {
        background: linear-gradient(135deg, #2e59d9, #224abe);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
    }

    .table-modern thead th {
        background: #f8f9fa;
        border: none;
        color: #8e9aaf;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1.2px;
        padding: 15px;
    }

    .action-icon {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: all 0.2s;
        border: 1px solid #f1f1f1;
        background: white;
        text-decoration: none !important;
    }
    .btn-edit:hover { background: #4e73df; color: white !important; border-color: #4e73df; }
    .btn-delete:hover { background: #dc3545; color: white !important; border-color: #dc3545; }

    .badge-locked {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
        font-size: 0.75rem;
    }

    /* Penyesuaian Mobile Responsif */
    @media (max-width: 576px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
        
        .header-section button {
            width: 100%; /* Tombol jadi lebar penuh di HP */
            justify-content: center;
        }

        .table-modern thead th {
            padding: 10px;
            font-size: 0.6rem;
        }

        .action-icon {
            width: 32px;
            height: 32px;
        }
    }
    /* Container Pagination */
.pagination {
    gap: 5px; /* Memberi jarak antar kotak nomor */
}

.page-item .page-link {
    border: none;
    border-radius: 8px !important; /* Membuat sudut lebih bulat */
    padding: 8px 16px;
    color: #6c757d;
    font-weight: 500;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

/* Efek saat kursor diarahkan (Hover) */
 .page-item .page-link:hover {
    background-color: #e9ecef;
    color: #390dfd;
    transform: translateY(-2px); /* Efek melayang */
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Tampilan Tombol Aktif */
.page-item.active .page-link {
    background-color: #390dfd; /* Warna biru Bootstrap */
    color: white;
    box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
}

/* Tombol Disabled (Mati) */
.page-item.disabled .page-link {
    background-color: #f1f3f5;
    color: #adb5bd;
    opacity: 0.6;
}

/* Menghilangkan outline biru bawaan browser saat diklik */
.page-link:focus {
    box-shadow: none;
    outline: none;
}
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 header-section">
        <div>
            <h2 class="fw-bold mb-1" style="color: #2d3436; letter-spacing: -1px;">🔑 Kelola Role</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted small">Sistem</a></li>
                    <li class="breadcrumb-item active fw-bold small text-primary">Data Role</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-gradient-indigo px-4 py-2-5 rounded-pill shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addRoleModal">
            <i class="fa-solid fa-plus-circle me-2"></i> Tambah Role Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center p-3">
            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;"><i class="fa-solid fa-check"></i></div>
            <div class="fw-bold text-dark small-mobile">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-master">
        <div class="card-body p-0">
            <div class="table-responsive" style="border-radius: 24px;">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center px-4" width="80">ID</th>
                            <th>Nama Role Pengguna</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td class="text-center text-muted fw-medium">{{ $role->id }}</td>
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $role->nama_role }}</div>
                                {{-- <small class="text-muted opacity-75">Slug: {{ $role->slug }}</small> --}}
                            </td>
                            <td class="text-center">
                                @if($role->slug !== 'admin')
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('role.edit', $role->slug) }}" class="action-icon btn-edit text-primary shadow-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('role.destroy', $role->slug) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-icon btn-delete text-danger shadow-sm" onclick="return confirm('Hapus role ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @else
                                <span class="badge badge-locked py-2 px-3 rounded-pill">
                                    <i class="fa-solid fa-lock me-1"></i> <span class="d-none d-sm-inline">System</span> Locked
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div
                    class="p-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3 border-top">
                    <div class="text-muted small fw-500">
                        Menampilkan <b>{{ $roles->firstItem() }}</b> - <b>{{ $roles->lastItem() }}</b> dari
                        <b>{{ $roles->total() }}</b> barang
                    </div>
                    <div>
                        {!! $roles->links() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Modal Tetap Sama --}}
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-3 mx-sm-auto"> <div class="modal-content border-0 shadow-lg" style="border-radius: 28px;">
            <div class="modal-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 d-inline-block p-4 rounded-circle mb-3">
                        <i class="fa-solid fa-user-tag fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold">Tambah Role Baru</h4>
                    <p class="text-muted small">Role digunakan untuk mengelompokkan akses user.</p>
                </div>
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nama Role</label>
                        <input type="text" name="nama_role" class="form-control form-control-lg border-0 bg-light rounded-4 px-4" placeholder="Contoh: Staff IT" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-indigo btn-lg rounded-4 py-3">Simpan Role</button>
                        <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
                        <div class="mt-4 p-3 rounded-4 bg-light d-flex align-items-center border">
            <i class="fa-solid fa-circle-info text-primary me-3 fs-5"></i>
            <p class="mb-0 small text-muted">
                Nama role memengaruhi pengelompokan pengguna. Pastikan nama yang dimasukkan sudah sesuai standar operasional.
            </p>
        </div>
            </div>
        </div>
    </div>
</div>
@endsection