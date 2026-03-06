    @extends('layouts.app')

    @section('content')
    <style>
        /* Gradient Backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }
        .bg-gradient-info {
            background: linear-gradient(135deg, #36b9cc 0%, #1a8a97 100%);
        }
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 700;
        }
        .info-value {
            font-weight: 600;
            color: #1e293b;
        }
        .table-detail thead th {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            color: #475569;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        .status-banner {
            border-radius: 12px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
    </style>

    <div class="container-fluid px-4">
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 mt-2 gap-3">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('pengajuan.index') }}" class="text-decoration-none">Pengajuan</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
        <h3 class="fw-bold text-dark">Detail Pengajuan: <span class="text-primary">{{ $pengajuan->no_pengajuan }}</span></h3>
    </div>
    
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('pengajuan.index') }}" class="btn btn-light border rounded-pill px-4 py-2 flex-grow-1 flex-md-grow-0">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
        <a href="{{ route('pengajuan.cetak', $pengajuan->id) }}" class="btn btn-danger rounded-pill px-4 py-2 shadow-sm flex-grow-1 flex-md-grow-0" target="_blank">
            <i class="fa-solid fa-file-pdf me-2"></i> Cetak PDF
        </a>
    </div>
</div>

        @if($pengajuan->status == 'Ditolak')
        <div class="status-banner bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger mb-4">
            <i class="fa-solid fa-circle-xmark fs-4 me-3"></i>
            <div>
                <h6 class="fw-bold mb-0">Pengajuan Ditolak</h6>
                <p class="small mb-0"><strong>Alasan:</strong> {{ $pengajuan->catatan_admin ?? 'Tidak ada catatan.' }}</p>
            </div>
        </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card card-custom mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Rincian Barang</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-detail mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Item</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuan->details as $detail)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $detail->nama_barang }}</div>
                                        <div class="text-muted small">Spec: {{ $detail->spesifikasi ?? '-' }}</div>
                                        <div class="text-muted italic small">Ket: {{ $detail->keterangan ?? '-' }}</div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ $detail->jumlah }} Unit</span></td>
                                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end pe-4 fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
                                    <td colspan="3" class="text-end fw-bold py-3">TOTAL KESELURUHAN</td>
                                    <td class="text-end pe-4 py-3">
                                        <h5 class="fw-bold text-primary mb-0">Rp {{ number_format($pengajuan->total_biaya, 0, ',', '.') }}</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-custom mb-4">
                    <div class="card-body p-0">
                        <div class="bg-gradient-primary p-4 text-white text-center">
                            <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="fa-solid fa-user-tie fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-0">{{ $pengajuan->user->name }}</h5>
                            <p class="small opacity-75 mb-0 text-uppercase tracking-wider">Pemohon Pengajuan</p>
                        </div>
                        <div class="p-4">
                            <div class="mb-3">
                                <div class="info-label">Tanggal Pengajuan</div>
                                <div class="info-value">{{ $pengajuan->tanggal_pengajuan->format('d F Y') }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Jenjang</div>
                                <div class="info-value">{{ $pengajuan->jenjang->nama_jenjang }}</div>
                            </div>
                            <div>
                                <div class="info-label">Status Saat Ini</div>
                                <div class="mt-2">
                                    <span class="badge py-2 px-3 rounded-pill 
                                        @if($pengajuan->status == 'Pending') bg-warning 
                                        @elseif($pengajuan->status == 'Disetujui') bg-success 
                                        @elseif($pengajuan->status == 'Ditolak') bg-danger 
                                        @else bg-primary @endif">
                                        {{ $pengajuan->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->role->slug == 'admin')
                <div class="card card-custom border-primary border-top border-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-user-shield me-2 text-primary"></i>Panel Keputusan</h5>
                        <form action="{{ route('pengajuan.update-status', $pengajuan->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Ubah Status</label>
                                <select name="status" id="status-select" class="form-select shadow-sm" required>
                                    <option value="Pending" {{ $pengajuan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Disetujui" {{ $pengajuan->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="Ditolak" {{ $pengajuan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="Selesai" {{ $pengajuan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            <div id="rejection-note" class="mb-3 {{ $pengajuan->status == 'Ditolak' ? '' : 'd-none' }}">
                                <label class="form-label small fw-bold text-danger">Alasan Penolakan</label>
                                <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Berikan alasan mengapa pengajuan ditolak...">{{ $pengajuan->catatan_admin }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold shadow-sm">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
        // Logic untuk memunculkan input alasan jika status diubah ke 'Ditolak'
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status-select');
            const rejectionNote = document.getElementById('rejection-note');

            if(statusSelect) {
                statusSelect.addEventListener('change', function() {
                    if(this.value === 'Ditolak') {
                        rejectionNote.classList.remove('d-none');
                    } else {
                        rejectionNote.classList.add('d-none');
                    }
                });
            }
        });
    </script>
    @endsection