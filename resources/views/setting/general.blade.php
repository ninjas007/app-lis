@extends('layouts.app')

@section('content-app')
    <div class="row g-3">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-header">Setting Umum</h4>
                    <div>Konfigurasi dan setting sistem</div>
                </div>
                <div class="card-body">
                    <form action="{{ url('/setting/general') }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- <div class="form-group mb-3">
                            <label for="app_name" class="form-label">Nama Aplikasi</label>
                            <input type="text" class="form-control @error('app_name') is-invalid @enderror"
                                id="app_name" name="app_name" value="{{ $setting->app_name ?? old('app_name') }}">

                            @error('app_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="form-group mb-3">
                            <label for="limit_connection" class="form-label">Limit Pengecekan Koneksi (menit) <i
                                    class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                                    title="Nilai ini untuk pengecekan koneksi ke alat yang terhubung ke aplikasi"></i></label>
                            @php
                                $limitConnection = $setting->where('key', 'limit_connection')->first();
                            @endphp
                            <input type="text" class="form-control @error('limit_connection') is-invalid @enderror"
                                id="limit_connection" name="limit_connection"
                                value="{{ $limitConnection['value']->value ?? old('limit_connection') }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right">
                               <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
