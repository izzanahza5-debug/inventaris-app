@extends('layouts.app')

@section('content')
<style>
    .card-master { border-radius: 20px; transition: all 0.3s; }
    .card-master:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .btn-gradient-user { background: linear-gradient(45deg, #34495e, #2c3e50); border: none; color: white; }
    .btn-gradient-user:hover { background: linear-gradient(45deg, #2c3e50, #1a252f); color: white; }
    .role-badge {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-admin { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
    .badge-it { background: rgba(52, 152, 219, 0.1); color: #3498db; }
    .badge-umum { background: rgba(149, 165, 166, 0.1); color: #7f8c8d; }
    .action-icon { width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: all 0.2s; border: 1px solid #eee; }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">👥 Kelola User</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Sistem</a></li>
                    <li class="breadcrumb-item active fw-bold" style="color: #2c3e50;">Manajemen Pengguna</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-gradient-user px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fa-solid fa-user-plus me-2"></i> Tambah User Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-dark border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center text-white">
            <i class="fa-solid fa-circle-check me-2 fs-4"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="card card-master border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Pengguna</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Role / Hak Akses</th>
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                {{-- <div class="d-flex align-items-center"> --}}
                                    {{-- <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                        <i class="fa-solid fa-user-tie text-muted"></i>
                                    </div> --}}
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ $user->name }}</div>
                                        <small class="text-muted">Terdaftar: {{ $user->created_at->format('d M Y') }}</small>
                                    </div>
                                {{-- </div> --}}
                            </td>
                            <td class="text-center"><code class="fw-bold text-primary">{{ $user->username }}</code></td>
                            <td class="text-center">
                                <span class="role-badge badge-{{ $user->role }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('user.edit', $user->name) }}" class="action-icon text-primary me-2 shadow-sm text-decoration-none">
                                    <i class="fa-solid fa-user-gear"></i>
                                </a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-icon text-danger shadow-sm bg-transparent border-1" onclick="return confirm('Hapus user ini?')">
                                        <i class="fa-solid fa-user-minus"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                        <i class="fa-solid fa-user-shield fa-3x text-dark"></i>
                    </div>
                    <h4 class="fw-bold">Registrasi Akun Baru</h4>
                    <p class="text-muted">Tentukan akses yang sesuai untuk personil sekolah.</p>
                </div>
                
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small">NAMA LENGKAP</label>
                        <input type="text" name="name" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Contoh: Ahmad Sulaiman" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">USERNAME</label>
                        <input type="text" name="username" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Contoh: ahmad_it" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">PASSWORD</label>
                        <input type="password" name="password" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small">ROLE / HAK AKSES</label>
                        <select name="role" class="form-select form-select-lg border-0 bg-light rounded-4" required>
                            <option value="umum">Umum</option>
                            <option value="it">IT</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-user btn-lg rounded-4 shadow">Buat Akun</button>
                        <button type="button" class="btn btn-light btn-lg rounded-4 text-muted" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection