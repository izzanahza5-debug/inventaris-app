@extends('layouts.app')

@section('content')
<style>
    .card-edit { border-radius: 25px; border: none; }
    .input-box { background-color: #f8f9fa; border-radius: 15px; padding: 12px 15px; border: 2px solid transparent; transition: 0.3s; }
    .input-box:focus-within { border-color: #f39c12; background-color: #fff; box-shadow: 0 0 0 4px rgba(243, 156, 18, 0.1); }
    .input-box input { background: transparent; border: none; outline: none; width: 100%; font-weight: 500; }
    .btn-update { background: linear-gradient(45deg, #f39c12, #e67e22); border: none; border-radius: 15px; padding: 12px; font-weight: 600; color: white; }
</style>

<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('master.sumber-dana.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm text-muted text-decoration-none">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-edit shadow-lg p-4">
                <div class="card-body text-center">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-4">
                        <i class="fa-solid fa-wallet fa-2x" style="color: #f39c12;"></i>
                    </div>
                    <h3 class="fw-bold mb-4">Edit Sumber Dana</h3>

                    <form action="{{ route('master.sumber-dana.update', $sumberDana->slug) }}" method="POST" class="text-start">
                        @csrf @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase ms-2">Kode Dana</label>
                            <div class="input-box d-flex align-items-center">
                                <i class="fa-solid fa-hashtag me-3 text-muted"></i>
                                <input type="text" name="kode_sumber" value="{{ $sumberDana->kode_sumber }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase ms-2">Nama Sumber Dana</label>
                            <div class="input-box d-flex align-items-center">
                                <i class="fa-solid fa-file-invoice-dollar me-3 text-muted"></i>
                                <input type="text" name="nama_sumber" value="{{ $sumberDana->nama_sumber }}" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-update shadow">Perbarui Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection