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
    
    /* Tombol Modern - Teal */
    .btn-gradient-teal {
        background: linear-gradient(135deg, #0cbc87, #10e2a3);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-gradient-teal:hover {
        background: linear-gradient(135deg, #099c6f, #0cd196);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(12, 188, 135, 0.3);
    }

    /* Badge Lokasi Gedung */
    .location-badge {
        font-family: 'Inter', sans-serif;
        background: rgba(12, 188, 135, 0.08);
        color: #0cbc87;
        padding: 6px 16px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid rgba(12, 188, 135, 0.1);
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
    .table-modern tbody tr:hover {
        background-color: #fcfdfe;
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
    .btn-edit:hover { background: #0cbc87; color: white !important; border-color: #0cbc87; }
    .btn-delete:hover { background: #dc3545; color: white !important; border-color: #dc3545; }

    @media (max-width: 576px) {
        .header-section { flex-direction: column; align-items: flex-start !important; }
        .header-section button { width: 100%; margin-top: 15px; }
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
            <h2 class="fw-bold mb-1" style="color: #2d3436; letter-spacing: -1px;">🚪 Master Ruangan</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted small">Master</a></li>
                    <li class="breadcrumb-item active fw-bold small" style="color: #0cbc87;">Data Ruangan</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-gradient-teal px-4 py-2-5 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addRuanganModal">
            <i class="fa-solid fa-plus-circle me-2"></i> Tambah Ruangan Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center p-3" role="alert">
            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="fw-bold text-dark">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-master">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center px-4" width="80">No</th>
                            <th>Nama Ruangan</th>
                            <th class="text-center">Lokasi Gedung</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruangans as $r)
                        <tr>
                            <td class="text-center text-muted fw-medium">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $r->nama_ruangan }}</div>
                                <small class="text-muted opacity-75">Tercatat pada: {{ $r->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-center">
                                <span class="location-badge">
                                    <i class="fa-solid fa-building me-1 small"></i> {{ $r->gedung->nama_gedung }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('master.ruangan.edit', $r->nama_ruangan) }}" style="color: #0cbc87"  class="action-icon btn-edit shadow-sm" title="Ubah">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('master.ruangan.destroy', $r->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-icon btn-delete text-danger shadow-sm" onclick="return confirm('Hapus ruangan ini?')" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fa-solid fa-door-closed fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Belum ada data ruangan yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($ruangans instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="m-3 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                    <div class="text-muted small">
                        Menampilkan {{ $ruangans->firstItem() }} sampai {{ $ruangans->lastItem() }} dari
                        {{ $ruangans->total() }} total ruangan.
                    </div>
                    <div>
                        {!! $ruangans->links() !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Create --}}
<div class="modal fade" id="addRuanganModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 28px;">
            <div class="modal-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="bg-success bg-opacity-10 d-inline-block p-4 rounded-circle mb-3">
                        <i class="fa-solid fa-door-open fa-3x" style="color: #0cbc87 !important;"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Tambah Ruangan</h4>
                    <p class="text-muted small">Daftarkan ruangan baru ke dalam gedung.</p>
                </div>
                
                <form action="{{ route('master.ruangan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Pilih Gedung</label>
                        <select name="gedung_id" class="form-select form-select-lg border-0 bg-light rounded-4 px-4" required>
                            <option value="" selected disabled>-- Pilih Lokasi Gedung --</option>
                            @foreach($gedungs as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_gedung }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" class="form-control form-control-lg border-0 bg-light rounded-4 px-4" placeholder="Misal: Lab Komputer 1, Ruang Teori A" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-teal btn-lg rounded-4 py-3">
                            <i class="fa-solid fa-save me-2"></i> Simpan Ruangan
                        </button>
                        <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection