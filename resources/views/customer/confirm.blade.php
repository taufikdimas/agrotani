@empty($customer)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan</h5>
                    Data customer yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/customer') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/customer/' . $customer->customer_id . '/delete') }}" method="POST" id="form-delete-customer">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Customer</h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi</h5>
                        Apakah Anda yakin ingin menghapus data customer berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama Customer:</th>
                            <td class="col-9">{{ $customer->nama_customer }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Perusahaan Customer:</th>
                            <td class="col-9">{{ $customer->perusahaan_customer }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">No HP Customer:</th>
                            <td class="col-9">{{ $customer->no_hp_customer }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Hutang Customer:</th>
                            <td class="col-9">Rp {{ number_format($customer->hutang_customer, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
@endif
