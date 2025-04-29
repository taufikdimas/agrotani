<form action="{{ url('/marketing') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-marketing" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close position-absolute" style="right: 15px; top: 10px; z-index: 10;" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Marketing</h5>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Nama Marketing</label>
                    <input type="text" name="nama_marketing" id="nama_marketing" class="form-control" required>
                    <small id="error-nama_marketing" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Kontak Marketing</label>
                    <input type="text" name="kontak_marketing" id="kontak_marketing" class="form-control" required>
                    <small id="error-kontak_marketing" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
