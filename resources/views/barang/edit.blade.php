@extends('layouts.app')

@section('content')
    <style>
        .form-section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0d6efd;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: block;
            border-left: 4px solid #0d6efd;
            padding-left: 10px;
        }

        .input-group-custom {
            background: #f8f9fa;
            border: 2px solid #f1f3f5;
            border-radius: 12px;
            transition: 0.3s;
        }

        .input-group-custom:focus-within {
            border-color: #0d6efd;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }

        .input-group-custom input,
        .input-group-custom select,
        .input-group-custom textarea {
            border: none;
            background: transparent;
            padding: 12px;
            width: 100%;
            outline: none;
        }

        .current-photo-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            border: 3px solid #f1f3f5;
        }
    </style>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('barang.index') }}" class="btn btn-white shadow-sm rounded-circle me-3">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h3 class="fw-bold mb-0">Edit Data Barang</h3>
                        <p class="text-muted mb-0">ID Inventaris: <span
                                class="text-primary fw-bold">{{ $barang->no_inventaris }}</span></p>
                    </div>
                </div>

                <form action="{{ route('barang.update', $barang->nama_barang) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-7">
                            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                                <span class="form-section-title">DETAIL INFORMASI</span>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">NAMA BARANG</label>
                                    <div class="input-group-custom">
                                        <input type="text" name="nama_barang"
                                            value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="small fw-bold mb-2">TANGGAL PEROLEHAN</label>
                                        <div class="input-group-custom">
                                            <input type="date" name="tanggal_perolehan"
                                                value="{{ $barang->tanggal_perolehan->format('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small fw-bold mb-2">HARGA BARANG (Rp)</label>
                                        <div class="input-group-custom">
                                            <input type="number" name="harga_barang" value="{{ $barang->harga_barang }}"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">KONDISI SAAT INI</label>
                                    <div class="input-group-custom">
                                        <select name="kondisi" required>
                                            <option value="Baik" {{ $barang->kondisi == 'Baik' ? 'selected' : '' }}>Baik
                                                (Normal)</option>
                                            <option value="Rusak Ringan"
                                                {{ $barang->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan
                                            </option>
                                            <option value="Rusak Berat"
                                                {{ $barang->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="small fw-bold mb-2">KETERANGAN TAMBAHAN (OPTIONAL)</label>
                                    <div class="input-group-custom">
                                        <textarea name="keterangan" rows="3">{{ old('keterangan', $barang->keterangan) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                                <span class="form-section-title">LOKASI & SUMBER</span>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">LOKASI GEDUNG</label>
                                    <div class="input-group-custom">
                                        <select name="gedung_id" required>
                                            @foreach ($gedungs as $g)
                                                <option value="{{ $g->id }}"
                                                    {{ $barang->gedung_id == $g->id ? 'selected' : '' }}>
                                                    {{ $g->nama_gedung }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">RUANGAN</label>
                                    <div class="input-group-custom">
                                        <select name="ruang_id" id="ruang_id" required>
                                            <option value="">Pilih Ruangan...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="small fw-bold mb-2">SUMBER DANA</label>
                                    <div class="input-group-custom">
                                        <select name="sumber_dana_id" required>
                                            @foreach ($sumberDanas as $s)
                                                <option value="{{ $s->id }}"
                                                    {{ $barang->sumber_dana_id == $s->id ? 'selected' : '' }}>
                                                    {{ $s->nama_sumber }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted italic">*Kategori & Jenjang tidak dapat diubah karena terikat
                                        nomor inventaris.</small>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <span class="form-section-title">FOTO BARANG</span>

                                @if ($barang->foto_barang)
                                    <div class="mb-3 text-center">
                                        <img src="{{ asset('storage/' . $barang->foto_barang) }}"
                                            class="current-photo-preview mb-2 shadow-sm">
                                        <p class="small text-muted">Foto Saat Ini</p>
                                    </div>
                                @endif

                                <div class="input-group-custom">
                                    <input type="file" name="foto_barang" accept="image/*">
                                </div>
                                <small class="text-muted mt-2">Pilih file baru jika ingin mengganti foto (Maks 2MB).</small>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold shadow-lg">
                                    <i class="fa-solid fa-check-double me-2"></i> Perbarui Data
                                </button>
                                <a href="{{ route('barang.index') }}"
                                    class="btn btn-light rounded-pill py-3 fw-bold">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil elemen dari ID yang benar (pastikan nama ID sesuai dengan HTML Anda)
        const gedungSelect = document.querySelector('select[name="gedung_id"]');
        const ruanganSelect = document.getElementById('ruang_id');
        
        // Ambil ID ruangan lama dari database (dari data barang yang sedang diedit)
        const currentRuanganId = "{{ $barang->ruang_id }}";

        // Fungsi untuk mengambil data ruangan
        function loadRuangan(gedungId, selectedRuanganId = null) {
            // Reset Dropdown Ruangan
            ruanganSelect.innerHTML = '<option value="">Sedang memuat...</option>';
            ruanganSelect.disabled = true;

            if (gedungId) {
                fetch(`/api/ruangan/${gedungId}`)
                    .then(response => response.json())
                    .then(data => {
                        ruanganSelect.innerHTML = '<option value="">-- Pilih Ruangan --</option>';
                        
                        if(data.length > 0) {
                            data.forEach(ruangan => {
                                const option = document.createElement('option');
                                option.value = ruangan.id;
                                // Sesuaikan properti nama (nama_ruangan atau nama_ruang)
                                option.textContent = ruangan.nama_ruangan || ruangan.nama_ruang; 
                                
                                // Jika ID ruangan sama dengan ID ruangan barang, set jadi selected
                                if (selectedRuanganId && ruangan.id == selectedRuanganId) {
                                    option.selected = true;
                                }
                                
                                ruanganSelect.appendChild(option);
                            });
                            ruanganSelect.disabled = false;
                        } else {
                            ruanganSelect.innerHTML = '<option value="">Tidak ada ruangan di gedung ini</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        ruanganSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    });
            } else {
                ruanganSelect.innerHTML = '<option value="">Pilih Gedung Terlebih Dahulu...</option>';
                ruanganSelect.disabled = true;
            }
        }

        // 1. Jalankan saat halaman pertama kali dibuka (untuk set nilai awal)
        if (gedungSelect.value) {
            loadRuangan(gedungSelect.value, currentRuanganId);
        }

        // 2. Jalankan saat user mengubah pilihan gedung
        gedungSelect.addEventListener('change', function() {
            loadRuangan(this.value);
        });
    });
</script>
@endsection