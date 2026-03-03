@extends('layouts.app')

@section('content')
<style>
    .card-master {
        border-radius: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-master:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .btn-gradient {
        background: linear-gradient(45deg, #6610f2, #8540f5);
        border: none;
        color: white;
    }
    .btn-gradient:hover {
        background: linear-gradient(45deg, #520dc2, #7032e0);
        color: white;
    }
    .code-badge {
        font-family: 'Monaco', 'Consolas', monospace;
        letter-spacing: 1px;
        background: rgba(102, 16, 242, 0.1);
        color: #6610f2;
        padding: 8px 15px;
        border-radius: 10px;
        font-weight: 700;
    }
    .table-modern thead th {
        background: transparent;
        border-bottom: 2px solid #f1f1f1;
        color: #adb5bd;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }
    .action-icon {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
    }
    .action-icon:hover {
        background: #f8f9fa;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-5" style="flex-wrap: wrap">
        <div>
            <h2 class="fw-bold mb-1" style="color: #2d3436;">📦 Kategori Barang</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Master</a></li>
                    <li class="breadcrumb-item active fw-bold" style="color: #6610f2;">Kode Barang</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-gradient px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
            <i class="fa-solid fa-plus me-2"></i> Buat Kategori Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
            <i class="fa-solid fa-circle-check me-2 fs-4"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="card card-master border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-modern align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center ps-0">Kode barang</th>
                            <th class="text-center">Nama Kategori</th>
                            {{-- <th class="text-center">Tautan Slug</th> --}}
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoris as $kat)
                        <tr>
                            <td class="text-center"> {{ $loop->iteration }} </td>
                            <td class=" text-center">
                                <span class="code-badge">{{ $kat->kode_kategori }}</span>
                            </td>
                            <td class="text-center">
                                <div class="fw-bold text-dark fs-5">{{ $kat->nama_kategori }}</div>
                                {{-- <small class="text-muted">ID Internal: #CAT-0{{ $kat->id }}</small> --}}
                            </td>
                            {{-- <td class="text-center">
                                <span class="text-muted small bg-light px-2 py-1 rounded">
                                    <i class="fa-solid fa-link me-1"></i> {{ $kat->slug }}
                                </span>
                            </td> --}}
                            <td class="text-center pe-0">
                                <a href="{{ route('master.kategori.edit', $kat->slug) }}" class="action-icon text-primary me-2 shadow-sm border">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('master.kategori.destroy', $kat->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-icon text-danger shadow-sm border" onclick="return confirm('Hapus kategori ini?')">
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

<div class="modal fade" id="addKategoriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                        <i class="fa-solid fa-tags fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold">Tambah Kategori</h4>
                    <p class="text-muted">Pastikan kode unik dan mudah diingat.</p>
                </div>
                
                <form action="{{ route('master.kategori.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Kategori (MJ, EL, dll)</label>
                        <input type="text" name="kode_kategori" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Contoh: MJ" maxlength="5" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_kategori" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Contoh: Meja Belajar" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient btn-lg rounded-4">Simpan Sekarang</button>
                        <button type="button" class="btn btn-light btn-lg rounded-4 text-muted" data-bs-dismiss="modal">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection