@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <style>
        .avatar {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar-initial {
            display: inline-flex;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .bg-label-secondary {
            background-color: #f1f3f5;
        }
        .text-heading {
            color: #4b4b4b;
        }
        .card-widget-separator-wrapper {
            padding: 1.5rem;
        }
        .card-widget-separator {
            padding: 0;
        }
        .border-end {
            border-right: 1px solid #e0e0e0 !important;
        }
        hr {
            border-color: #e0e0e0;
        }
    </style>

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center card-widget-1 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">{{ $totalPiutang }}</h4>
                                    <p class="mb-0">Total Piutang</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-credit-card bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center card-widget-2 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</h4>
                                    <p class="mb-0">Total Tagihan</p>
                                </div>
                                <div class="avatar me-lg-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-money bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center card-widget-3 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">Rp {{ number_format($totalTertagih, 0, ',', '.') }}</h4>
                                    <p class="mb-0">Total Tertagih</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-check-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Rp {{ number_format($sisaPiutang, 0, ',', '.') }}</h4>
                                    <p class="mb-0">Sisa Piutang</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-error bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div> 
        </div>
    </div> 

    <div class="card mt-4">
        <div class="card-header border-bottom bg-white">
            <h5 class="card-title">Filter</h5>
            <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0 g-md-6">
                <div class="col-md-4 product_status">
                    <select class="form-select" aria-label="Filter by Status">
                        <option selected>Status Piutang</option>
                        <option value="Lunas">Lunas</option>
                        <option value="Belum Lunas">Belum Lunas</option>
                    </select>
                </div>
                <div class="col-md-4 product_date">
                    <input type="date" class="form-control" aria-label="Filter by Date" name="date" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
        </div>
        <div class="row align-items-center g-0 p-6 bg-white sticky-top">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Cari Nama/Nomor Piutang" aria-label="Search Product">
            </div>
            <div class="col-md-8 d-flex justify-content-end align-items-center gap-2">
                <select class="form-select w-auto" aria-label="Select number of items">
                    <option selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <a href="{{ url('piutang/create') }}" class="btn btn-primary" id="createPiutangBtn">
                    <span class="icon-base bx bx-plus icon-sm me-2"></span>Tambah Piutang
                </a>
            </div>
        </div>

        <div class="row px-6">
            @foreach($piutangs as $piutang)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-9 d-flex align-items-center gap-2">
                                    <h5 class="card-title mb-0 text-primary"><strong># {{ $loop->iteration }}</strong></h5>
                                    @if (($piutang['tagihan'] - $piutang->cicilanPiutang->sum('nominal_cicilan')) <= 0)
                                        <span class="badge bg-label-success">LUNAS</span>
                                    @else
                                        <span class="badge bg-label-warning">BELUM LUNAS</span>
                                    @endif
                                </div>
                                <div class="col-3">
                                    <div class="d-flex justify-content-end mb-2">
                                        <button type="button"
                                                class="btn btn-outline-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#cicilanModal-{{ $piutang['piutang_id'] }}">
                                            + Tambah Cicilan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <p><strong>Nama:</strong> {{ $piutang['nama'] }}</p>
                                    <p><strong>Tanggal Order:</strong> {{ \Carbon\Carbon::parse($piutang['tanggal_order'])->format('d-m-Y') }}</p>
                                    <p><strong>Total Tagihan:</strong> Rp {{ number_format($piutang['tagihan'], 0, ',', '.') }}</p>
                                    <p><strong>Sisa Tagihan:</strong> 
                                        <span class="{{ ($piutang['tagihan'] - $piutang->cicilanPiutang->sum('nominal_cicilan')) <= 0 ? 'text-success' : 'text-danger' }}">
                                            Rp {{ number_format($piutang['tagihan'] - $piutang->cicilanPiutang->sum('nominal_cicilan'), 0, ',', '.') }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-5">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0" id="cicilanTable-{{ $piutang['piutang_id'] }}">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cicilanBody-{{ $piutang['piutang_id'] }}">
                                                @foreach($piutang['cicilanPiutang'] as $cicilan)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($cicilan['tanggal_cicilan'])->format('d-m-Y') }}</td>
                                                    <td>Rp {{ number_format($cicilan['nominal_cicilan'], 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="1" class="text-start fw-bold">Total Cicilan</td>
                                                    <td id="totalCicilan-{{ $piutang['piutang_id'] }}" class="fw-bold">
                                                        Rp {{ number_format($piutang['cicilanPiutang']->sum('nominal_cicilan'), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga Satuan</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $grandTotal = 0;
                                        @endphp

                                        @foreach($piutang->detailPiutang as $detail)
                                            @php
                                                $grandTotal += $detail['total_harga'];
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm me-2">
                                                            @if ($detail->produk->gambar)
                                                                <img src="{{ asset('storage/' . $detail->produk->gambar) }}" alt="Gambar Produk" class="avatar-img rounded">
                                                            @else
                                                                <span class="avatar-initial rounded bg-label-secondary">
                                                                    <i class="bx bx-package"></i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $detail->produk->nama_produk }}</h6>
                                                            <small class="text-muted">Kode: {{ $detail->produk->kode_produk }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $detail['jumlah'] }}</td>
                                                <td>Rp {{ number_format($detail['unit_harga'], 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($detail['total_harga'], 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-center fw-bold">Grand Total</td>
                                            <td class="fw-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url('piutang/edit/' . $piutang['piutang_id']) }}" class="btn btn-primary">Edit</a>
                            <a href="javascript:void(0);" onclick="modalAction('{{ url('piutang/' . $piutang['piutang_id'] . '/delete') }}')" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>

                <!-- Cicilan Modal -->
                <div class="modal fade" id="cicilanModal-{{ $piutang['piutang_id'] }}" tabindex="-1" aria-labelledby="cicilanModalLabel-{{ $piutang['piutang_id'] }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cicilanModalLabel-{{ $piutang['piutang_id'] }}">Tambah Cicilan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="cicilanForm-{{ $piutang['piutang_id'] }}" class="cicilan-form" method="POST" action="{{ url('piutang/'.$piutang['piutang_id'].'/add-cicilan') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nominal_cicilan" class="form-label">Nominal Cicilan</label>
                                        <input type="number" step="0.01" class="form-control" name="nominal_cicilan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_cicilan" class="form-label">Tanggal Cicilan</label>
                                        <input type="date" class="form-control" name="tanggal_cicilan" required>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Tambah Cicilan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true">
    </div>
@endsection

@push('scripts')
<script>
    // Modal loader
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    // HANYA submit untuk form upload atau form lain
    $(document).on('submit', '.ajax-form', function(e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let method = form.attr('method');
        let data = new FormData(this); // Form upload file

        if ($.fn.validate && form.hasClass('validate')) {
            if (!form.valid()) return false;
        }

        $.ajax({
            url: url,
            type: method,
            data: data,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2100);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message
                    });

                    if (res.msgField) {
                        $('.error-text').text('');
                        $.each(res.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                    }
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            }
        });
    });

    // Submit untuk form cicilan
    $(document).on('submit', '.cicilan-form', function(e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let method = form.attr('method');
        let data = form.serialize(); 
        form.closest('.modal').modal('hide');

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Cicilan berhasil disimpan!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 500);
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan, silakan coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengirim data.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
@endpush