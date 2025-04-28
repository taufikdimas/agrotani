  <form action="{{ url('/stok') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-produk" class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <button type="button" class="close position-absolute" style="right: 15px; top: 10px; z-index: 10;" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang Masuk/Keluar</h5>
        </div>
        <div class="modal-body">
          
          <div class="form-group">
            <label for="produk_id">Pilih Produk</label>
            <select name="produk_id" class="form-select" required>
              <option value="">-- Pilih Produk --</option>
              @foreach($produk as $produk)
                <option value="{{ $produk->produk_id }}">{{ $produk->nama_produk }} (Stok: {{ $produk->stok }})</option>
              @endforeach
            </select>
            <small id="error-produk_id" class="error-text form-text text-danger"></small>
          </div>

          <div class="form-group">
            <label for="type">Jenis</label>
            <select name="type" class="form-select" required>
              <option value="in">Masuk</option>
              <option value="out">Keluar</option>
            </select>
            <small id="error-type" class="error-text form-text text-danger"></small>
          </div>

          <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required min="1">
            <small id="error-jumlah" class="error-text form-text text-danger"></small>
          </div>

          <div class="form-group">
            <label for="deskripsi">Keterangan (Opsional)</label>
            <textarea name="deskripsi" class="form-control"></textarea>
            <small id="error-deskripsi" class="error-text form-text text-danger"></small>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </form>
