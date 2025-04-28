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
        .text-success {
            color: #28c76f !important;
        }
        .text-danger {
            color: #ea5455 !important;
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
                                    <h4 class="mb-0">{{ $totalStok}}</h4>
                                    <p class="mb-0">Total Transaksi</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-transfer bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center card-widget-2 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">{{ $stokIn }}</h4>
                                    <p class="mb-0">Stok Masuk</p>
                                </div>
                                <div class="avatar me-lg-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-down-arrow-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center card-widget-3 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">{{ $stokOut }}</h4>
                                    <p class="mb-0">Stok Keluar</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-up-arrow-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">{{ $totalBarang }}</h4>
                                    <p class="mb-0">Total Barang</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-package bx-md"></i>
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
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <!-- Filter Kategori -->
            <div class="flex-fill">
                <select class="form-select" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    <option value="in">Stok Masuk</option>
                    <option value="out">Stok Keluar</option>
                </select>
            </div>

            <!-- Filter Produk -->
            <div class="flex-fill">
                <select class="form-select" id="filterProduk">
                    <option value="">Semua Produk</option>
                    @foreach($produk as $produk)
                        <option value="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Tanggal -->
            <div class="flex-fill">
                <input type="date" class="form-control" id="filterTanggal" value="{{ date('Y-m-d') }}">
            </div>

            <!-- Search -->
            <div class="flex-fill">
                <input type="text" class="form-control" id="filterSearch" placeholder="Cari Deskripsi">
            </div>

            <!-- Page Limit -->
            <div>
                <select class="form-select" id="filterPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <!-- Tombol Tambah -->
            <div>
                <button type="button" class="btn btn-primary" id="createStokBtn" onclick="modalAction('{{ url('stok/create') }}')">
                    <i class="bx bx-plus"></i> Tambah Stok
                </button>
            </div>
        </div>
    </div>
    <div class="table-responsive text-nowrap mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Input</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="stokTableBody">
                 @foreach ($stok as $stok)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="bx bx-package"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $stok->nama_produk ?? '-' }}</h6>
                                        <small class="text-muted">Kode: {{ $stok->kode_produk ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($stok->kategori == 'in')
                                    <span class="badge bg-label-success">Masuk</span>
                                @else
                                    <span class="badge bg-label-danger">Keluar</span>
                                @endif
                            </td>
                            <td>
                                @if ($stok->kategori == 'in')
                                    <span class="text-success">+{{ $stok->jumlah }}</span>
                                @else
                                    <span class="text-danger">-{{ $stok->jumlah }}</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($stok->deskripsi ?? '-', 50) }}</td>
                            <td>{{ \Carbon\Carbon::parse($stok->created_at)->format('d/m/Y H:i') }}</td>
                            {{-- <td>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('stok/' . $stok->stok_id . '/delete') }}')">
                                    <i class="icon-base text-danger bx bx-trash me-1"></i>
                                </a>
                            </td> --}}
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


    $(document).ready(function() {
    // Fungsi untuk memuat data stok berdasarkan filter
    function loadStok() {
        $.ajax({
            url: '{{ url('/stok/list') }}',
            type: 'GET',
            data: {
                kategori: $('#filterKategori').val(),    // Filter berdasarkan kategori
                nama_produk: $('#filterProduk').val(),     // Filter berdasarkan produk
                date: $('#filterTanggal').val(),         // Filter berdasarkan tanggal
                search: $('#filterSearch').val(),        // Filter berdasarkan search
            },
            success: function(res) {
                let tbody = '';

                if (res.success && res.data.length > 0) {
                    $.each(res.data, function(index, stok) {
                        tbody += `
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded bg-label-secondary">
                                                <i class="bx bx-package"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">${stok.nama_produk ?? '-'}</h6>
                                            <small class="text-muted">Kode: ${stok.kode_produk ?? '-'}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    ${stok.kategori === 'in'
                                        ? '<span class="badge bg-label-success">Masuk</span>'
                                        : '<span class="badge bg-label-danger">Keluar</span>'
                                    }
                                </td>
                                <td>
                                    ${stok.kategori === 'in'
                                        ? '<span class="text-success">+' + stok.jumlah + '</span>'
                                        : '<span class="text-danger">-' + stok.jumlah + '</span>'
                                    }
                                </td>
                                <td>${stok.deskripsi ? stok.deskripsi.substring(0, 50) : '-'}</td>
                                <td>${formatDate(stok.created_at)}</td>
                            </tr>
                        `;
                    });
                } else {
                    tbody = `<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>`;
                }

                $('#stokTableBody').html(tbody);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Format Tanggal
    function formatDate(dateStr) {
        let date = new Date(dateStr);
        if (isNaN(date.getTime())) {  // Mengecek apakah tanggal valid
            return '-';
        }
        return date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    // Mengubah event menjadi trigger hanya saat filter berubah
    $('#filterKategori, #filterProduk, #filterTanggal, #filterSearch').on('change keyup', function() {
        loadStok(); // Panggil loadStok hanya ketika filter berubah
    });
});



    $(document).on('submit', 'form', function(e) {
        $('#myModal').modal('hide');
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
