@extends('layouts.app')

@section('content')
    <style>
        .form-section {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        .item-row {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .item-row:hover {
            border-color: #0d6efd;
            background: #fff;
        }

        .btn-remove {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .total-card {
            background: linear-gradient(45deg, #0d6efd, #0043a8);
            color: white;
            border-radius: 15px;
            padding: 20px;
        }
         @media (max-width: 499px){
            .back{
                width: 100%;
            }
         }
         
        /* Efek hover untuk tombol tambah item baru */
        #add-item:hover {
            background: linear-gradient(45deg, #0d6efd, #0043a8) !important;
            transform: translateY(-2px);
            border: none !important;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.15);
        }
    </style>

    <div class="container-fluid px-4">
        <div class="mb-4 d-flex flex-wrap align-items-center justify-content-between">
            <div>
                <h3 class="fw-bold text-dark mb-1">Buat Pengajuan Baru</h3>
                <p class="text-muted small">Silakan isi daftar barang yang ingin diajukan.</p>
            </div>
            <a href="{{ route('pengajuan.index') }}" class="btn back btn-outline-secondary rounded-pill px-4">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

         @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-xmark me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('pengajuan.store') }}" method="POST" id="pengajuanForm">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-section">
                        <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center mb-4">
                            <h5 class="fw-bold mb-0"><i class="fa-solid fa-list-check me-2 text-primary"></i> Daftar Barang
                            </h5>
                        </div>

                        <div id="item-container">
                            <div class="item-row">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Nama Barang</label>
                                        <input type="text" name="nama_barang[]" class="form-control"
                                            placeholder="Contoh: PC Desktop Core i7" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold">Jumlah</label>
                                        <input type="number" name="jumlah[]" class="form-control input-qty" min="1"
                                            value="1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold">Harga Satuan (Rp)</label>
                                        <input type="number" name="harga_satuan[]" class="form-control input-harga"
                                            placeholder="0" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Keterangan</label>
                                        <textarea name="keterangan[]" class="form-control" rows="2" required placeholder="Alasan kebutuhan..."></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Spesifikasi (Opsional)</label>
                                        <textarea name="spesifikasi[]" class="form-control" rows="2" placeholder="RAM 16GB, SSD 512GB..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <button type="button" class="btn btn-outline-primary w-100 py-3 fw-bold rounded-3" id="add-item" style="border: 2px dashed #0d6efd; background-color: #f8fbff; transition: all 0.3s ease;">
                                <i class="fa-solid fa-plus me-2"></i> Tambah Item Baru
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 my-2 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Pilih Jenjang</label>
                                <select name="jenjang_id"
                                    class="form-select form-select-lg rounded-3 @error('jenjang_id') is-invalid @enderror">
                                    @foreach ($jenjangs as $jenjang)
                                        <option value="{{ $jenjang->id }}"
                                            {{ old('jenjang_id') == $jenjang->id ? 'selected' : '' }}>
                                            {{ $jenjang->nama_jenjang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenjang_id')
                                    <div class="invalid-feedback d-block mt-1">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="total-card mb-4">
                                <p class="small mb-1 opacity-75">Estimasi Total Biaya</p>
                                <h2 class="fw-bold mb-0" id="display-total">Rp 0</h2>
                            </div>

                            <div class="alert alert-info border-0 small mb-4">
                                <i class="fa-solid fa-circle-info me-2"></i>
                                Pastikan data sudah benar sebelum dikirim ke Admin.
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">
                                <i class="fa-solid fa-paper-plane me-2"></i> Kirim Pengajuan
                            </button>
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

            // Fungsi Format Rupiah
            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            }

            // Fungsi Hitung Total
            function calculateTotal() {
                let total = 0;
                const rows = document.querySelectorAll('.item-row');

                rows.forEach(row => {
                    const qty = row.querySelector('.input-qty').value || 0;
                    const harga = row.querySelector('.input-harga').value || 0;
                    total += (parseInt(qty) * parseInt(harga));
                });

                displayTotal.innerText = formatRupiah(total);
            }

            // Event listener untuk input harga dan qty (Delegation)
            container.addEventListener('input', function(e) {
                if (e.target.classList.contains('input-qty') || e.target.classList.contains(
                        'input-harga')) {
                    calculateTotal();
                }
            });

            // Tambah Baris Baru
            addButton.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'item-row animate__animated animate__fadeInUp';
                newRow.innerHTML = `
                <button type="button" class="btn btn-danger btn-remove shadow-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nama Barang</label>
                        <input type="text" name="nama_barang[]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Jumlah</label>
                        <input type="number" name="jumlah[]" class="form-control input-qty" min="1" value="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Harga Satuan (Rp)</label>
                        <input type="number" name="harga_satuan[]" class="form-control input-harga" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Keterangan</label>
                        <textarea name="keterangan[]" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Spesifikasi (Opsional)</label>
                        <textarea name="spesifikasi[]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            `;
                container.appendChild(newRow);
                
                // Fokus otomatis ke input nama barang yang baru ditambahkan
                newRow.querySelector('input[name="nama_barang[]"]').focus();
            });

            // Hapus Baris
            container.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove')) {
                    const row = e.target.closest('.item-row');
                    row.classList.add('animate__animated', 'animate__fadeOutDown');
                    setTimeout(() => {
                        row.remove();
                        calculateTotal();
                    }, 500);
                }
            });
        });
    </script>
@endsection