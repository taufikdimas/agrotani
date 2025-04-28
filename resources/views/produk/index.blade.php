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
                                    <h4 class="mb-0">{{ $totalProduk }}</h4>
                                    <p class="mb-0">Total Produk</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-package bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center card-widget-2 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">{{ $stokHabis }}</h4>
                                    <p class="mb-0">Stok Habis</p>
                                </div>
                                <div class="avatar me-lg-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-error bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center card-widget-3 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">{{ $stokRendah }}</h4>
                                    <p class="mb-0">Stok Rendah</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-alarm bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Rp{{ number_format($nilaiInventory, 0, ',', '.') }}</h4>
                                    <p class="mb-0">Nilai Inventori</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-dollar bx-md"></i>
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
    <div class="card-header border-bottom">
        <h5 class="card-title">Filter</h5>
        <div class="row align-items-center g-3 mt-3">
            <div class="col-md-2">
                <select class="form-select" id="filter_stok" aria-label="Filter by Stock Status">
                    <option selected>Status Stok</option>
                    <option value="in_stock">Stok Tersedia</option>
                    <option value="low_stock">Stok Rendah</option>
                    <option value="out_of_stock">Stok Habis</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filter_kategori" aria-label="Filter by Category">
                    <option selected>Kategori Produk</option>
                    {{-- @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach --}}
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" id="search_produk" class="form-control" placeholder="Cari Nama Produk" aria-label="Search Product">
            </div>
            <div class="col-md-1">
                <select class="form-select" id="per_page" aria-label="Select number of items">
                    <option selected value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-md-2 text-end">
                <button type="button" class="btn btn-primary w-100" id="createProductBtn" onclick="modalAction('{{ url('produk/create') }}')">
                    <i class="bx bx-plus me-1"></i> Tambah Produk
                </button>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap mt-3">
        <table class="table">
<thead>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Produk</th>
                        <th>HPP</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status Stok</th>
                        <th>Minimal Stok</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($produk as $product)
                        <tr>
                            <td>{{ $product->kode_produk }}</td>
                            <td>{{ $product->nama_produk }}</td>
                            <td>Rp{{ number_format($product->hpp, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->stok }}</td>
                            <td>
                                @if($product->stok == 0)
                                    <span class="badge bg-label-danger">Habis</span>
                                @elseif($product->stok <= $product->min_stok)
                                    <span class="badge bg-label-warning">Rendah</span>
                                @else
                                    <span class="badge bg-label-success">Tersedia</span>
                                @endif
                            </td>
                            <td>{{ $product->min_stok }}</td>
                            <td>{{ Str::limit($product->deskripsi, 50) }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('produk/' . $product->produk_id . '/edit') }}')">
                                            <i class="icon-base bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('produk/' . $product->produk_id . '/delete') }}')">
                                            <i class="icon-base bx bx-trash me-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true">
</div>

@endsection

@push('scripts')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    
    $(document).on('submit', 'form', function(e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let method = form.attr('method');
        let data = new FormData(this);

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
</script>
@endpush

