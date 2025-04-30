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
        .table-produk td, .table-produk th {
            vertical-align: middle;
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
                                    <h4 class="mb-0">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h4>
                                    <p class="mb-0">Total Penjualan</p>
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
                                    <h4 class="mb-0">Rp {{ number_format($totalLaba, 0, ',', '.') }}</h4>
                                    <p class="mb-0">Total Laba Bersih</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-line-chart bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">{{ $totalTransaksi }}</h4>
                                    <p class="mb-0">Total Transaksi</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-receipt bx-md"></i>
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
            <form id="filterForm" method="GET" action="{{ url('/marketing-report') }}">
                <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0 g-md-6">
                    <div class="col-md-3 product_status">
                        <select class="form-select" name="marketing_id" aria-label="Filter by Marketing">
                            <option value="">Semua Marketing</option>
                            @foreach($marketings as $marketing)
                                <option value="{{ $marketing->marketing_id }}" {{ $selectedMarketing == $marketing->marketing_id ? 'selected' : '' }}>
                                    {{ $marketing->nama_marketing }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 period_filter">
                        <select class="form-select" name="period" id="periodSelect" aria-label="Filter by Period">
                            <option value="all" {{ $selectedPeriod == 'all' ? 'selected' : '' }}>Semua Periode</option>
                            <option value="daily" {{ $selectedPeriod == 'daily' ? 'selected' : '' }}>Harian</option>
                            <option value="weekly" {{ $selectedPeriod == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="monthly" {{ $selectedPeriod == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        </select>
                    </div>
                    <div class="col-md-3 product_date">
                        <input type="date" class="form-control" name="date" id="dateInput" 
                            value="{{ $selectedDate }}" aria-label="Filter by Date">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row align-items-center g-0 p-6 bg-white sticky-top">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Cari Nama Marketing/Produk" aria-label="Search">
            </div>
            <div class="col-md-8 d-flex justify-content-end align-items-center gap-2">
                <select class="form-select w-auto" aria-label="Select number of items">
                    <option selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <button class="btn btn-primary" id="exportBtn">
                    <span class="icon-base bx bx-export icon-sm me-2"></span>Export
                </button>
            </div>
        </div>

        <div class="row px-6">
            @foreach($marketings as $marketing)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-9 d-flex align-items-center gap-2">
                                    <h5 class="card-title mb-0 text-primary">
                                        <strong>{{ $marketing->nama_marketing }}</strong>
                                    </h5>
                                    <span class="badge bg-label-info">{{ $marketing->kode_marketing }}</span>
                                </div>
                                <div class="col-3">
                                    <div class="d-flex justify-content-end mb-2">
                                        <span class="badge bg-label-primary">
                                            {{ $marketing->total_transaksi }} Transaksi
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <p><strong>Total Penjualan:</strong> Rp {{ number_format($marketing->total_penjualan, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Total Laba Bersih:</strong> Rp {{ number_format($marketing->total_laba, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Rata-rata Laba per Transaksi:</strong> 
                                        Rp {{ number_format($marketing->total_transaksi > 0 ? $marketing->total_laba / $marketing->total_transaksi : 0, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-produk">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Jumlah Terjual</th>
                                            <th>Total Harga</th>
                                            <th>Total Laba</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $produkData = [];
                                            // Hitung produk yang dijual oleh marketing ini
                                            foreach ($marketing->penjualan as $penjualan) {
                                                foreach ($penjualan->detailPenjualan as $detail) {
                                                    $produkId = $detail->produk->produk_id;
                                                    if (!isset($produkData[$produkId])) {
                                                        $produkData[$produkId] = [
                                                            'nama' => $detail->produk->nama_produk,
                                                            'kode' => $detail->produk->kode_produk,
                                                            'gambar' => $detail->produk->gambar,
                                                            'jumlah' => 0,
                                                            'total_harga' => 0,
                                                            'total_laba' => 0
                                                        ];
                                                    }
                                                    $produkData[$produkId]['jumlah'] += $detail->jumlah;
                                                    $produkData[$produkId]['total_harga'] += $detail->unit_harga * $detail->jumlah;
                                                    // Hitung laba per produk (asumsi laba bersih dibagi rata per produk)
                                                    $produkData[$produkId]['total_laba'] += ($penjualan->laba_bersih / count($penjualan->detailPenjualan));
                                                }
                                            }
                                        @endphp

                                        @foreach($produkData as $produk)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm me-2">
                                                            @if ($produk['gambar'])
                                                                <img src="{{ asset('storage/' . $produk['gambar']) }}" alt="Gambar Produk" class="avatar-img rounded">
                                                            @else
                                                                <span class="avatar-initial rounded bg-label-secondary">
                                                                    <i class="bx bx-package"></i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $produk['nama'] }}</h6>
                                                            <small class="text-muted">Kode: {{ $produk['kode'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $produk['jumlah'] }}</td>
                                                <td>Rp {{ number_format($produk['total_harga'], 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($produk['total_laba'], 0, ',', '.') }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">Lihat Detail</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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


    // Update date input berdasarkan periode yang dipilih
    $('#periodSelect').change(function() {
        const period = $(this).val();
        const dateInput = $('#dateInput');
        
        if (period === 'all') {
            dateInput.hide();
        } else {
            dateInput.show();
            
            // Set default date berdasarkan periode
            const today = new Date();
            let dateValue = today.toISOString().split('T')[0];
            
            if (period === 'weekly') {
                // Set ke awal minggu
                const firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
                dateValue = firstDay.toISOString().split('T')[0];
            } else if (period === 'monthly') {
                // Set ke awal bulan
                dateValue = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-01';
            }
            
            dateInput.val(dateValue);
        }
    });

    // Trigger change event saat halaman dimuat
    $(document).ready(function() {
        $('#periodSelect').trigger('change');
    });
</script>
@endpush