@extends('layouts.app')

@section('content')
    <style>
        /* Flex-Wrap untuk header daftar item */
        .item-header {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        /* Memastikan tombol tambah item tetap besar di mobile */
        #add-item {
            flex-shrink: 0;
            width: 100%;
        }

        @media (min-width: 576px) {
            #add-item {
                width: auto;
            }
        }

        /* Memperbaiki spasi form di mobile agar tidak sempit */
        .form-section {
            padding: 20px !important;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 15px !important;
            }

            .header-gradient {
                padding: 20px;
            }
        }

        .header-gradient {
            background: linear-gradient(135deg, #0d6efd 0%, #003d99 100%);
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.15);
        }

        .form-section {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            border-top: 5px solid #0d6efd;
        }

        .item-row {
            background: #f8fbff;
            border: 1px solid #e1e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
            transition: all 0.3s ease;
        }

        .item-row:hover {
            border-color: #0d6efd;
            transform: scale(1.01);
        }

        .btn-remove {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
        }

        .sticky-total {
            position: sticky;
            top: 20px;
        }

        .total-display-card {
            background: #f0f7ff;
            border: 2px dashed #0d6efd;
            border-radius: 15px;
            padding: 20px;
        }
    </style>

    <div class="container-fluid px-4">
        <div class="header-gradient d-flex align-items-center justify-content-between">
            <div>
                <h2 class="fw-bold mb-1">Edit Pengajuan</h2>
                <p class="mb-0 opacity-75">Nomor: {{ $pengajuan->no_pengajuan }}</p>
            </div>
            <i class="fa-solid fa-file-pen fs-1 opacity-25"></i>
        </div>

        <form action="{{ route('pengajuan.update', $pengajuan->no_pengajuan) }}" method="POST" id="editForm">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="form-section">
                        <div class="item-header">
                            <h5 class="fw-bold mb-0 text-dark">Daftar Item Barang</h5>
                            <button type="button" class="btn btn-outline-primary rounded-pill px-4" id="add-item">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Item
                            </button>
                        </div>

                        <div id="item-container">
                            @foreach ($pengajuan->details as $index => $detail)
                                <div class="item-row">
                                    @if ($index > 0)
                                        <button type="button" class="btn btn-danger btn-remove"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    @endif
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">Nama Barang</label>
                                            <input type="text" name="nama_barang[]" class="form-control"
                                                value="{{ $detail->nama_barang }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold text-secondary">Jumlah</label>
                                            <input type="number" name="jumlah[]" class="form-control input-qty"
                                                value="{{ $detail->jumlah }}" min="1" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold text-secondary">Harga Satuan</label>
                                            <input type="number" name="harga_satuan[]" class="form-control input-harga"
                                                value="{{ $detail->harga_satuan }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">Keterangan</label>
                                            <textarea name="keterangan[]" class="form-control" rows="2">{{ $detail->keterangan }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">Spesifikasi</label>
                                            <textarea name="spesifikasi[]" class="form-control" rows="2">{{ $detail->spesifikasi }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-total">
                        <div class="card card-custom border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4">
                                <div class="mb-3">

                                    <label class="form-label fw-bold text-dark mb-2">Pilih Jenjang</label>
                                    <select name="jenjang_id"
                                        class="form-select form-select-lg rounded-3 @error('jenjang_id') is-invalid @enderror"
                                        required>
                                        <option value="" disabled>-- Pilih Jenjang --</option>
                                        @foreach ($jenjangs as $jenjang)
                                            <option value="{{ $jenjang->id }}"
                                                {{ $pengajuan->jenjang_id == $jenjang->id ? 'selected' : '' }}>
                                                {{ $jenjang->nama_jenjang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                    @error('jenjang_id')
                                        <div class="invalid-feedback d-block mt-1">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                
                                <h6 class="fw-bold text-secondary mb-3">Ringkasan Biaya</h6>
                                <div class="total-display-card text-center mb-4">
                                    <span class="small text-muted d-block mb-1">Total Pengajuan</span>
                                    <h3 class="fw-bold text-primary mb-0" id="display-total">Rp
                                        {{ number_format($pengajuan->total_biaya, 0, ',', '.') }}</h3>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow mb-3">
                                    <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('pengajuan.index') }}"
                                    class="btn btn-light w-100 py-2 rounded-pill text-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('item-container');
            const addButton = document.getElementById('add-item');
            const displayTotal = document.getElementById('display-total');

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            }

            function calculateTotal() {
                let total = 0;
                document.querySelectorAll('.item-row').forEach(row => {
                    const qty = row.querySelector('.input-qty').value || 0;
                    const harga = row.querySelector('.input-harga').value || 0;
                    total += (parseInt(qty) * parseInt(harga));
                });
                displayTotal.innerText = formatRupiah(total);
            }

            container.addEventListener('input', calculateTotal);

            addButton.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'item-row animate__animated animate__zoomIn';
                newRow.innerHTML = `
                <button type="button" class="btn btn-danger btn-remove"><i class="fa-solid fa-xmark"></i></button>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Nama Barang</label><input type="text" name="nama_barang[]" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label small fw-bold text-secondary">Jumlah</label><input type="number" name="jumlah[]" class="form-control input-qty" value="1" min="1" required></div>
                    <div class="col-md-3"><label class="form-label small fw-bold text-secondary">Harga Satuan</label><input type="number" name="harga_satuan[]" class="form-control input-harga" required></div>
                    <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Keterangan</label><textarea name="keterangan[]" class="form-control" rows="2"></textarea></div>
                    <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Spesifikasi</label><textarea name="spesifikasi[]" class="form-control" rows="2"></textarea></div>
                </div>`;
                container.appendChild(newRow);
                calculateTotal();
            });

            container.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove')) {
                    e.target.closest('.item-row').remove();
                    calculateTotal();
                }
            });
        });
    </script>
@endsection
