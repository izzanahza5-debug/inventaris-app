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
                flex-direction: column;
                align-items: stretch !important;
                gap: 15px;
            }
            .header-buttons {
                display: flex;
                flex-direction: column;
                width: 100%;
                gap: 10px;
            }
            .btn-create, .btn-print {
                width: 100%;
                justify-content: center;
                font-size: 15px;
            }
        }

        /* Jika layar tablet ke atas, tombol jejer kesamping */
        @media (min-width: 577px) {
            .header-buttons {
                display: flex;
                gap: 10px;
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

        .btn-print {
            transition: 0.3s;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        /* Tabel Styling (Sama seperti sebelumnya) */
        .table thead th { background-color: #f8fafc !important; font-size: 0.75rem; letter-spacing: 0.05em; padding: 15px 20px !important; }
        .table td { padding: 15px 20px !important; }
        .status-badge { padding: 5px 12px; font-size: 0.75rem; border-radius: 8px; }
        .status-pending { background-color: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
        .status-disetujui { background-color: #ecfdf5; color: #047857; border: 1px solid #d1fae5; }
        .status-ditolak { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }
        .status-selesai { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
        .pagination { gap: 5px; }
        .page-item .page-link { border: none; border-radius: 8px !important; padding: 8px 16px; color: #6c757d; font-weight: 500; transition: all 0.3s ease; background-color: #f8f9fa; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); }
        .page-item .page-link:hover { background-color: #e9ecef; color: #390dfd; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .page-item.active .page-link { background-color: #390dfd; color: white; box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3); }
        .page-item.disabled .page-link { background-color: #f1f3f5; color: #adb5bd; opacity: 0.6; }
        .page-link:focus { box-shadow: none; outline: none; }
    </style>

    <div class="container-fluid px-4">
        <div class="page-title-box shadow-sm d-flex align-items-center justify-content-between header-actions">
            <div>
                <h3 class="fw-bold text-dark mb-1">Pengajuan Barang</h3>
                <p class="text-muted small mb-0">Kelola dan pantau status pengadaan barang sekolah Anda.</p>
            </div>
            
            <div class="header-buttons">
                <form action="{{ route('pengajuan.laporanPdf') }}" method="GET" class="m-0">
                    @foreach(request()->except('page') as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    
                    <button type="submit" class="btn btn-danger px-4 py-2 shadow-sm rounded-pill btn-print">
                        <i class="fa-solid fa-file-pdf me-2"></i> Cetak Laporan
                    </button>
                </form>

                <a href="{{ route('pengajuan.create') }}" class="btn btn-primary px-4 py-2 shadow-sm rounded-pill btn-create text-white">
                    <i class="fa-solid fa-plus me-2"></i> Buat Pengajuan
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-xmark me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h6 class="mb-0 text-primary fw-bold">
                    <i class="fa-solid fa-sliders me-2"></i>Filter Data Pengajuan
                </h6>
            </div>

            <div class="card-body px-4 py-4">
                <form action="{{ route('pengajuan.index') }}" method="GET">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold mb-1">Cari Pengajuan</label>
                            <div class="input-group shadow-sm rounded-4">
                                <span class="input-group-text bg-white border-end-0 rounded-start-4 text-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="search" name="search" class="form-control border-start-0 rounded-end-4 py-2"
                                    placeholder="Nomor Pengajuan..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold mb-1">Pilih Jenjang</label>
                            <div class="input-group shadow-sm rounded-4">
                                <span class="input-group-text bg-white border-end-0 rounded-start-4 text-success">
                                    <i class="fa-solid fa-layer-group"></i>
                                </span>
                                <select name="jenjang_id" class="form-select border-start-0 rounded-end-4 py-2">
                                    <option value="" selected>-- Semua Jenjang --</option>
                                    @foreach ($jenjangs as $jenjang)
                                        <option value="{{ $jenjang->id }}"
                                            {{ request('jenjang_id') == $jenjang->id ? 'selected' : '' }}>
                                            {{ $jenjang->nama_jenjang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if (Auth::user()->role && Auth::user()->role->slug == 'admin')
                            <div class="col-md-4">
                                <label class="form-label small text-muted fw-semibold mb-1">Role Pengaju</label>
                                <div class="input-group shadow-sm rounded-4">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-4 text-warning">
                                        <i class="fa-solid fa-user-shield"></i>
                                    </span>
                                    <select name="role_id" class="form-select border-start-0 rounded-end-4 py-2">
                                        <option value="" selected>-- Semua Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                                {{ $role->nama_role }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold mb-1">Tanggal Mulai</label>
                            <div class="input-group shadow-sm rounded-4">
                                <span class="input-group-text bg-white border-end-0 rounded-start-4 text-info">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </span>
                                <input type="date" name="tgl_mulai"
                                    class="form-control border-start-0 rounded-end-4 py-2"
                                    value="{{ request('tgl_mulai') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold mb-1">Tanggal Selesai</label>
                            <div class="input-group shadow-sm rounded-4">
                                <span class="input-group-text bg-white border-end-0 rounded-start-4 text-danger">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </span>
                                <input type="date" name="tgl_selesai"
                                    class="form-control border-start-0 rounded-end-4 py-2"
                                    value="{{ request('tgl_selesai') }}">
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <div class="d-flex flex-wrap gap-2 w-100">
                                <button type="submit" class="btn text-light flex-grow-1 rounded-4 shadow-sm py-2 fw-semibold"
                                    style="border:none; background: linear-gradient(135deg, #0d6efd, #0a58ca);">
                                    <i class="fa-solid fa-filter me-1"></i> Filter
                                </button>

                                @if (request()->hasAny(['search', 'jenjang_id', 'role_id', 'tgl_mulai', 'tgl_selesai']))
                                    <a href="{{ route('pengajuan.index') }}"
                                        class="btn btn-light rounded-4 px-3 shadow-sm py-2 text-danger border" 
                                        title="Reset Filter" style="background-color: #fff5f5;">
                                        <i class="fa-solid fa-rotate-right"></i>
                                    </a>
                                @endif
                            </div>
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
                                        <div class="d-flex justify-content-center gap-1"> 
                                            <a href="{{ route('pengajuan.show', $item->no_pengajuan) }}" class="btn-action btn btn-info btn-sm text-white" title="Lihat"><i class="fa-solid fa-eye"></i></a>

                                            @if ($item->status == 'Pending')
                                                <a href="{{ route('pengajuan.edit', $item->no_pengajuan) }}" class="btn-action btn btn-warning btn-sm text-white" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                            @endif

                                            <a href="{{ route('pengajuan.cetak', $item->id) }}" class="btn-action btn btn-danger btn-sm" title="PDF"><i class="fa-solid fa-file-pdf"></i></a>

                                            @if ($item->status == 'Pending' || auth()->user()->role->slug == 'admin')
                                                <form action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-action btn btn-outline-danger btn-sm" onclick="return confirm('Yakin hapus?')" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-box-open fa-3x mb-3 opacity-50"></i><br>
                                        Belum ada data pengajuan barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="p-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3 border-top">
                        <div class="text-muted small fw-500">
                            Menampilkan <b>{{ $pengajuans->firstItem() ?? 0 }}</b> - <b>{{ $pengajuans->lastItem() ?? 0 }}</b> dari
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