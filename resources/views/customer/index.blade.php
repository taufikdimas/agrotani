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
                                    <h4 class="mb-0">{{ $totalCustomers }}</h4>
                                    <p class="mb-0">Total Customer</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-user bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center card-widget-2 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">Rp{{ number_format($totalHutang, 2, ',', '.') }}</h4>
                                    <p class="mb-0">Total Hutang</p>
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
                                    <h4 class="mb-0">{{ $customerHutang }}</h4>
                                    <p class="mb-0">Total Customer Hutang</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-error-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">{{ $customerLunas }}</h4>
                                    <p class="mb-0">Total Customer Lunas</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-check-circle bx-md"></i>
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
            <div class="col-md-3">
                <select id="filter_status_hutang" class="form-select" aria-label="Filter by Debt">
                    <option selected value="">Status Hutang</option>
                    <option value="Hutang">Memiliki Hutang</option>
                    <option value="Lunas">Tidak Ada Hutang</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" id="search_customer" class="form-control" placeholder="Cari Nama Customer" aria-label="Search Customer">
            </div>
            <div class="col-md-2">
                <select id="select_per_page" class="form-select w-100" aria-label="Select number of items">
                    <option selected value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button type="button" class="btn btn-primary w-100" id="createCustomerBtn" onclick="modalAction('{{ url('customer/create') }}')">
                    <i class="bx bx-plus me-1"></i> Tambah Customer
                </button>
            </div>
        </div>
    </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Customer</th>
                        <th>Perusahaan</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Hutang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="list_customer" class="table-border-bottom-0">
                    @foreach ($customer as $customer)
                        <tr>
                            <td>
                                <a href="{{ url('customer/' . $customer->customer_id . '/history') }}">
                                {{ $customer->nama_customer }}
                            </a>

                            </td>
                            <td>{{ $customer->perusahaan_customer ?? '-' }}</td>
                            <td>{{ $customer->alamat_customer ?? '-' }}</td>
                            <td>{{ $customer->no_hp_customer ?? '-' }}</td>
                            <td>Rp{{ number_format($customer->hutang_customer, 2, ',', '.') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('customer/' . $customer->customer_id . '/edit') }}')">
                                            <i class="icon-base bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('customer/' . $customer->customer_id . '/delete') }}')">
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

    $(document).ready(function() {
        function loadCustomers() {
            $.ajax({
                url: "{{ url('/customer/list') }}",
                method: "GET",
                data: {
                    status_hutang: $('#filter_status_hutang').val(),
                    search_customer: $('#search_customer').val(),
                    per_page: $('#select_per_page').val()
                },
                success: function(res) {
                    let html = '';
                    if (res.success && res.data.data.length > 0) {
                        $.each(res.data.data, function(index, customer) {
                            html += `
                                <tr>
                                    <td>
                                        <a href="${baseUrl}/customer/${customer.customer_id}/history">
                                            ${customer.nama_customer}
                                        </a>
                                    </td>
                                    <td>${customer.perusahaan_customer ?? '-'}</td>
                                    <td>${customer.alamat_customer ?? '-'}</td>
                                    <td>${customer.no_hp_customer ?? '-'}</td>
                                    <td>Rp${parseFloat(customer.hutang_customer).toLocaleString('id-ID', {minimumFractionDigits: 2})}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('${baseUrl}/customer/${customer.customer_id}/edit')">
                                                    <i class="icon-base bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('${baseUrl}/customer/${customer.customer_id}/delete')">
                                                    <i class="icon-base bx bx-trash me-1"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            `;

                        });
                    } else {
                        html = <tr><td colspan="6" class="text-center">Tidak ada data ditemukan</td></tr>;
                    }

                    $('#list_customer').html(html);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        // Panggil pertama kali
        loadCustomers();

        // Event change filter dan search
        $('#filter_status_hutang, #select_per_page').on('change', function() {
            loadCustomers();
        });

        $('#search_customer').on('keyup', function() {
            loadCustomers();
        });
    });

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