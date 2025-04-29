<form action="{{ url('/produk') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-produk" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Kode Produk</label>
                    <input type="text" name="kode_produk" id="kode_produk" class="form-control" required>
                    <small id="error-kode_produk" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
                    <small id="error-nama_produk" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>HPP</label>
                    <input type="number" name="hpp" id="hpp" class="form-control" required>
                    <small id="error-hpp" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control" required>
                    <small id="error-harga" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Stok Minimum</label>
                    <input type="number" name="min_stok" id="min_stok" class="form-control" required>
                    <small id="error-min_stok" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>