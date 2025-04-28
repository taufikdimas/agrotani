<form action="{{ url('/customer/' . $customer->customer_id) }}" method="POST" id="form-edit-customer">
    @csrf
    @method('PUT')
    <div id="modal-edit-customer" class="modal-dialog modal-lg" role="document">
        <input type="hidden" name="customer_id" id="edit_customer_id">
        <div class="modal-content">
            <button type="button" class="close position-absolute" style="right: 15px; top: 10px; z-index: 10;" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            
            <div class="modal-header">
                <h5 class="modal-title">Edit Customer</h5>
            </div>
            
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="text" name="nama_customer" id="edit_nama_customer" class="form-control" value="{{ $customer->nama_customer }}" required>
                    <small id="error-edit_nama_customer" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Perusahaan Customer</label>
                    <input type="text" name="perusahaan_customer" id="edit_perusahaan_customer" class="form-control" value="{{ $customer->perusahaan_customer }}">
                    <small id="error-edit_perusahaan_customer" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Alamat Customer</label>
                    <textarea name="alamat_customer" id="edit_alamat_customer" class="form-control">{{ $customer->alamat_customer }}</textarea>
                    <small id="error-edit_alamat_customer" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>No HP Customer</label>
                    <input type="text" name="no_hp_customer" id="edit_no_hp_customer" class="form-control" value="{{ $customer->no_hp_customer }}">
                    <small id="error-edit_no_hp_customer" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Hutang Customer</label>
                    <input type="number" name="hutang_customer" id="edit_hutang_customer" class="form-control" value="{{ $customer->hutang_customer }}" required>
                    <small id="error-edit_hutang_customer" class="error-text form-text text-danger"></small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>
