@extends('layouts.app')

@section('css')
    <style>
        .card-link {
            text-decoration: none;
            color: inherit;
        }

        .card-link:hover {
            color: #0d6efd;
        }

        .card-config {
            transition: transform 0.2s ease-in-out;
        }

        .card-config:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection

@section('content-app')
    <div class="row g-3">
        <!-- Pengaturan Umum -->
        <div class="col-md-4">
            <a href="{{ url('/setting/general') }}" class="card-link">
                <div class="card card-config shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-cog mr-3 fs-3 display-6 text-primary"></i>
                            <div>
                                <h5 class="card-title mb-0">Pengaturan Umum</h5>
                                <p class="card-text text-muted">Konfigurasi dan setting sistem</p>
                            </div>
                        </div>
                        <i class="fa fa-arrow-right text-primary"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Template Cetak -->
        <div class="col-md-4">
            <a href="{{ url('/setting/template') }}" class="card-link">
                <div class="card card-config shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-print mr-3 fs-3 display-6 text-primary"></i>
                            <div>
                                <h5 class="card-title mb-0">Template Cetak</h5>
                                <p class="card-text text-muted">Konfigurasi template dan laporan</p>
                            </div>
                        </div>
                        <i class="fa fa-arrow-right text-primary"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Koneksi Alat -->
        <div class="col-md-4">
            <a href="{{ url('/setting/connection') }}" class="card-link">
                <div class="card card-config shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-wifi mr-3 fs-3 display-6 text-primary"></i>
                            <div>
                                <h5 class="card-title mb-0">Koneksi Alat</h5>
                                <p class="card-text text-muted">Konfigurasi koneksi dan protokol</p>
                            </div>
                        </div>
                        <i class="fa fa-arrow-right text-primary"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
