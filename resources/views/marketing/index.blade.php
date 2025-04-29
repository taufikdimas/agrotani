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
        .truncate-text {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
                                    <h4 class="mb-0">{{ $totalMarketing }}</h4>
                                    <p class="mb-0">Total Marketing</p>
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
                                    <h4 class="mb-0">{{ $totalActive }}</h4>
                                    <p class="mb-0">Aktif</p>
                                </div>
                                <div class="avatar me-lg-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-check-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center card-widget-3 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">{{ $totalInactive }}</h4>
                                    <p class="mb-0">Non-Aktif</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-x-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">{{ $totalMarketing }}</h4>
                                    <p class="mb-0">Total Tim</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-group bx-md"></i>
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
                <select class="form-select" id="filter_status" aria-label="Filter by Status">
                    <option selected value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Non-Aktif</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" id="search_marketing" class="form-control" placeholder="Cari Nama Marketing" aria-label="Search Marketing">
            </div>
            <div class="col-md-1">
                <select class="form-select" id="per_page" aria-label="Select number of items">
                    <option selected value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-md-3 "> 
                <button type="button" class="btn btn-primary w-80" id="createMarketingBtn" onclick="modalAction('{{ url('marketing/create') }}')">
                    <i class="bx bx-plus me-2"></i> Tambah Marketing
                </button>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Marketing</th>
                    <th>Kontak</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="table-marketing">
                @foreach ($marketing as $person)
                    <tr>
                        <td>{{ $person->nama_marketing }}</td>
                        <td>{{ $person->kontak_marketing }}</td>
                        <td class="truncate-text" title="{{ $person->deskripsi }}">
                            {{ $person->deskripsi ?: '-' }}
                        </td>
                        <td>
                            <span class="badge bg-label-{{ $person->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($person->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('marketing/' . $person->marketing_id . '/edit') }}')">
                                        <i class="icon-base bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('marketing/' . $person->marketing_id . '/delete') }}')">
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
        function loadMarketing() {
            let filter_status = $('#filter_status').val();
            let search_marketing = $('#search_marketing').val();
            let per_page = $('#per_page').val();

            $.ajax({
                url: "{{ route('marketing.list') }}",
                data: {
                    filter_status: filter_status,
                    search_marketing: search_marketing,
                    per_page: per_page
                },
                success: function(response) {
                    let html = '';

                    response.marketing.forEach(function(item) {
                        html += `
                            <tr>
                                <td>${item.nama_marketing}</td>
                                <td>${item.kontak_marketing}</td>
                                <td class="truncate-text" title="${item.deskripsi || ''}">
                                    ${item.deskripsi ? item.deskripsi.substring(0, 30) + (item.deskripsi.length > 30 ? '...' : '') : '-'}
                                </td>
                                <td>
                                    <span class="badge bg-label-${item.status == 'aktif' ? 'success' : 'danger'}">
                                        ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('marketing') }}/${item.marketing_id}/edit')">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('marketing') }}/${item.marketing_id}/delete')">
                                                <i class="bx bx-trash me-1"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    $('#table-marketing').html(html);
                    $('#pagination-marketing').html(response.pagination); 
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal memuat data marketing.');
                }
            });
        }

        loadMarketing();

        $('#filter_status, #per_page').on('change', function() {
            loadMarketing();
        });

        $('#search_marketing').on('keyup', function() {
            loadMarketing();
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