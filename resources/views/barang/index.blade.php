@extends('layouts.app')

@section('content')
    <style>
        /* Global & Background */
        :root {
            --primary-grad: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
            --danger-grad: linear-gradient(135deg, #ef476f 0%, #d90429 100%);
            --success-grad: linear-gradient(135deg, #06d6a0 0%, #059669 100%);
            --warning-grad: linear-gradient(135deg, #ffd166 0%, #f59e0b 100%);
            --indigo-grad: linear-gradient(135deg, #4cc9f0 0%, #4361ee 100%);
        }

        .card-barang {
            border-radius: 24px;
            border: none;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* Hero Header */
        .hero-section {
            background: white;
            padding: 2rem;
            border-radius: 24px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        /* Badge Custom */
        .badge-kondisi {
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kondisi-baik {
            background: #dcfce7;
            color: #166534;
        }

        .kondisi-rusak-ringan {
            background: #fef9c3;
            color: #854d0e;
        }

        .kondisi-rusak-berat {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Button Styling */
        .btn-modern {
            border: none;
            border-radius: 14px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
            color: white !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-pdf {
            background: var(--danger-grad);
        }

        .btn-excel {
            background: var(--success-grad);
        }

        .btn-label {
            background: var(--warning-grad);
        }

        .btn-add {
            background: var(--primary-grad);
        }

        /* Input Styling */
        .input-box-custom {
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 14px;
            height: 48px;
            transition: 0.3s;
        }

        .input-box-custom:focus-within {
            border-color: #4361ee;
            background: white;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .img-preview {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 14px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Table Design */
        .table thead th {
            background: #f8fafc;
            border: none;
            color: #64748b;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            .hero-section {
                text-align: center;
            }

            .action-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }

            .btn-modern {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid py-4">
        <div class="hero-section d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-dark">📦 Inventaris Barang</h2>
                <p class="text-muted mb-0">Pantau dan kelola aset sekolah secara real-time</p>
            </div>
            <a href="{{ route('barang.create') }}" class="btn btn-modern btn-add shadow">
                <i class="fa-solid fa-plus-circle"></i> Input Barang Baru
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 fade show" role="alert">
                <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card card-barang mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap gap-2 mb-4 action-buttons">
                    <a href="{{ route('barang.export-pdf', request()->query()) }}" class="btn btn-modern btn-pdf shadow-sm">
                        <i class="fa-solid fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="{{ route('barang.export-excel', request()->query()) }}"
                        class="btn btn-modern btn-excel shadow-sm">
                        <i class="fa-solid fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('barang.cetak-label', request()->all()) }}" class="btn btn-modern btn-label shadow-sm"
                        target="_blank">
                        <i class="fa-solid fa-qrcode"></i> Cetak Label QR
                    </a>
                </div>

                <hr class="opacity-50">

                <form action="{{ route('barang.index') }}" method="GET" class="row g-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="input-box-custom d-flex align-items-center px-3">
                            <i class="fa-solid fa-search text-muted me-2"></i>
                            <input type="search" name="search" class="form-control border-0 bg-transparent shadow-none"
                                placeholder="Cari nama atau no. inventaris..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="gedung" class="form-select input-box-custom shadow-none border-0 px-3">
                            <option value="">Semua Lokasi</option>
                            @foreach ($gedungs as $g)
                                <option value="{{ $g->id }}" {{ request('gedung') == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama_gedung }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="kondisi" class="form-select input-box-custom shadow-none border-0 px-3">
                            <option value="">Semua Kondisi</option>
                            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak
                                Ringan</option>
                            <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak
                                Berat</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-3">
                        <button type="submit" class="btn btn-primary w-100 rounded-4 shadow-sm"
                            style="height: 48px; background: #4361ee; border:none;">
                            <i class="fa-solid fa-filter me-1"></i> Filter
                        </button>
                    </div>

                    <div class="col-lg-2 col-md-3">
                        <a href="{{ route('barang.index') }}"
                            class="btn btn-light w-100 rounded-4 d-flex align-items-center justify-content-center fw-bold"
                            style="height: 48px; border: 2px solid #f1f5f9;">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-barang">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" width="50">NO</th>
                                <th>INFORMASI BARANG</th>
                                <th class="text-center">LOKASI</th>
                                <th class="text-center">TGL PEROLEHAN</th>
                                <th class="text-center">KONDISI</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs as $item)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($item->foto_barang)
                                                <img src="{{ asset('storage/' . $item->foto_barang) }}"
                                                    class="img-preview me-3">
                                            @else
                                                <div
                                                    class="img-preview me-3 bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fa-solid fa-box text-muted fa-lg"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark mb-0">{{ $item->nama_barang }}</div>
                                                <span class="badge bg-light text-primary border px-2 py-1"
                                                    style="font-size: 0.7rem;">
                                                    <i
                                                        class="fa-solid fa-hashtag me-1 small"></i>{{ $item->no_inventaris }}
                                                </span>
                                                <div class="small text-muted mt-1">{{ $item->sumberDana->nama_sumber }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-600"><i class="fa-solid fa-location-dot text-danger me-1"></i>
                                            {{ $item->gedung->nama_gedung }}</div>
                                    </td>
                                    <td class="text-center text-muted small">
                                        {{ $item->tanggal_perolehan->format('d M Y') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-kondisi kondisi-{{ Str::slug($item->kondisi) }}">
                                            {{ $item->kondisi }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('barang.cetak-label-satuan', $item->id) }}"
                                                class="btn btn-sm btn-light rounded-3 p-2 text-success"
                                                title="Cetak Label QR" target="_blank">
                                                <i class="fa-solid fa-qrcode fa-lg"></i>
                                            </a>
                                            <a href="{{ route('barang.show', $item->nama_barang) }}"
                                                class="btn btn-sm btn-light rounded-3 p-2 text-warning" title="Detail">
                                                <i class="fa-solid fa-eye fa-lg"></i>
                                            </a>
                                            <a href="{{ route('barang.edit', $item->nama_barang) }}"
                                                class="btn btn-sm btn-light rounded-3 p-2 text-primary" title="Edit">
                                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                            </a>
                                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-light rounded-3 p-2 text-danger"
                                                    onclick="return confirm('Hapus barang ini?')" title="Hapus">
                                                    <i class="fa-solid fa-trash-can fa-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <img src="https://illustrations.popsy.co/gray/empty-box.svg" style="width: 150px;"
                                            class="mb-3">
                                        <h5 class="text-muted">Oops! Tidak ada data barang ditemukan.</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div
                    class="p-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3 border-top">
                    <div class="text-muted small fw-500">
                        Menampilkan <b>{{ $barangs->firstItem() }}</b> - <b>{{ $barangs->lastItem() }}</b> dari
                        <b>{{ $barangs->total() }}</b> barang
                    </div>
                    <div>
                        {!! $barangs->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
