@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('theme/css/jquery.dataTables.min.css') }}">
    <style>
        .card-header {
            background-color: #004085 !important;
            color: white;
        }

        .card-header .btn {
            margin-left: 10px;
        }

        .table thead {
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        .image-grid img {
            width: 100%;
            height: 150px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content-app')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-3 d-flex justify-content-between">
                    <div>
                        <div class="mb-2">
                            <strong>Hasil Pemeriksaan - Tanggal: </strong> {{ $labResult->result_at ?? '-' }}
                        </div>
                        <div>
                            <strong>Nama:</strong> {{ $pasien->name ?? '-' }}
                            @if ($pasien->birth_date != null)
                                | <strong>Tgl Lahir:</strong> {{ $pasien->birth_date ?? '-' }}
                                | <strong>Umur:</strong> {{ \Carbon\Carbon::parse($pasien->birth_date)->age ?? '-' }} tahun
                            @endif

                            @if (preg_replace('/\D/', '', $pasien->medical_record_number) != null)
                                | <strong>MRN:</strong> {{ preg_replace('/\D/', '', $pasien->medical_record_number) }}
                            @endif

                        </div>
                    </div>
                    <div>
                        <a href="{{ url('pasien') }}" class="btn btn-sm btn-danger">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <a href="javascript:void(0)" onclick="window.print()" class="btn btn-sm btn-primary text-white">
                            <i class="fa fa-print"></i> Cetak
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8 px-0">
                            <h5 class="mb-3">Detail Pemeriksaan Laboratorium</h5>
                            <table class="table table-striped">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Hasil</th>
                                        <th>Unit</th>
                                        <th width="20%">Nilai Rujukan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($labDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->labParameter->code ?? '-' }}</td>
                                            <td>{{ $detail->result }}</td>
                                            <td>{{ $detail->unit }}</td>
                                            <td>{{ $detail->reference_range }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada hasil lab ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4 px-0">
                            <h5 class="mb-3">Gambar Histogram & Scattergram</h5>
                            <div class="image-grid">
                                @foreach ($labResultImages as $key => $image)
                                    <img src="{{ asset('storage/' . $image->file_path) }}"
                                        alt="Gambar {{ $key + 1 }}" style="width:">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
