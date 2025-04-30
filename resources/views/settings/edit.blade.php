@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-title">Edit Pengaturan - {{ ucfirst($group) }}</h5>
    </div>
    <form action="{{ route('settings.update', $group) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            @foreach($settings as $setting)
            <div class="mb-3">
                <label for="setting-{{ $setting->key }}" class="form-label">
                    {{ $setting->description ?? ucwords(str_replace('_', ' ', $setting->key)) }}
                </label>
                
                @if(strpos($setting->key, 'logo') !== false)
                    <input type="file" class="form-control" id="setting-{{ $setting->key }}" name="settings[{{ $setting->key }}]">
                    @if($setting->value)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $setting->value) }}" alt="Logo" style="max-height: 100px;">
                        </div>
                    @endif
                @elseif(strpos($setting->key, 'note') !== false || strpos($setting->key, 'footer') !== false)
                    <textarea class="form-control" id="setting-{{ $setting->key }}" 
                        name="settings[{{ $setting->key }}]" rows="3">{{ old('settings.'.$setting->key, $setting->value) }}</textarea>
                @else
                    <input type="text" class="form-control" id="setting-{{ $setting->key }}" 
                        name="settings[{{ $setting->key }}]" value="{{ old('settings.'.$setting->key, $setting->value) }}">
                @endif
            </div>
            @endforeach
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('settings.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection