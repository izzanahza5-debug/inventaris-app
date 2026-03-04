@extends('layouts.app')

@section('content')
    <style>
        /* Desain Card & Hover */
        .card-master {
            border-radius: 24px;
            border: none;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            transition: all 0.3s ease;
        }

        /* Tombol Modern - Slate Blue */
        .btn-gradient-user {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-gradient-user:hover {
            background: linear-gradient(135deg, #2c3e50, #1a252f);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(44, 62, 80, 0.3);
        }

        /* Badge Role Custom */
        .role-badge {
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .badge-admin {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.2);
        }

        .badge-it {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
            border: 1px solid rgba(52, 152, 219, 0.2);
        }

        .badge-umum {
            background: rgba(149, 165, 166, 0.1);
            color: #7f8c8d;
            border: 1px solid rgba(149, 165, 166, 0.2);
        }

        /* Table Styling */
        .table-modern thead th {
            background: #f8f9fa;
            border: none;
            color: #8e9aaf;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1.2px;
            padding: 15px;
        }

        /* User Avatar Circle */
        .avatar-circle {
            width: 40px;
            height: 40px;
            background: #f1f3f5;
            color: #2c3e50;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Action Icons */
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

        .btn-edit:hover {
            background: #2c3e50;
            color: white !important;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white !important;
        }

        /* Mobile Responsive Logic */
        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .header-section button {
                width: 100%;
                margin-top: 15px;
                padding: 12px;
            }

            .user-name-text {
                font-size: 0.9rem !important;
            }

            .hide-on-mobile {
                display: none;
            }
        }
    </style>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-section">
            <div>
                <h2 class="fw-bold mb-1" style="color: #2d3436; letter-spacing: -1px;">👥 Kelola User</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted small">Sistem</a>
                        </li>
                        <li class="breadcrumb-item active fw-bold small" style="color: #2c3e50;">Manajemen Pengguna</li>
                    </ol>
                </nav>
            </div>

            <button class="btn btn-gradient-user px-4 py-2-5 rounded-pill shadow-sm" data-bs-toggle="modal"
                data-bs-target="#addUserModal">
                <i class="fa-solid fa-user-plus me-2"></i> Tambah User Baru
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-dark border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center p-3 text-white"
                style="background: #2c3e50;">
                <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 35px; height: 35px;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="fw-bold">{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-master">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center px-4" width="80">No</th>
                                <th>Nama Pengguna</th>
                                <th class="text-center hide-on-mobile">Username</th>
                                <th class="text-center">Role / Akses</th>
                                <th class="text-center" width="150">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="text-center text-muted fw-medium">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- <div class="avatar-circle me-3 hide-on-mobile">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div> --}}
                                            <div>
                                                <div class="fw-bold text-dark user-name-text">{{ $user->name }}</div>
                                                <small class="text-muted opacity-75 small">Sejak:
                                                    {{ $user->created_at->format('M Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center hide-on-mobile">
                                        <code class="fw-bold px-2 py-1 bg-light rounded text-primary"
                                            style="font-size: 0.85rem;">{{ $user->username }}</code>
                                    </td>
                                    <td class="text-center">
                                        <span class="role-badge badge-{{ strtolower($user->role) }}">
                                            <i class="fa-solid fa-shield-halved me-1 small"></i> {{ $user->role->nama_role }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('user.edit', $user->name) }}"
                                                class="action-icon btn-edit text-primary shadow-sm" title="Edit User">
                                                <i class="fa-solid fa-user-gear"></i>
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-icon btn-delete text-danger shadow-sm"
                                                    onclick="return confirm('Hapus user ini?')" title="Hapus User">
                                                    <i class="fa-solid fa-user-minus"></i>
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
                                            <p>Tidak ada data pengguna ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Letakkan ini di bawah penutup tag </table> di index.blade.php --}}
                    <div class="m-3 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                        <div class="text-muted small">
                            Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari
                            {{ $users->total() }} total barang.
                        </div>
                        <div class="d-flex justify-content-center mt-4">
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
                <div class="modal-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-dark bg-opacity-10 d-inline-block p-4 rounded-circle mb-3">
                            <i class="fa-solid fa-user-shield fa-3x text-dark"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Registrasi Akun</h4>
                        <p class="text-muted small px-3">Daftarkan personel baru dan tentukan hak akses mereka di dalam
                            sistem.</p>
                    </div>

                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light rounded-start-4"><i
                                        class="fa-solid fa-id-card text-muted"></i></span>
                                <input type="text" name="name"
                                    class="form-control form-control-lg border-0 bg-light rounded-end-4"
                                    placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Username</label>
                                <input type="text" name="username"
                                    class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="username"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Role</label>
                                <select name="role_id" class="form-select ...">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Password</label>
                            <input type="password" name="password"
                                class="form-control form-control-lg border-0 bg-light rounded-4"
                                placeholder="Min. 6 karakter" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient-user btn-lg rounded-4 py-3 shadow">
                                <i class="fa-solid fa-save me-2"></i> Buat Akun Sekarang
                            </button>
                            <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold"
                                data-bs-dismiss="modal">Batalkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
