@extends('layouts.app')

@section('content')
    <style>
        .form-section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #4e73df;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: block;
            border-left: 4px solid #4e73df;
            padding-left: 10px;
        }

        .input-group-custom {
            background: #f8f9fa;
            border: 2px solid #f1f3f5;
            border-radius: 12px;
            transition: 0.3s;
        }

        .input-group-custom:focus-within {
            border-color: #4e73df;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
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
    </style>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('barang.index') }}" class="btn btn-white shadow-sm rounded-circle me-3">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h3 class="fw-bold mb-0">Registrasi Barang Baru</h3>
                        <p class="text-muted mb-0">Sistem akan meng-generate nomor inventaris secara otomatis.</p>
                    </div>
                </div>

                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                                <span class="form-section-title">INFORMASI DASAR</span>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">NAMA BARANG</label>
                                    <div class="input-group-custom">
                                        <input type="text" name="nama_barang" placeholder="Contoh: Laptop MacBook Pro"
                                            required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="small fw-bold mb-2">TANGGAL PEROLEHAN</label>
                                        <div class="input-group-custom">
                                            <input type="date" name="tanggal_perolehan" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold mb-2">HARGA PEROLEHAN (Rp)</label>
                                        <div class="input-group-custom">
                                            <input type="number" name="harga_barang" placeholder="15000000" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">KONDISI AWAL</label>
                                    <div class="input-group-custom">
                                        <select name="kondisi" required>
                                            <option value="Baik">Baik (Normal)</option>
                                            <option value="Rusak Ringan">Rusak Ringan</option>
                                            <option value="Rusak Berat">Rusak Berat</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="small fw-bold mb-2">KETERANGAN TAMBAHAN (OPTIONAL)</label>
                                    <div class="input-group-custom">
                                        <textarea name="keterangan" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                                <span class="form-section-title">KLASIFIKASI ASET</span>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">JENJANG</label>
                                    <div class="input-group-custom">
                                        <select name="jenjang_id" required>
                                            <option value="">Pilih Unit...</option>
                                            @foreach ($jenjangs as $j)
                                                <option value="{{ $j->id }}">{{ $j->nama_jenjang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">KODE BARANG (KATEGORI)</label>
                                    <div class="input-group-custom">
                                        <select name="kategori_id" required>
                                            <option value="">Pilih Kode Barang...</option>
                                            @foreach ($kategoris as $k)
                                                <option value="{{ $k->id }}">{{ $k->kode_kategori }} -
                                                    {{ $k->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">LOKASI GEDUNG</label>
                                    <div class="input-group-custom">
                                        <select name="gedung_id" id="gedung_id" required>
                                            <option value="">Pilih Lokasi...</option>
                                            @foreach ($gedungs as $g)
                                                <option value="{{ $g->id }}">{{ $g->nama_gedung }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-2">RUANGAN</label>
                                    <div class="input-group-custom">
                                        <select name="ruang_id" id="ruangan_id" required disabled>
                                            <option value="">Pilih Gedung Terlebih Dahulu...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="small fw-bold mb-2">SUMBER DANA</label>
                                    <div class="input-group-custom">
                                        <select name="sumber_dana_id" required>
                                            <option value="">Pilih Sumber Dana...</option>
                                            @foreach ($sumberDanas as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama_sumber }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <span class="form-section-title">FOTO BARANG (OPTIONAL)</span>
                                <div class="input-group-custom">
                                    <input type="file" name="foto_barang" accept="image/*">
                                </div>
                                <small class="text-muted mt-2">Maksimal 2MB (Format: JPG, PNG)</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-lg mt-4">
                                <i class="fa-solid fa-save me-2"></i> Simpan ke Inventaris
                            </button>
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
            const gedungSelect = document.getElementById('gedung_id');
            const ruanganSelect = document.getElementById('ruangan_id');
    
            gedungSelect.addEventListener('change', function() {
                const gedungId = this.value;
                
                // Reset Dropdown Ruangan
                ruanganSelect.innerHTML = '<option value="">Sedang memuat...</option>';
                ruanganSelect.disabled = true;
    
                if (gedungId) {
                    // Ambil data ruangan via Fetch API
                    fetch(`/api/ruangan/${gedungId}`)
                        .then(response => response.json())
                        .then(data => {
                            ruanganSelect.innerHTML = '<option value="">-- Pilih Ruangan --</option>';
                            
                            if(data.length > 0) {
                                data.forEach(ruangan => {
                                    const option = document.createElement('option');
                                    option.value = ruangan.id;
                                    option.textContent = ruangan.nama_ruangan;
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
            });
        });
    </script>
    @endsection