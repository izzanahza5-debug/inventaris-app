@extends('layouts.app')

@section('content')
    <style>
        /* Palet Warna Utama - Indigo Blue */
        :root {
            --indigo-main: #4e73df;
            --indigo-dark: #224abe;
        }

        .card-master {
            border-radius: 24px;
            border: none;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            transition: all 0.3s ease;
        }

        /* Tombol Modern - Indigo Gradient */
        .btn-gradient-user {
            background: linear-gradient(135deg, var(--indigo-main), var(--indigo-dark));
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-gradient-user:hover {
            background: linear-gradient(135deg, var(--indigo-dark), #1a3996);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }

        /* Badge Role Custom - Lebih Cerah */
        .role-badge {
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
        }

        /* Styling Badge Berdasarkan Slug/Nama Role */
        .badge-admin { background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.2); }
        .badge-it { background: rgba(78, 115, 223, 0.1); color: #4e73df; border: 1px solid rgba(78, 115, 223, 0.2); }
        .badge-umum { background: rgba(108, 117, 125, 0.1); color: #6c757d; border: 1px solid rgba(108, 117, 125, 0.2); }

        /* Table Styling */
        .table-modern thead th {
            background: #f8f9fa;
            border: none;
            color: #8e9aaf;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 1.2px;
            padding: 15px;
        }

        /* User Avatar Circle */
        .avatar-circle {
            width: 38px;
            height: 38px;
            background: #f1f5f9;
            color: var(--indigo-main);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-weight: bold;
            border: 1px solid #e2e8f0;
        }

        /* Action Icons */
        .action-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.2s;
            border: 1px solid #f1f1f1;
            background: white;
            text-decoration: none !important;
        }

        .btn-edit:hover { background: var(--indigo-main); color: white !important; }
        .btn-delete:hover { background: #dc3545; color: white !important; }

        /* Mobile Responsive Logic */
        @media (max-width: 768px) {
            .header-section { flex-direction: column; align-items: flex-start !important; gap: 1rem; }
            .header-section button { width: 100%; margin-top: 0; padding: 12px; border-radius: 15px; }
            .user-name-text { font-size: 0.85rem !important; }
            .hide-on-mobile { display: none; }
            .card-master { border-radius: 15px; }
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
                <h2 class="fw-bold mb-1" style="color: #2d3436; letter-spacing: -1px;">👥 Kelola User</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item small"><a href="#" class="text-decoration-none text-muted">Sistem</a></li>
                        <li class="breadcrumb-item active fw-bold small text-primary">Manajemen Pengguna</li>
                    </ol>
                </nav>
            </div>

            <button class="btn btn-gradient-user px-4 py-2-5 rounded-pill shadow-sm" data-bs-toggle="modal"
                data-bs-target="#addUserModal">
                <i class="fa-solid fa-user-plus me-2"></i> Tambah User Baru
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center p-3">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-check small"></i>
                </div>
                <div class="fw-bold text-dark small">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card card-master">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center px-4" width="70">No</th>
                                <th>Informasi Pengguna</th>
                                <th class="text-center hide-on-mobile">Username</th>
                                <th class="text-center">Akses Sistem</th>
                                <th class="text-center" width="130">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="text-center text-muted fw-medium">{{ $users->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-3 hide-on-mobile">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark user-name-text">{{ $user->name }}</div>
                                                {{-- <small class="text-muted small">ID: #{{ $user->id }}</small> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center hide-on-mobile">
                                        <span class="badge bg-light text-primary border px-2 py-1" style="font-family: 'Courier New', Courier, monospace;">
                                            {{ $user->username }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="role-badge badge-umum">
                                            <i class="fa-solid fa-circle me-2" style="font-size: 6px;"></i> 
                                            {{ $user->role->nama_role }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('user.edit', $user->name) }}"
                                                class="action-icon btn-edit text-primary" title="Edit User">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-icon btn-delete text-danger"
                                                    onclick="return confirm('Hapus user ini?')">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted opacity-50">
                                            <i class="fa-solid fa-users-slash fa-3x mb-3"></i>
                                            <p>Data pengguna tidak tersedia.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="px-4 py-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small">
                            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                        </div>
                        <div class="pagination-sm">
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 28px;">
                <div class="modal-body p-4 p-md-5 text-center">
                    <div class="bg-primary bg-opacity-10 d-inline-block p-4 rounded-circle mb-3">
                        <i class="fa-solid fa-user-plus fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold">Registrasi Personel</h4>
                    <p class="text-muted small mb-4">Pastikan data yang dimasukkan sudah valid untuk hak akses sistem.</p>

                    <form action="{{ route('user.store') }}" method="POST" class="text-start">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-custom fw-bold small text-muted">NAMA LENGKAP</label>
                            <input type="text" name="name" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom fw-bold small text-muted">USERNAME</label>
                                <input type="text" name="username" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="username" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom fw-bold small text-muted">ROLE AKSES</label>
                                <select name="role_id" class="form-select form-select-lg border-0 bg-light rounded-4">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label-custom fw-bold small text-muted">KATA SANDI</label>
                            <input type="password" name="password" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Min. 6 karakter" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient-user btn-lg rounded-4 py-3 shadow">
                                <i class="fa-solid fa-save me-2"></i> Daftarkan User
                            </button>
                            <button type="button" class="btn btn-link text-decoration-none text-muted" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection