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
    
    /* Tombol Modern - Amber/Orange */
    .btn-gradient-amber {
        background: linear-gradient(135deg, #f39c12, #fbc531);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-gradient-amber:hover {
        background: linear-gradient(135deg, #e67e22, #f39c12);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
    }

    /* Badge & Typography */
    .code-badge-amber {
        font-family: 'JetBrains Mono', 'Fira Code', monospace;
        background: rgba(243, 156, 18, 0.05);
        color: #f39c12;
        padding: 6px 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        border: 1px solid rgba(243, 156, 18, 0.1);
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
    .btn-edit:hover { background: #f39c12; color: white !important; border-color: #f39c12; }
    .btn-delete:hover { background: #dc3545; color: white !important; border-color: #dc3545; }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start !important;
        }
        .header-section button {
            width: 100%;
            margin-top: 15px;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 header-section">
        <div>
            <h2 class="fw-bold mb-1" style="color: #2d3436; letter-spacing: -1px;">💰 Sumber Dana</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted small">Master</a></li>
                    <li class="breadcrumb-item active fw-bold small" style="color: #f39c12;">Data Pembelian</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-gradient-amber px-4 py-2-5 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addDanaModal">
            <i class="fa-solid fa-plus-circle me-2"></i> Tambah Sumber Dana
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center p-3 text-white" style="background-color: #f39c12;" role="alert">
            <div class="bg-white text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="fw-bold">{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-master">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center px-4" width="80">No</th>
                            <th class="text-center">Kode Pembelian</th>
                            <th>Nama Sumber Dana</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sumberDanas as $sd)
                        <tr>
                            <td class="text-center text-muted fw-medium">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                <span class="code-badge-amber">{{ $sd->kode_sumber }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $sd->nama_sumber }}</div>
                                <small class="text-muted opacity-75">Update terakhir: {{ $sd->updated_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('master.sumber-dana.edit', $sd->slug) }}" class="action-icon btn-edit text-primary shadow-sm" title="Ubah">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('master.sumber-dana.destroy', $sd->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-icon btn-delete text-danger shadow-sm " onclick="return confirm('Hapus sumber dana ini?')" title="Hapus">
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
                                    <i class="fa-solid fa-money-bill-transfer fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Belum ada sumber dana yang tercatat.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                                {{-- Letakkan ini di bawah penutup tag </table> di index.blade.php --}}
                    <div class="m-3 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                        <div class="text-muted small">
                            Menampilkan {{ $sumberDanas->firstItem() }} sampai {{ $sumberDanas->lastItem() }} dari
                            {{ $sumberDanas->total() }} total barang.
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {!! $sumberDanas->links() !!}
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDanaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 28px;">
            <div class="modal-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="bg-warning bg-opacity-10 d-inline-block p-4 rounded-circle mb-3">
                        <i class="fa-solid fa-hand-holding-dollar fa-3x text-warning"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Input Sumber Dana</h4>
                    <p class="text-muted small px-md-4">Gunakan singkatan yang jelas untuk mempermudah pelaporan inventaris.</p>
                </div>
                
                <form action="{{ route('master.sumber-dana.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Kode Dana (Maximal 3 karakter)</label>
                        <input type="text" name="kode_sumber" class="form-control form-control-lg border-0 bg-light rounded-4 px-4" placeholder="Contoh: BOSSD" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nama Sumber Dana</label>
                        <input type="text" name="nama_sumber" class="form-control form-control-lg border-0 bg-light rounded-4 px-4" placeholder="Contoh: Dana BOS Tahap 1" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-amber btn-lg rounded-4 py-3 shadow">
                            <i class="fa-solid fa-save me-2"></i>Simpan Data
                        </button>
                        <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold" data-bs-dismiss="modal">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection