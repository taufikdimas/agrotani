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
                    <form method="POST" action="{{ url('penjualan/'.$penjualan->penjualan_id) }}" class="form-horizontal" id="form-transaksi">
                        @csrf
                        @method('PUT')
                        <!-- Nama Pemesan -->
                        <div class="mb-3">
                            <label for="customerSelect" class="form-label">Nama Pemesan</label>
                            <div class="input-group">
                                <select class="form-select" name="customer_id" id="customerSelect">
                                    @if($penjualan->customer_id)
                                        <option value="{{ $penjualan->customer_id }}" selected>{{ $penjualan->nama_customer }}</option>
                                    @endif
                                </select>
                                <button class="btn btn-outline-primary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#customerModal">
                                    + Customer
                                </button>
                            </div>
                            <small id="error-customer_id" class="error-text form-text text-danger"></small>
                        </div>

                        <!-- Modal Customer -->
                        <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="customerModalLabel">Input Customer Baru</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama_customer" class="form-label">Nama Customer</label>
                                            <input type="text" class="form-control" name="nama_customer" id="nama_customer">
                                        </div>
                                        <div class="mb-3">
                                            <label for="perusahaan_customer" class="form-label">Nama Perusahaan/Outlet</label>
                                            <input type="text" class="form-control" name="perusahaan_customer" id="perusahaan_customer">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_customer" class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control" name="alamat_customer" id="alamat_customer" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_hp_customer" class="form-label">No HP</label>
                                            <input type="text" class="form-control" name="no_hp_customer" id="no_hp_customer">
                                        </div>
                                        <div class="mb-3">
                                            <label for="hutang_customer" class="form-label">Nominal Tagihan Belum Dibayar</label>
                                            <input type="text" class="form-control" name="hutang_customer" id="hutang_customer">
                                        </div>
                                        <button type="button" class="btn btn-primary" id="saveNewCustomer">Simpan Customer</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Customer (Tampil setelah dipilih) -->
                        <div class="card mb-3" id="customerData" style="{{ $penjualan->customer_id ? '' : 'display: none;' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="card-title fw-bold mb-0">Data Customer</h4>
                                    <a class="btn btn-sm btn-outline-primary" href="#" onclick="showSelectCustomer()">Edit</a>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" id="display_id_customer" value="{{ $penjualan->customer_id ?? '' }}">
                                        <p><strong>Nama:</strong> <span id="display_nama_customer">{{ $penjualan->customer->nama_customer ?? '' }}</span></p>
                                        <p><strong>Perusahaan:</strong> <span id="display_perusahaan_customer">{{ $penjualan->customer->perusahaan_customer ?? '' }}</span></p>
                                        <p><strong>No HP:</strong> <span id="display_phone">{{ $penjualan->customer->no_hp_customer ?? '' }}</span></p>
                                        <p><strong>Alamat:</strong> <span id="display_address">{{ $penjualan->customer->alamat_customer ?? '' }}</span></p>
                                        <p><strong>Hutang:</strong> Rp <span id="display_hutang_customer">{{ number_format($penjualan->customer->hutang_customer ?? 0, 0, ',', '.') }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kode Transaksi -->
                        <div class="mb-3">
                            <label for="kode_transaksi" class="form-label">Kode Transaksi</label>
                            <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi" value="{{ $penjualan->kode_transaksi }}" required readonly>
                            @error('kode_transaksi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Transaksi -->
                        <div class="mb-3">
                            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="datetime-local" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->format('Y-m-d\TH:i') }}" required>
                            @error('tanggal_transaksi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="Cash" {{ $penjualan->metode_pembayaran == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="TF" {{ $penjualan->metode_pembayaran == 'TF' ? 'selected' : '' }}>TF</option>
                            </select>
                            @error('metode_pembayaran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Pembayaran -->
                        <div class="mb-3">
                            <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                            <select class="form-select" id="status_pembayaran" name="status_pembayaran" required>
                                <option value="">-- Pilih Status Pembayaran --</option>
                                <option value="Lunas" @if(strcasecmp(trim($penjualan->status_pembayaran), 'Lunas') === 0) selected @endif>Lunas</option>
                                <option value="Belum Lunas" @if(strcasecmp(trim($penjualan->status_pembayaran), 'Belum Lunas') === 0) selected @endif>Belum Lunas</option>
                            </select>
                            @error('status_pembayaran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Order -->
                        <div class="mb-3">
                            <label for="status_order" class="form-label">Status Order</label>
                            <select class="form-select" id="status_order" name="status_order" required>
                                <option value="">-- Pilih Status Order --</option>
                                <option value="Selesai" @if(strcasecmp(trim($penjualan->status_order), 'Selesai') === 0) selected @endif>Selesai</option>
                                <option value="Retur" @if(strcasecmp(trim($penjualan->status_order), 'Retur') === 0) selected @endif>Retur</option>
                            </select>
                            @error('status_order')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Marketing -->
                        <div class="mb-3">
                            <label for="marketing_id">Marketing</label>
                            <select name="marketing_id" class="form-select" required>
                            <option value="">-- Pilih Marketing --</option>
                            @foreach($marketing as $marketing)
                                <option value="{{ $marketing->marketing_id }}">{{ $marketing->nama_marketing }}</option>
                            @endforeach
                            </select>
                            <small id="error-marketing" class="error-text form-text text-danger"></small>
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
                                @foreach($penjualanDetail as $detail)
                                    <tr data-id="{{ $detail->produk_id }}">
                                        <td>{{ $detail->produk->nama_produk }}</td>
                                        <td class="hpp">{{ number_format($detail->produk->hpp, 0, ',', '.') }}</td>
                                        <td class="productPrice">{{ number_format($detail->unit_harga, 0, ',', '.') }}</td>
                                        <td><input type="number" class="form-control quantityInput" value="{{ $detail->jumlah }}" data-price="{{ $detail->unit_harga }}"></td>
                                        <td class="totalPrice">{{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                                        <td><button class="btn btn-danger btn-sm removeProduct">Hapus</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Grand Total</strong></td>
                                    <td id="grandTotal" class="fw-bold">{{ number_format($penjualanDetail->sum('total_harga')), 0, ',', '.' }}</td>
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
                $('#customerSelect').select2({
                    minimumInputLength: 1,
                    placeholder: 'Cari Customer...',
                    ajax: {
                        url: '{{ url("/ajax/customer-list") }}',
                        dataType: 'json',
                        delay: 100,
                        data: function(params) {
                            return { search: params.term };
                        },
                        processResults: function(data) {
                            return { results: data };
                        }
                    },
                    language: {
                        inputTooShort: function() {
                            return "Masukkan minimal 1 karakter";
                        }
                    }
                }).on('select2:select', function(e) {
                    var customerId = $(this).val();
                    $.ajax({
                        url: '{{ url("/ajax/customer-detail") }}/' + customerId,
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                $("#display_id_customer").val(data.customer_id);
                                $("#display_nama_customer").text(data.nama_customer);
                                $("#display_perusahaan_customer").text(data.perusahaan_customer);
                                $("#display_phone").text(data.no_hp_customer);
                                $("#display_address").text(data.alamat_customer);
                                $("#display_hutang_customer").text(data.hutang_customer);

                                $("#customerData").show();
                            } else {
                                alert('Data customer tidak ditemukan.');
                            }
                        },
                        error: function(xhr) {
                            alert('Gagal memuat data customer. Silakan coba lagi.');
                            console.error(xhr.responseText);
                        }
                    });
                });

                @if($penjualan->customer_id)
                    $("#customerData").show();
                @endif

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
                function removeProductFromDetailPenjualan(productId) {
                    var penjualanId = "{{ $penjualan->penjualan_id }}";
                    $.ajax({
                        url: `{{ url('/penjualan/edit') }}/${penjualanId}/detail/delete`,
                        method: 'POST',
                        data: {
                            produk_id: productId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Produk berhasil dihapus dari detail_penjualan:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Gagal menghapus dari detail_penjualan:', error);
                        }
                    });
                }

                $(document).ready(function() {
                    $('#status_pembayaran').on('change', function() {
                        var statusPembayaran = $(this).val();
                        if (statusPembayaran === 'Lunas') {
                            $('#cicilanSection').hide();  // Menyembunyikan bagian cicilan
                        } else {
                            $('#cicilanSection').show();  // Menampilkan bagian cicilan
                        }
                    });
                });


                // Simpan Customer Baru
                $('#saveNewCustomer').click(function() {
                    var namaCustomer = $('#nama_customer').val();
                    var perusahaanCustomer = $('#perusahaan_customer').val();
                    var alamatCustomer = $('#alamat_customer').val();
                    var noHpCustomer = $('#no_hp_customer').val();
                    var hutangCustomer = $('#hutang_customer').val();

                    $.ajax({
                        url: '{{ route('customer.store') }}',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            nama_customer: namaCustomer,
                            perusahaan_customer: perusahaanCustomer,
                            alamat_customer: alamatCustomer,
                            no_hp_customer: noHpCustomer,
                            hutang_customer: hutangCustomer,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            var newOption = new Option(data.nama_customer, data.id, true, true);
                            $('#customerSelect').append(newOption).trigger('change');

                            $("#display_id_customer").val(data.customer_id);
                            $("#display_nama_customer").text(data.nama_customer);
                            $("#display_perusahaan_customer").text(data.perusahaan_customer);
                            $("#display_phone").text(data.no_hp_customer);
                            $("#display_address").text(data.alamat_customer);
                            $("#display_hutang_customer").text(data.hutang_customer);

                            $('#customerModal').modal('hide');
                            $("#customerData").show();

                            $('#nama_customer').val('');
                            $('#perusahaan_customer').val('');
                            $('#alamat_customer').val('');
                            $('#no_hp_customer').val('');
                            $('#hutang_customer').val('');
                        },
                        error: function(xhr) {
                            alert('Gagal menyimpan customer! Silakan cek data atau server.');
                            console.error(xhr.responseText);
                        }
                    });
                });
            });

            function showSelectCustomer() {
                $('#customerData').hide();
                $('#customerSelect').val(null).trigger('change');
            }

            // Tangani klik pada tombol Kembali
            $('#btn-kembali').click(function(e) {
                e.preventDefault();
                var penjualanId = "{{ $penjualan->penjualan_id }}";

                Swal.fire({
                    title: 'Peringatan',
                    text: "Apakah anda yakin akan menghapus transaksi ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/penjualan/' + penjualanId + '/delete',
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status === true) {
                                    window.location.href = "{{ url('penjualan') }}";
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan: ' + error,
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $('#form-transaksi').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = new FormData(form[0]);
                formData.append('_method', 'PUT');

                // Ambil produk
                var products = [];
                $('#produkBody tr').each(function() {
                    var productId = $(this).data('id');
                    var quantity = $(this).find('.quantityInput').val();
                    var harga = $(this).find('.productPrice').text().replace(/[^0-9]/g, '');
                    var total = $(this).find('.totalPrice').text().replace(/[^0-9]/g, '');
                    var hpp = $(this).find('.hpp').text().replace(/[^0-9]/g, '');

                    products.push({
                        produk_id: productId,
                        jumlah: quantity,
                        unit_harga: harga,
                        total_harga: total,
                        hpp: hpp
                    });
                });

                console.log(products);

                formData.append('products', JSON.stringify(products));
                formData.append('grand_total', $('#grandTotal').text().replace(/[^0-9]/g, ''));

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
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/penjualan';
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message || 'Data gagal diubah.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan saat update data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        </script>
    @endpush