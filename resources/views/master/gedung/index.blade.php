@extends('layouts.app')

@section('content')
<style>
    .card-master { border-radius: 20px; transition: all 0.3s; }
    .card-master:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .btn-gradient-gedung { background: linear-gradient(45deg, #0fb9b1, #20bf6b); border: none; color: white; }
    .btn-gradient-gedung:hover { background: linear-gradient(45deg, #0ca69e, #1ca95f); color: white; }
    .code-badge {
        font-family: 'Monaco', monospace;
        background: rgba(15, 185, 177, 0.1);
        color: #0fb9b1;
        padding: 8px 15px;
        border-radius: 10px;
        font-weight: 700;
    }
    .action-icon { width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: all 0.2s; border: 1px solid #eee; }
    
         th {
        background: transparent;
        border-bottom: 2px solid #f1f1f1;
        color: #adb5bd;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-5" style="flex-wrap: wrap">
        <div>
            <h2 class="fw-bold mb-1">🏢 Master Gedung</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Master</a></li>
                    <li class="breadcrumb-item active fw-bold text-teal" style="color: #0fb9b1;">Data Gedung</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-gradient-gedung px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addGedungModal">
            <i class="fa-solid fa-plus me-2"></i> Tambah Gedung
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
            <i class="fa-solid fa-circle-check me-2 fs-4 text-teal"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="card card-master border-0 shadow-sm text-nowrap">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th class="text-center text-secondary fw-light">No</th>
                            <th class="text-center text-secondary fw-light ps-0">Kode Lokasi</th>
                            <th class="text-center text-secondary fw-light">Nama Gedung</th>
                            {{-- <th class="text-center text-secondary fw-light">Status Slug</th> --}}
                            <th class="text-center text-secondary fw-light">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gedungs as $g)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="ps-0 text-center"><span class="code-badge">{{ $g->kode_gedung }}</span></td>
                            <td class="text-center">
                                <div class="fw-bold text-dark fs-5">{{ $g->nama_gedung }}</div>
                                {{-- <small class="text-muted small">Lokasi ID: #BLD-{{ $g->id }}</small> --}}
                            </td>
                            {{-- <td><span class="badge bg-light text-muted fw-normal px-2 py-1">/{{ $g->slug }}</span></td> --}}
                            <td class="text-center pe-0">
                                <a href="{{ route('master.gedung.edit', $g->slug) }}" class="action-icon text-primary me-2 shadow-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('master.gedung.destroy', $g->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-icon text-danger shadow-sm" onclick="return confirm('Hapus gedung ini?')">
                                        <i class="fa-solid fa-trash"></i>
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

<div class="modal fade" id="addGedungModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                        <i class="fa-solid fa-building-circle-check fa-3x text-teal" style="color: #0fb9b1;"></i>
                    </div>
                    <h4 class="fw-bold">Input Gedung Baru</h4>
                    <p class="text-muted">Gedung akan menjadi bagian dari Kode Inventaris.</p>
                </div>
                
                <form action="{{ route('master.gedung.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small">KODE GEDUNG (G1, G2, Lab)</label>
                        <input type="text" name="kode_gedung" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Contoh: G1" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small">NAMA GEDUNG</label>
                        <input type="text" name="nama_gedung" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Contoh: Gedung Utama Selatan" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-gedung btn-lg rounded-4 shadow">Simpan Gedung</button>
                        <button type="button" class="btn btn-light btn-lg rounded-4 text-muted" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection