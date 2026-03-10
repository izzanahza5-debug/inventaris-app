@extends('layouts.app')

@section('content')
    <style>
        /* Gradient Header Modern */
        .page-title-box {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 5px solid #0d6efd;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
        }

        /* Button Wrap Handling */
        @media (max-width: 576px) {
            .header-actions {
                flex-wrap: wrap;
                gap: 15px;
            }

            .btn-create {
                width: 100%;
                justify-content: center;
            }
        }

        .btn-create {
            background: linear-gradient(45deg, #0d6efd, #0043a8);
            border: none;
            transition: 0.3s;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        /* Tabel Styling */
        .table thead th {
            background-color: #f8fafc !important;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 15px 20px !important;
        }

        .table td {
            padding: 15px 20px !important;
        }

        .status-badge {
            padding: 5px 12px;
            font-size: 0.75rem;
            border-radius: 8px;
        }

        .status-pending {
            background-color: #fff7ed;
            color: #c2410c;
            border: 1px solid #ffedd5;
        }

        .status-disetujui {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #d1fae5;
        }

        .status-ditolak {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fee2e2;
        }

        .status-selesai {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
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

    <div class="container-fluid px-4">
        <div class="page-title-box shadow-sm d-flex flex-wrap align-items-center justify-content-between header-actions">
            <div>
                <h3 class="fw-bold text-dark mb-1">Pengajuan Barang</h3>
                <p class="text-muted small mb-0">Kelola dan pantau status pengadaan barang sekolah Anda.</p>
            </div>
            <a href="{{ route('pengajuan.create') }}" class="btn btn-primary px-4 py-2 shadow-sm rounded-pill btn-create">
                <i class="fa-solid fa-plus me-2"></i> Buat Pengajuan
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body px-4 py-3">
                <form action="{{ route('pengajuan.index') }}" method="GET">
                    <div class="row g-3 align-items-center">

                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-4 text-muted">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="search" name="search" class="form-control border-start-0 rounded-end-4 py-2"
                                    placeholder="Cari Nomor Pengajuan..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <select name="jenjang_id" class="form-select rounded-4 py-2">
                                <option value="" selected disabled>-- Semua Jenjang --</option>
                                @foreach ($jenjangs as $jenjang)
                                    <option value="{{ $jenjang->id }}"
                                        {{ request('jenjang_id') == $jenjang->id ? 'selected' : '' }}>
                                        {{ $jenjang->nama_jenjang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            {{-- <div class="col-lg-2 col-md-3"> --}}
                            <button type="submit" class="btn btn-create text-light w-100 rounded-4 shadow-sm"
                                style=" border:none;">
                                <i class="fa-solid fa-filter me-1"></i> Filter
                            </button>
                            {{-- </div> --}}

                            @if (request()->filled('search') || request()->filled('jenjang_id'))
                                <a href="{{ route('pengajuan.index') }}"
                                    class="btn btn-light rounded-pill px-3 text-secondary" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </a>
                            @endif
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card overflow-hidden border">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">No. Pengajuan</th>
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Total Biaya</th>
                                <th>Jenjang</th>
                                <th class="text-center">Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengajuans as $item)
                                <tr>
                                    <td class="ps-4"><span class="fw-bold text-dark">{{ $item->no_pengajuan }}</span></td>
                                    <td>{{ $item->tanggal_pengajuan->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2"
                                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa-solid fa-user" style="font-size: 0.8rem;"></i>
                                            </div>
                                            <span class="small fw-semibold">{{ $item->user->name }}</span>
                                        </div>
                                    </td>
                                    <td><span class="text-primary fw-bold">Rp
                                            {{ number_format($item->total_biaya, 0, ',', '.') }}</span></td>
                                    <td>{{ $item->jenjang->nama_jenjang }}</td>
                                    <td class="text-center">
                                        @php $statusClass = 'status-' . strtolower($item->status); @endphp
                                        <span class="status-badge fw-semibold {{ $statusClass }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1"> <a
                                                href="{{ route('pengajuan.show', $item->no_pengajuan) }}"
                                                class="btn-action btn btn-info btn-sm text-white" title="Lihat"><i
                                                    class="fa-solid fa-eye"></i></a>

                                            @if ($item->status == 'Pending')
                                                <a href="{{ route('pengajuan.edit', $item->no_pengajuan) }}"
                                                    class="btn-action btn btn-warning btn-sm text-white" title="Edit"><i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                            @endif

                                            <a href="{{ route('pengajuan.cetak', $item->id) }}"
                                                class="btn-action btn btn-danger btn-sm"  title="PDF"><i
                                                    class="fa-solid fa-file-pdf"></i></a>

                                            @if ($item->status == 'Pending' || auth()->user()->role->slug == 'admin')
                                                <form action="{{ route('pengajuan.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-action btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Yakin hapus?')" title="Hapus"><i
                                                            class="fa-solid fa-trash"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-box-open fa-3x mb-3 opacity-50"></i><br>
                                        Belum ada data pengajuan barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div
                    class="p-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3 border-top">
                    <div class="text-muted small fw-500">
                        Menampilkan <b>{{ $pengajuans->firstItem() }}</b> - <b>{{ $pengajuans->lastItem() }}</b> dari
                        <b>{{ $pengajuans->total() }}</b> barang
                    </div>
                    <div>
                        {!! $pengajuans->links() !!}
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
@endsection
