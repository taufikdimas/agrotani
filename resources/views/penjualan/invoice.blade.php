@extends('layouts.app')

<?php use App\Models\Setting; ?>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .invoice-preview, .invoice-preview * {
            visibility: visible;
        }
        .invoice-preview {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')

<div class="row invoice-preview">
    <!-- Invoice Main Column -->
    <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
        <div class="card invoice-preview-card p-sm-12 p-6">

            {{-- Header --}}
            <div class="card-body invoice-preview-header rounded">
                <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column align-items-xl-center align-items-md-start align-items-sm-center align-items-start">
                    <div class="mb-xl-0 mb-6 text-heading">
                    <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
                        <img src="{{ asset('storage/' . $companyInfo['companyLogo']) }}" alt="Logo Perusahaan" style="width: 40px">

                        <span class="app-brand-text demo fw-bold ms-50 lh-1">
                            {{ $companyInfo['companyName'] ?? 'Nama Perusahaan Default' }}
                        </span>
                    </div>

                    <p class="mb-2">
                        <i class="bx bx-map me-1"></i> {{ $companyInfo['companyAddress'] ?? 'Alamat Default' }}
                    </p>
                    <p class="mb-2">
                        <i class="bx bx-current-location me-1"></i> {{ $companyInfo['companyCity'] ?? 'Kota Default' }}
                    </p>
                    <p class="mb-0">
                        <i class="bx bx-phone me-1"></i> {{ $companyInfo['companyPhone'] ?? '000-0000-0000' }}
                    </p>

                </div>

                    <div>
                        <h5 class="mb-6">Invoice #{{ $penjualan->kode_transaksi }}</h5>
                        <div class="mb-1 text-heading">
                            <span>Tanggal Transaksi:</span>
                            <span class="fw-medium">{{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->format('d F Y') }}</span>
                        </div>
                        @if($penjualan->status_pembayaran == 'Belum Lunas')
                        <div class="text-heading">
                            <span>Jatuh Tempo:</span>
                            <span class="fw-medium">{{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->addDays(30)->format('d F Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Customer & Payment Info --}}
            <div class="card-body px-0">
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
                        <h6>Kepada:</h6>
                        <p class="mb-1">{{ $penjualan->customer->nama_customer }}</p>
                        <p class="mb-1">{{ $penjualan->customer->alamat }}</p>
                        <p class="mb-1">{{ $penjualan->customer->kota }}</p>
                        <p class="mb-0">{{ $penjualan->customer->no_telp }}</p>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                        <h6>Detail Pembayaran:</h6>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="pe-4">Total Tagihan:</td>
                                    <td class="fw-medium">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="pe-4">Status Pembayaran:</td>
                                    <td>
                                        @if($penjualan->status_pembayaran == 'Lunas')
                                            <span class="badge bg-success">LUNAS</span>
                                        @else
                                            <span class="badge bg-warning">BELUM LUNAS</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pe-4">Metode Pembayaran:</td>
                                    <td>{{ $penjualan->metode_pembayaran }}</td>
                                </tr>
                                @if($penjualan->status_pembayaran == 'Belum Lunas')
                                <tr>
                                    <td class="pe-4">Sisa Tagihan:</td>
                                    <td class="fw-bold text-danger">
                                        Rp {{ number_format($penjualan->total_harga - $penjualan->cicilan->sum('nominal_cicilan'), 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tabel Produk --}}
            <div class="table-responsive border border-bottom-0 border-top-0 rounded">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Deskripsi</th>
                            <th>Harga Satuan</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan->detailPenjualan as $item)
                        <tr>
                            <td class="text-nowrap text-heading">{{ $item->produk->nama_produk }}</td>
                            <td class="text-nowrap">{{ $item->produk->kode_produk }}</td>
                            <td>Rp {{ number_format($item->unit_harga, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total dan Marketing --}}
            <div class="table-responsive">
                <table class="table m-0 table-borderless">
                    <tbody>
                        <tr>
                            <td class="align-top pe-6 ps-0 py-6 text-body">
                                <p class="mb-1">
                                    <span class="me-2 h6">Marketing:</span>
                                    <span>{{ $penjualan->marketing->nama_marketing ?? '-' }}</span>
                                </p>
                                <span>Terima kasih atas pembelian Anda</span>
                            </td>
                            <td class="px-0 py-6 w-px-100">
                                <p class="mb-2">Subtotal:</p>
                                <p class="mb-2 border-bottom pb-2">Total Dibayar:</p>
                                @if($penjualan->status_pembayaran == 'Belum Lunas')
                                <p class="mb-0">Sisa Tagihan:</p>
                                @endif
                            </td>
                            <td class="text-end px-0 py-6 w-px-100 fw-medium text-heading">
                                <p class="fw-medium mb-2">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</p>
                                <p class="fw-medium mb-2 border-bottom pb-2">Rp {{ number_format($penjualan->dibayar, 0, ',', '.') }}</p>
                                @if($penjualan->status_pembayaran == 'Belum Lunas')
                                <p class="fw-medium mb-0 text-danger">
                                    Rp {{ number_format($penjualan->total_harga - $penjualan->cicilan->sum('nominal_cicilan'), 0, ',', '.') }}
                                </p>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Catatan --}}
            <hr class="mt-0 mb-6" />
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-12">
                        <span class="fw-medium text-heading">Catatan:</span>
                        <span>
                            @if($penjualan->status_pembayaran == 'Lunas')
                                Pembayaran telah diterima secara penuh. Terima kasih.
                            @else
                                Silakan melakukan pembayaran sebelum tanggal jatuh tempo. 
                                <br>
                                Pembayaran dapat dilakukan via transfer ke rekening:
                                <br>
                                <br>
                                <strong>{{ setting('bank_name') }} - No. Rek: {{ setting('bank_account') }} a.n {{ setting('bank_holder') }}</strong>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tombol Navigasi --}}
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
            <button class="btn btn-primary" onclick="window.print()">
                <i class="bx bx-printer me-1"></i> Cetak Invoice
            </button>
        </div>
    </div>
</div>

@endsection
