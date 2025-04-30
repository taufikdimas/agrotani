@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-title">Pengaturan Aplikasi</h5>
    </div>
    <div class="card-body p-6">
        <div class="list-group">
            <a href="{{ route('settings.edit', 'company') }}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Informasi Perusahaan</h5>
                    <small><i class="bx bx-chevron-right"></i></small>
                </div>
                <p class="mb-1">Atur nama, alamat, dan kontak perusahaan</p>
            </a>
            <a href="{{ route('settings.edit', 'invoice') }}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Setting Invoice</h5>
                    <small><i class="bx bx-chevron-right"></i></small>
                </div>
                <p class="mb-1">Atur template, footer, dan informasi bank</p>
            </a>
        </div>
    </div>
</div>
@endsection