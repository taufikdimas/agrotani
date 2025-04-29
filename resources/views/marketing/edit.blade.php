<form action="{{ url('/marketing/' . $marketing->marketing_id) }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-edit-marketing" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close position-absolute" style="right: 15px; top: 10px; z-index: 10;" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header">
                <h5 class="modal-title">Edit Marketing</h5>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Nama Marketing</label>
                    <input type="text" name="nama_marketing" id="edit_nama_marketing" class="form-control" value="{{ $marketing->nama_marketing }}" required>
                    <small id="error-edit-nama_marketing" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Kontak Marketing</label>
                    <input type="text" name="kontak_marketing" id="edit_kontak_marketing" class="form-control" value="{{ $marketing->kontak_marketing }}" required>
                    <small id="error-edit-kontak_marketing" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="form-control">{{ $marketing->deskripsi }}</textarea>
                    <small id="error-edit-deskripsi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="edit_status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif" {{ $marketing->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $marketing->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <small id="error-edit-status" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>
