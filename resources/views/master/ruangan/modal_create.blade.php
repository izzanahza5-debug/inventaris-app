<div class="modal fade" id="editRuanganModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <div class="modal-body p-5 text-center">
                    <div class="bg-primary bg-opacity-10 d-inline-block p-4 rounded-circle mb-4">
                        <i class="fa-solid fa-pen-nib fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold">Edit Ruangan</h4>

                    <form id="editRuanganForm" method="POST" class="text-start mt-4">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">PILIH GEDUNG</label>
                            <select name="gedung_id" id="edit_gedung_id"
                                class="form-select form-select-lg border-0 bg-light rounded-4" required>
                                @foreach ($gedungs as $gedung)
                                    <option value="{{ $gedung->id }}">{{ $gedung->nama_gedung }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">NAMA RUANGAN</label>
                            <input type="text" name="nama_ruangan" id="edit_nama_ruangan"
                                class="form-control form-control-lg border-0 bg-light rounded-4" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-4 shadow py-3">Simpan
                                Perubahan</button>
                            <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none"
                                data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>