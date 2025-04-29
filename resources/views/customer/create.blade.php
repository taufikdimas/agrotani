<form action="{{ url('/customer') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-customer" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="text" name="nama_customer" id="nama_customer" class="form-control" required>
                    <small id="error-nama_customer" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Perusahaan Customer</label>
                    <input type="text" name="perusahaan_customer" id="perusahaan_customer" class="form-control">
                    <small id="error-perusahaan_customer" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Alamat Customer</label>
                    <textarea name="alamat_customer" id="alamat_customer" class="form-control"></textarea>
                    <small id="error-alamat_customer" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>No HP Customer</label>
                    <input type="text" name="no_hp_customer" id="no_hp_customer" class="form-control">
                    <small id="error-no_hp_customer" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Hutang Customer</label>
                    <input type="number" step="0.01" name="hutang_customer" id="hutang_customer" class="form-control">
                    <small id="error-hutang_customer" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
