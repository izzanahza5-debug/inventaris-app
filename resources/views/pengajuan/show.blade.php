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
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
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

            /* Styling untuk Area Upload Nota */
            .border-dashed {
                border-style: dashed !important;
                border-color: #cbd5e1 !important;
                transition: all 0.3s ease;
            }

            .upload-area-wrapper {
                background-color: #f8fafc;
                overflow: hidden;
            }

            .upload-area-wrapper:hover {
                border-color: #0d6efd !important;
                background-color: #eff6ff;
            }

            .cursor-pointer {
                cursor: pointer;
            }

            .transition-all {
                transition: all 0.3s ease;
            }
        </style>

        <div class="container-fluid px-4">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 mt-2 gap-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('pengajuan.index') }}"
                                    class="text-decoration-none">Pengajuan</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                    <h3 class="fw-bold text-dark">Detail Pengajuan: <span
                            class="text-primary">{{ $pengajuan->no_pengajuan }}</span></h3>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('pengajuan.index') }}"
                        class="btn btn-light border rounded-pill px-4 py-2 flex-grow-1 flex-md-grow-0">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                    </a>
                    <a href="{{ route('pengajuan.cetak', $pengajuan->id) }}"
                        class="btn btn-danger rounded-pill px-4 py-2 shadow-sm flex-grow-1 flex-md-grow-0" target="_blank">
                        <i class="fa-solid fa-file-pdf me-2"></i> Cetak PDF
                    </a>
                </div>
            </div>

            @if ($pengajuan->status == 'Ditolak')
                <div class="status-banner bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger mb-4">
                    <i class="fa-solid fa-circle-xmark fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">Pengajuan Ditolak</h6>
                        <p class="small mb-0"><strong>Alasan:</strong>
                            {{ $pengajuan->catatan_admin ?? 'Tidak ada catatan.' }}</p>
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
                                        @if ($pengajuan->status == 'Selesai')
                                            <th class="text-center">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengajuan->details as $detail)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-dark">{{ $detail->nama_barang }}</div>
                                                <div class="text-muted small">Spec: {{ $detail->spesifikasi ?? '-' }}</div>
                                                <div class="text-muted italic small">Ket: {{ $detail->keterangan ?? '-' }}
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light text-dark border">{{ $detail->jumlah }}
                                                    Unit</span></td>
                                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                            <td class="text-end pe-4 fw-bold">Rp
                                                {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                            @if ($pengajuan->status == 'Selesai')
                                                <td class="text-center" style=""  >
                                                    @if ($detail->nota)
                                                        <a href="{{ asset('storage/public/nota/' . $detail->nota) }}"
                                                            target="_blank"
                                                            class="btn my-1 btn-sm bg-gradient-primary rounded-3 border-0">
                                                            <i class="fa-solid fa-eye text-light"></i>
                                                        </a>
                                                    @else
                                                        <button onclick="alert('Anda belum mengupload nota')"
                                                            class="btn my-1 btn-sm btn-secondary rounded-3 border-0">
                                                            <i class="fa-solid fa-eye-slash"></i>
                                                        </button>
                                                    @endif

                                                    @if (Auth::user()->role->slug === 'admin' || Auth::user()->role_id === $pengajuan->user->role_id)
                                                        <button
                                                            style="background: linear-gradient(135deg, #0b5ed7, #0bacbe);"
                                                            type="button" class="btn my-1 btn-sm  rounded-3 border-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#uploadModal{{ $detail->id }}">
                                                            <i class="fa-solid text-light fa-upload"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>

                                        <div class="modal fade" id="uploadModal{{ $detail->id }}" tabindex="-1"
                                            aria-labelledby="uploadModalLabel{{ $detail->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <div class="modal-header border-bottom-0 pb-0 mt-2 px-4">
                                                        <h5 class="modal-title fw-bold text-dark"
                                                            id="uploadModalLabel{{ $detail->id }}">
                                                            <i class="fa-solid fa-file-invoice text-primary me-2"></i>Unggah
                                                            Bukti Nota
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <form action="{{ route('pengajuan.uploadNota', $detail->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body p-4">
                                                            <div
                                                                class="alert alert-light border rounded-3 mb-4 d-flex align-details-center">
                                                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                                                    <i class="fa-solid fa-box text-primary fs-5"></i>
                                                                </div>
                                                                <div>
                                                                    <span class="small d-block text-muted mb-1">Upload nota
                                                                        untuk detail:</span>
                                                                    <strong
                                                                        class="text-dark">{{ $detail->nama_barang }}</strong>
                                                                </div>
                                                            </div>

                                                            <div class="upload-area-wrapper position-relative text-center p-4 border border-2 border-dashed rounded-4 transition-all"
                                                                id="upload-area-{{ $detail->id }}">
                                                                <input type="file" name="nota"
                                                                    id="nota-{{ $detail->id }}"
                                                                    class="form-control position-absolute w-100 h-100 opacity-0 top-0 start-0 cursor-pointer"
                                                                    accept=".jpg,.png,image/jpeg,image/png" required
                                                                    onchange="previewImage(this, '{{ $detail->id }}')">

                                                                <div id="upload-prompt-{{ $detail->id }}" class="py-3">
                                                                    <i
                                                                        class="fa-solid fa-cloud-arrow-up fs-1 text-primary mb-3"></i>
                                                                    <h6 class="fw-bold mb-1">Klik atau Drop file di sini
                                                                    </h6>
                                                                    <p class="text-muted small mb-0">Format JPG, PNG. Maks.
                                                                        5MB.</p>
                                                                </div>

                                                                <div id="preview-container-{{ $detail->id }}"
                                                                    class="d-none">
                                                                    <img id="preview-img-{{ $detail->id }}"
                                                                        src="" alt="Preview Nota"
                                                                        class="img-fluid rounded-3 shadow-sm border"
                                                                        style="max-height: 200px; object-fit: contain;">
                                                                    <div class="mt-3">
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-danger rounded-pill px-4"
                                                                            onclick="resetUpload('{{ $detail->id }}')">
                                                                            <i class="fa-solid fa-rotate-left me-1"></i>
                                                                            Ganti File
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="modal-footer border-top-0 pt-0 pb-4 px-4 d-flex justify-content-between">
                                                            <button type="button"
                                                                class="btn btn-light rounded-pill px-4 fw-bold"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"
                                                                id="btn-submit-{{ $detail->id }}">
                                                                <i class="fa-solid fa-upload me-2"></i>Simpan Nota
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end fw-bold py-3">TOTAL KESELURUHAN</td>
                                        <td class="text-end pe-4 py-3">
                                            <h5 class="fw-bold text-primary mb-0">Rp
                                                {{ number_format($pengajuan->total_biaya, 0, ',', '.') }}</h5>
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
                                <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 70px; height: 70px;">
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
                                        <span
                                            class="badge py-2 px-3 rounded-pill 
                                        @if ($pengajuan->status == 'Pending') bg-warning 
                                        @elseif($pengajuan->status == 'Disetujui') bg-success 
                                        @elseif($pengajuan->status == 'Ditolak') bg-danger 
                                        @else bg-gradient-primary @endif">
                                            {{ $pengajuan->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (auth()->user()->role->slug == 'admin')
                        <div class="card card-custom border-primary border-top border-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3"><i class="fa-solid fa-user-shield me-2 text-primary"></i>Panel
                                    Keputusan</h5>
                                <form action="{{ route('pengajuan.update-status', $pengajuan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Ubah Status</label>
                                        <select name="status" id="status-select" class="form-select shadow-sm" required>
                                            <option value="Pending"
                                                {{ $pengajuan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Disetujui"
                                                {{ $pengajuan->status == 'Disetujui' ? 'selected' : '' }}>Disetujui
                                            </option>
                                            <option value="Ditolak"
                                                {{ $pengajuan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            <option value="Selesai"
                                                {{ $pengajuan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </div>

                                    <div id="rejection-note"
                                        class="mb-3 {{ $pengajuan->status == 'Ditolak' ? '' : 'd-none' }}">
                                        <label class="form-label small fw-bold text-danger">Alasan Penolakan</label>
                                        <textarea name="catatan_admin" class="form-control" rows="3"
                                            placeholder="Berikan alasan mengapa pengajuan ditolak...">{{ $pengajuan->catatan_admin }}</textarea>
                                    </div>

                                    <button type="submit"
                                        class="btn bg-gradient-primary text-light w-100 py-2 rounded-pill fw-bold shadow-sm">
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

                if (statusSelect) {
                    statusSelect.addEventListener('change', function() {
                        if (this.value === 'Ditolak') {
                            rejectionNote.classList.remove('d-none');
                        } else {
                            rejectionNote.classList.add('d-none');
                        }
                    });
                }
            });

            function previewImage(input, id) {
                const promptDiv = document.getElementById('upload-prompt-' + id);
                const previewContainer = document.getElementById('preview-container-' + id);
                const previewImg = document.getElementById('preview-img-' + id);
                const submitBtn = document.getElementById('btn-submit-' + id);

                const file = input.files[0];

                if (file) {
                    // Validasi Ukuran (Maks 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 5MB.');
                        resetUpload(id);
                        return;
                    }

                    // Membaca file untuk preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;

                        // Sembunyikan prompt, tampilkan preview
                        promptDiv.classList.add('d-none');
                        previewContainer.classList.remove('d-none');

                        // Tambahkan efek sedikit padding
                        document.getElementById('upload-area-' + id).classList.remove('p-4');
                        document.getElementById('upload-area-' + id).classList.add('p-3');
                    }
                    reader.readAsDataURL(file);
                }
            }

            function resetUpload(id) {
                // Kembalikan ke tampilan semula
                document.getElementById('nota-' + id).value = '';
                document.getElementById('preview-img-' + id).src = '';

                document.getElementById('preview-container-' + id).classList.add('d-none');
                document.getElementById('upload-prompt-' + id).classList.remove('d-none');

                document.getElementById('upload-area-' + id).classList.remove('p-3');
                document.getElementById('upload-area-' + id).classList.add('p-4');
            }
        </script>
    @endsection
