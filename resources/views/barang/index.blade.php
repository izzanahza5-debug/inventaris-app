@extends('layouts.app')

@section('content')
    <style>
        .card-barang {
            border-radius: 20px;
            border: none;
            transition: 0.3s;
        }

        .badge-kondisi {
            padding: 6px 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .kondisi-baik {
            background: #e6fcf5;
            color: #0ca678;
        }

        .kondisi-rusak-ringan {
            background: #fff9db;
            color: #f08c00;
        }

        .kondisi-rusak-berat {
            background: #fff5f5;
            color: #e03131;
        }

        .img-preview {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>

    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-dark">📦 Kelola Barang</h2>
                <p class="text-muted mb-0">Manajemen aset dan nomor inventaris sekolah</p>
            </div>
            <a href="{{ route('barang.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                <i class="fa-solid fa-plus me-2"></i> Input Barang Baru
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex my-2" style="gap: 10px">
            <a href="{{ route('barang.export-pdf', request()->query()) }}" class="btn btn-danger btn-sm rounded-pill px-3">
                <i class="fa-solid fa-file-pdf me-1"></i> Export PDF
            </a>
            <a href="{{ route('barang.export-excel', request()->query()) }}"
                class="btn btn-success btn-sm rounded-pill px-3">
                <i class="fa-solid fa-file-excel me-1"></i> Export Excel
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form action="{{ route('barang.index') }}" method="GET" class="row g-2">

                    <div class="col-md-4">
                        <div class="input-group-custom d-flex align-items-center px-3"
                            style="background: #f8f9fa; border-radius: 10px; border: 1px solid #dee2e6; height: 45px;">
                            <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
                            <input type="text" name="search" class="form-control border-0 bg-transparent"
                                placeholder="Cari nama atau no. inventaris..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <select name="gedung" class="form-select border-1 shadow-none"
                            style="background: #f8f9fa; border-radius: 10px; height: 45px;">
                            <option value="">Semua Lokasi</option>
                            @foreach ($gedungs as $g)
                                <option value="{{ $g->id }}" {{ request('gedung') == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama_gedung }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="kondisi" class="form-select border-1 shadow-none"
                            style="background: #f8f9fa; border-radius: 10px; height: 45px;">
                            <option value="">Semua Kondisi</option>
                            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak
                                Ringan</option>
                            <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak
                                Berat</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-3" style="height: 45px;">
                            <i class="fa-solid fa-filter me-1"></i> Filter
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ route('barang.index') }}"
                            class="btn btn-light w-100 rounded-3 d-flex align-items-center justify-content-center"
                            style="height: 45px;">
                            Reset
                        </a>
                    </div>
                    {{-- <div class="col-md-2 d-flex gap-2">
    <button type="submit" class="btn btn-primary w-100 rounded-3">
        <i class="fa-solid fa-filter"></i> Filter
    </button>
</div> --}}



                </form>
            </div>
        </div>


        <div class="card card-barang shadow-sm">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-muted small text-uppercase">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">No. Inventaris</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Lokasi</th>
                                <th class="text-center">Tgl Perolehan</th>
                                <th class="text-center">Kondisi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <span class="fw-bold text-primary">{{ $item->no_inventaris }}</span>
                                        <div class="small text-muted">{{ $item->sumberDana->nama_sumber }}</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center">
                                            @if ($item->foto_barang)
                                                <img src="{{ asset('storage/' . $item->foto_barang) }}"
                                                    class="img-preview me-3 border">
                                            @else
                                                <div
                                                    class="img-preview me-3 bg-light d-flex align-items-center justify-content-center border">
                                                    <i class="fa-solid fa-box text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $item->nama_barang }}</div>
                                                <div class="small text-muted">{{ $item->kategori->nama_kategori }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><i class="fa-solid fa-location-dot text-danger me-1 small"></i>
                                        {{ $item->gedung->nama_gedung }}</td>
                                    <td class="text-center">{{ $item->tanggal_perolehan->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <span class="badge-kondisi kondisi-{{ Str::slug($item->kondisi) }}">
                                            {{ $item->kondisi }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-end gap-1">

                                            <a href="{{ route('barang.edit', $item->id) }}"
                                                class="btn btn-sm btn-edit rounded-circle bg-primary" title="Edit Data">
                                                <i class="fa-solid fa-pen-to-square text-light"></i>
                                            </a>

                                            <a href="{{ route('barang.show', $item->id) }}"
                                                class="btn bg-warning btn-sm btn-detail mx-2 rounded-circle "
                                                title="Lihat Detail">
                                                <i class="fa-solid fa-eye text-light"></i>
                                            </a>

                                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-delete rounded-circle bg-danger "
                                                    title="Hapus Barang"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                    <i class="fa-solid fa-trash-can text-light"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada barang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Letakkan ini di bawah penutup tag </table> di index.blade.php --}}
                    <div class="mt-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                        <div class="text-muted small">
                            Menampilkan {{ $barangs->firstItem() }} sampai {{ $barangs->lastItem() }} dari
                            {{ $barangs->total() }} total barang.
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {!! $barangs->links() !!}
                        </div>
                    </div>

                    <style>
                        /* Custom style agar pagination terlihat lebih modern */
                        .pagination {
                            margin-bottom: 0;
                        }

                        .page-link {
                            border-radius: 8px !important;
                            margin: 0 3px;
                            border: none;
                            color: #495057;
                            font-weight: 500;
                        }

                        .page-item.active .page-link {
                            background-color: #0d6efd;
                            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
@endsection
