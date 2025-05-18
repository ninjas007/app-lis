@extends('layouts.app')

@section('content-app')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-header">Gambar Login</h4>
                    <div>Gambar Halaman Login (.png)</div>
                    <div class="text-center mt-2">
                        <img src="{{ asset('images/gambar-login.png') }}" alt="" style="width: 50%; height: 150px; background-size: contain;">
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ url('/setting/general') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                                name="gambar" accept="image/png" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-header">Background Login</h4>
                    <div>Background Halaman Login (.png)</div>
                    <div class="text-center mt-2">
                        <img src="{{ asset('images/background.png') }}" alt="" style="width: 50%; height: 150px; background-size: contain;">
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ url('/setting/general') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="file" class="form-control @error('background') is-invalid @enderror" id="background"
                                name="background" accept="image/png" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-header">Logo Menu</h4>
                    <div>Logo di menu sidebar (.png)</div>
                    <div class="text-center mt-2">
                        <img src="{{ asset('images/logo.png') }}" alt="" style="width: 50%; height: 150px; background-size: contain;">
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ url('/setting/general') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                                name="logo" accept="image/png" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-header">Setting Umum</h4>
                    <div>Konfigurasi dan setting sistem</div>
                </div>
                <div class="card-body">
                    <form action="{{ url('/setting/general') }}" method="POST">
                        @csrf
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
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
