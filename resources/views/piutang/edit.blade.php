@extends('layouts.app')

@section('content')
{{-- @dd($marketing->toArray()) --}}
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
            padding: 6px 12px;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da !important;
            border-radius: 0.35rem !important;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }
    </style>

    <div class="row">
        <div class="col-4">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <form method="POST" action="{{ url('piutang/'.$piutang->piutang_id) }}" class="form-horizontal" id="form-piutang">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama', $piutang->nama) }}" required>
                            <small id="error-nama" class="form-text text-danger"></small>
                        </div>

                        <!-- Tanggal Order -->
                        <div class="mb-3">
                            <label for="tanggal_order" class="form-label">Tanggal Order</label>
                            <input type="date" class="form-control" name="tanggal_order" id="tanggal_order" value="{{ old('tanggal_order', \Carbon\Carbon::parse($piutang->tanggal_order)->format('Y-m-d')) }}" required>
                            <small id="error-tanggal_order" class="form-text text-danger"></small>
                        </div>

                        <!-- Tagihan -->
                        <div class="mb-3">
                            <label for="tagihan" class="form-label">Tagihan</label>
                            <input type="number" class="form-control" name="tagihan" id="tagihan" value="{{ old('tagihan', intval($piutang->tagihan)) }}" min="0" required>
                            <small id="error-tagihan" class="form-text text-danger"></small>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="#" id="btn-kembali" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="d-flex align-items-end gap-2">
                        <!-- Pilih Produk -->
                        <div class="flex-grow-1">
                            <label for="produkSelect" class="form-label">Pilih Produk</label>
                            <select class="form-select" id="produkSelect" name="produk_id">
                                <option value="">Pilih Produk</option>
                                @foreach($produk as $item)
                                    <option value="{{ $item->produk_id }}" data-price="{{ $item->harga }}" data-hpp="{{ $item->hpp }}">{{ $item->nama_produk }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-danger" id="error-product"></small>
                        </div>

                        <!-- Tombol Tambah Produk -->
                        <div>
                            <button type="button" class="btn btn-primary" id="addProduct" style="margin-top: 32px;">Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @csrf

                    <!-- Tabel Produk yang Dibeli -->
                    <div class="table-responsive">
                        <table class="table" id="produkTable">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>HPP</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="produkBody">
                                @foreach($detailPiutang as $detail)
                                    <tr data-id="{{ $detail->produk_id }}">
                                        <td>{{ $detail->produk->nama_produk }}</td>
                                        <td class="hpp">{{ number_format($detail->produk->hpp, 0, ',', '.') }}</td>
                                        <td class="productPrice">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td>
                                            <input type="number" class="form-control quantityInput" value="{{ $detail->jumlah }}" data-price="{{ $detail->harga_satuan }}">
                                        </td>
                                        <td class="totalPrice">{{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm removeProduct">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Grand Total</strong></td>
                                    <td id="grandTotal" class="fw-bold">
                                        {{ number_format($detailPiutang->sum('total_harga'), 0, ',', '.') }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#addProduct').click(function() {
                    var productId = $('#produkSelect').val();
                    var quantity = 1;
                    var exists = false;
                    if (productId) {
                        var selectedOption = $('#produkSelect option:selected');
                        var productName = selectedOption.text();
                        var productPrice = parseInt(selectedOption.data('price'));
                        var hpp = parseInt(selectedOption.data('hpp'));
                        var totalPrice = productPrice * quantity;

                        $('#produkBody tr').each(function() {
                            if ($(this).data('id') == productId) {
                                exists = true;
                                return false;
                            }
                        });

                        if (exists) {
                            alert("Produk sudah ada dalam daftar!");
                            return;
                        }

                        var rowHtml = `<tr data-id="${productId}">
                            <td>${productName}</td>
                            <td class="hpp">${formatRupiah(hpp)}</td>
                            <td class="productPrice">${formatRupiah(productPrice)}</td>
                            <td><input type="number" class="form-control quantityInput" value="${quantity}" data-price="${productPrice}"></td>
                            <td class="totalPrice">${formatRupiah(totalPrice)}</td>
                            <td><button class="btn btn-danger btn-sm removeProduct">Hapus</button></td>
                        </tr>`;

                        $('#produkBody').append(rowHtml);
                        updateTotalPrice();

                        $('#produkSelect').val('');
                    } else {
                        alert("Pilih produk terlebih dahulu.");
                    }
                });

                // Event untuk menghapus produk dari tabel
                $(document).on('click', '.removeProduct', function() {
                    var productId = $(this).closest('tr').data('id');
                    $(this).closest('tr').remove();
                    updateTotalPrice();
                    removeProductFromDetailPenjualan(productId);
                });

                // Event untuk mengubah quantity pada tabel
                $(document).on('input', '.quantityInput', function() {
                    var quantity = $(this).val();
                    var price = $(this).data('price');
                    var total = price * quantity;

                    $(this).closest('tr').find('.totalPrice').text(formatRupiah(total));
                    updateTotalPrice();
                });

                // Fungsi untuk format harga ke Rupiah
                function formatRupiah(amount) {
                    return amount.toLocaleString('id-ID');
                }

                // Fungsi untuk menghitung total harga keseluruhan
                function updateTotalPrice() {
                    var total = 0;
                    $('.totalPrice').each(function() {
                        var value = $(this).text().replace(/\./g, '').replace(',', '');
                        if (!isNaN(value) && value !== '') {
                            total += parseInt(value);
                        }
                    });

                    $('#grandTotal').text(formatRupiah(total));
                }

                // Fungsi untuk menghapus produk dari detail_penjualan di server
                function removeProductFromDetailPiutang(productId) {
                    var piutangId = "{{ $piutang->piutang_id }}";  // Pastikan ini adalah piutang_id yang benar
                    $.ajax({
                        url: `{{ url('/piutang/edit') }}/${piutangId}/detail/delete`,  // Mengubah URL ke endpoint untuk detail piutang
                        method: 'POST',
                        data: {
                            produk_id: productId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Produk berhasil dihapus dari detail_piutang:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Gagal menghapus dari detail_piutang:', error);
                        }
                    });
                }

            });

            // Tangani klik pada tombol Kembali (hapus piutang)
            $('#btn-kembali').click(function(e) {
                e.preventDefault();
                var piutangId = "{{ $piutang->id }}"; // asumsi ID piutang

                Swal.fire({
                    title: 'Peringatan',
                    text: "Apakah Anda yakin akan menghapus piutang ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/piutang/' + piutangId + '/delete',
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status === true) {
                                    window.location.href = "{{ url('piutang') }}";
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'Terjadi kesalahan: ' + xhr.statusText, 'error');
                            }
                        });
                    }
                });
            });


            // Tangani submit form piutang
            $('#form-piutang').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = new FormData(form[0]);
                formData.append('_method', 'PUT');

                // Ambil detail produk piutang
                var products = [];
                $('#produkBody tr').each(function() {
                    var produkId = $(this).data('id');
                    var jumlah = $(this).find('.quantityInput').val();
                    var harga = $(this).find('.productPrice').text().replace(/[^0-9]/g, '');
                    var total = $(this).find('.totalPrice').text().replace(/[^0-9]/g, '');
                    var hpp = $(this).find('.hpp').text().replace(/[^0-9]/g, '');

                    products.push({
                        produk_id: produkId,
                        jumlah: jumlah,
                        unit_harga: harga,
                        total_harga: total,
                        hpp: hpp
                    });
                });

                console.log(products);

                formData.append('products', JSON.stringify(products));
                formData.append('tagihan', $('#grandTotal').text().replace(/[^0-9]/g, ''));
                console.log(formData);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/piutang';
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message || 'Data gagal diubah.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan saat update data.',
                            icon: 'error'
                        });
                    }
                });
            });
        </script>
    @endpush