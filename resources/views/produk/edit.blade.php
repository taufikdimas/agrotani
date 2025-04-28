<form action="{{ url('/produk/' . $produk->produk_id) }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-edit-produk" class="modal-dialog modal-lg" role="document">
        <input type="hidden" name="produk_id" id="edit_produk_id">
        <div class="modal-content">
            <button type="button" class="close position-absolute" style="right: 15px; top: 10px; z-index: 10;" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
            </div>
            
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Produk</label>
                    <input type="text" name="kode_produk" id="edit_kode_produk" class="form-control" value="{{ $produk->kode_produk }}" required>
                    <small id="error-edit_kode_produk" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" id="edit_nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
                    <small id="error-edit_nama_produk" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="form-control">{{ $produk->deskripsi }}</textarea>
                    <small id="error-edit_deskripsi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>HPP</label>
                    <input type="number" name="hpp" id="edit_hpp" class="form-control" value="{{ intval($produk->hpp) }}" required>
                    <small id="error-edit_hpp" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" id="edit_harga" class="form-control" value="{{ intval($produk->harga) }}" required>
                    <small id="error-edit_harga" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label>Stok Minimum</label>
                    <input type="number" name="min_stok" id="edit_min_stok" class="form-control" value="{{ $produk->min_stok }}" required>
                    <small id="error-edit_min_stok" class="error-text form-text text-danger"></small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>
