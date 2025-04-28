@extends('layouts.app')

@section('content')
{{-- @dd($customerDebt->toArray()) --}}
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
                    <h4 class="mb-0">{{ $totalCustomer }}</h4>
                    <p class="mb-0">Customer</p>
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
                    <h4 class="mb-0">Rp{{ number_format($totalHutang, 0, ',', '.') }}</h4>
                    <p class="mb-0">Total Hutang Customer</p>
                    </div>
                    <div class="avatar me-lg-4">
                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                        <i class="bx bx-file bx-md"></i>
                    </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-center card-widget-3 border-end pb-4 pb-sm-0">
                    <div>
                    <h4 class="mb-0">{{ $penjualanLunas }}</h4>
                    <p class="mb-0">Penjualan Lunas</p>
                    </div>
                    <div class="avatar me-sm-4">
                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                        <i class="bx bx-check-double bx-md"></i>
                    </span>
                    </div>
                </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <h4 class="mb-0">{{ $penjualanBelumLunas }}</h4>
                    <p class="mb-0">Penjualan Belum Lunas</p>
                    </div>
                    <div class="avatar">
                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                        <i class="bx bx-error-circle bx-md"></i>
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
                    <option selected>Produk</option>
                    @foreach($products as $produk)
                        <option value="{{ $produk->produk_id }}">{{ $produk->nama_produk }}</option>
                    @endforeach
                </select>
                </div>

                <div class="col-md-4 product_category">
                <select class="form-select" aria-label="Filter by Category">
                    <option selected>Transaksi</option>
                    @foreach($penjualan as $penjualan)
                        <option value="{{ $penjualan->penjualan_id }}">{{ $penjualan->kode_transaksi }}</option>
                    @endforeach
                </select>
                </div>

                <div class="col-md-4 product_date">
                    <input type="date" class="form-control" aria-label="Filter by Date" name="date" value="<?= date('Y-m-d') ?>">
                </div>

            </div>
        </div>
        <div class="row align-items-center g-0 p-6 bg-white sticky-top">
            <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Cari Nama Customer" aria-label="Search Customers">
            </div>
            <div class="col-md-8 d-flex justify-content-end align-items-center gap-2">
                <select class="form-select w-auto" aria-label="Select number of items">
                    <option selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <div class="row px-6">
            @foreach($customerDebt as $customer)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-9">
                                    <h5 class="card-title fw-bold"><strong>Nama Customer: {{ $customer->nama_customer }}</strong></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <p><strong>Perusahaan:</strong> {{ $customer->perusahaan_customer }}</p>
                                    <p><strong>No HP:</strong> {{ $customer->no_hp_customer }}</p>
                                    <p class="text-danger"><strong>Total Hutang:</strong> Rp {{ number_format($customer->hutang_customer, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                @foreach($customer->penjualan as $penjualan)
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal Transaksi</th>
                                                <th>Total Harga</th>
                                                <th>Dibayar</th>
                                                <th>Sisa Hutang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $penjualan->kode_transaksi }}</td>
                                                <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->format('d-m-Y') }}</td>
                                                <td>Rp {{ number_format($penjualan->total_harga, 2) }}</td>
                                                <td>Rp {{ number_format($penjualan->dibayar, 2) }}</td>
                                                <td>Rp {{ number_format($penjualan->total_harga - $penjualan->dibayar, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h6 class="mt-4">Detail Produk:</h6>
                                    <table class="table mt-2">
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

                                            @foreach($penjualan->detailPenjualan as $detail)
                                                <tr>
                                                    <td>{{ $detail->produk->nama_produk }}</td>
                                                    <td>{{ $detail->jumlah }}</td>
                                                    <td>Rp {{ number_format($detail->unit_harga, 2) }}</td>
                                                    <td>Rp {{ number_format($detail->total_harga, 2) }}</td>
                                                </tr>
                                                @php
                                                    $grandTotal += $detail->total_harga;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-center fw-bold">Grand Total</td>
                                                <td class="fw-bold">Rp {{ number_format($grandTotal, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection