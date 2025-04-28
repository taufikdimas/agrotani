@extends('layouts.app')

@section('content')
{{-- @dd($historyTransaksi->toArray()); --}}
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
                                    <h4 class="mb-0">{{ $totalTransaksi }}</h4>
                                    <p class="mb-0">Total Transaksi</p>
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
                                    <h4 class="mb-0">Rp{{ number_format($totalPembelian, 0, ',', '.') }}</h4>
                                    <p class="mb-0">Total Pembelian</p>
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
                                    <h4 class="mb-0">Rp{{ number_format($totalBelumLunas, 0, ',', '.') }}</h4>
                                    <p class="mb-0">Transaksi Belum Lunas</p>
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
                                    <h4 class="mb-0">Rp{{ number_format($totalLunas, 0, ',', '.') }}</h4>
                                    <p class="mb-0">Transaksi Lunas</p>
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
            <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0 g-md-6">
                <div class="col-md-12 customer_debt">
                    <select class="form-select" aria-label="Filter by Debt">
                        <option selected>Status Pembayaran</option>
                        <option value="Lunas">Lunas</option>
                        <option value="Belum Lunas">Belum Lunas</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row align-items-center gy-3 p-6">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Cari Kode Transaksi" aria-label="Search Transaction">
            </div>
            <div class="col-md-8 d-flex justify-content-end align-items-center gap-2">
                <select class="form-select w-auto" aria-label="Select number of items">
                    <option selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <div class="btn-group">
                <button type="button" class="btn btn-outline-primary">
                    <span class="icon-base bx bx-export icon-sm me-2"></span>Export
                </button>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal Penjualan</th>
                        <th>Nama Customer</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($historyTransaksi as $data)
                        <tr>
                            <td>{{ $data->kode_transaksi }}</td>
                            <td>{{ $data->tanggal_transaksi }}</td>
                            <td>{{ $data->nama_customer ?? '-' }}</td>
                            <td>{{ number_format($data->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if (strtolower($data->status_pembayaran) == 'lunas')
                                    <span class="badge bg-label-success">Lunas</span>
                                @else
                                    <span class="badge bg-label-danger">Belum Lunas</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ url('penjualan/' . $data->penjualan_id . '/edit') }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                       <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('{{ url('penjualan/' . $data->penjualan_id . '/delete') }}')">
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