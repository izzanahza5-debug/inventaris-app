@extends('layouts.app')

@section('content')
<style>
    .card-edit { border-radius: 25px; border: none; }
    .input-box { background-color: #f8f9fa; border-radius: 15px; padding: 12px 15px; border: 2px solid transparent; transition: 0.3s; }
    .input-box:focus-within { border-color: #2c3e50; background-color: #fff; box-shadow: 0 0 0 4px rgba(44, 62, 80, 0.1); }
    .input-box input, .input-box select { background: transparent; border: none; outline: none; width: 100%; font-weight: 500; }
    .btn-update { background: linear-gradient(45deg, #34495e, #2c3e50); border: none; border-radius: 15px; padding: 12px; font-weight: 600; color: white; }
</style>

<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('user.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm text-muted text-decoration-none">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-edit shadow-lg p-4">
                <div class="card-body text-center">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-4">
                        <i class="fa-solid fa-user-pen fa-2x text-dark"></i>
                    </div>
                    <h3 class="fw-bold mb-4">Edit Profil Pengguna</h3>

                    <form action="{{ route('user.update', $user->name) }}" method="POST" class="text-start">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">NAMA PENGGUNA</label>
                            <div class="input-box d-flex align-items-center">
                                <i class="fa-solid fa-id-card me-3 text-muted"></i>
                                <input type="text" name="name" value="{{ $user->name }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">USERNAME</label>
                            <div class="input-box d-flex align-items-center">
                                <i class="fa-solid fa-at me-3 text-muted"></i>
                                <input type="text" name="username" value="{{ $user->username }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">ROLE</label>
                            <div class="input-box d-flex align-items-center">
                                <i class="fa-solid fa-shield me-3 text-muted"></i>
                                <select name="role" required>
                                    <option value="umum" {{ $user->role == 'umum' ? 'selected' : '' }}>Umum</option>
                                    <option value="it" {{ $user->role == 'it' ? 'selected' : '' }}>IT</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">PASSWORD (KOSONGKAN JIKA TIDAK DIGANTI)</label>
                            <div class="input-box d-flex align-items-center">
                                <i class="fa-solid fa-lock me-3 text-muted"></i>
                                <input type="password" name="password" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-update shadow">Simpan Perubahan User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection