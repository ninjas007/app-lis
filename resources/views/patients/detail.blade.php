@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('theme/css/jquery.dataTables.min.css') }}">
    <style>
        .table thead {
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
        }

        .image-grid img {
            width: 100%;
            height: 120px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea,
        select {
            border: #959595 0.4px solid;
            width: 100%;
            padding: 5px;
        }
    </style>
@endsection

@section('content-app')
    <div class="row mb-3">
        <div class="col-12">
            <div class="float-right">
                <a href="{{ url('pasien') }}" class="btn btn-sm btn-danger">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-print"></i> Cetak
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(0)"
                            onclick="printHasil(`{{ $pasien->uid }}`, `{{ $labResult->uid }}`, 'summary')">
                            <i class="fa fa-file"></i> Print A4 Potrait
                        </a>
                        {{-- <a class="dropdown-item" href="javascript:void(0)"
                            onclick="printHasil(`{{ $pasien->uid }}`, `{{ $labResult->uid }}`, 'detail')">
                            <i class="fa fa-file"></i> Print A4 Landscape
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ url('pasien'.'/'.$pasien->uid.'/detail/'.$labResult->uid) }}" method="POST">
                    <div class="card-header d-flex justify-content-between border-bottom">
                        <h5>Detail Pasien</h5>
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td width="30%">No. RM</td>
                                            <td><input type="text" name="pasien_norm"
                                                    value="{{ $pasien->medical_record_number ?? '' }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td><input type="text" name="pasien_nama" value="{{ $pasien->name }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Lahir</td>
                                            <td><input type="date" name="pasien_lahir"
                                                    value="{{ $pasien->birth_date ?? '' }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td>
                                                <select name="pasien_gender" id="gender">
                                                    <option value="Male"
                                                        {{ $pasien->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Male"
                                                        {{ $pasien->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>
                                                <input type="text" name="pasien_alamat"
                                                    value="{{ $pasien->address ?? '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Diagnosa</td>
                                            <td>
                                                <textarea name="hasil_diagnosa" id="" style="height: 50px;">{{ $pasienHasilDetail->diagnosa ?? '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Catatan</td>
                                            <td>
                                                <textarea name="hasil_catatan" id="" style="height: 100px;">{{ $pasienHasilDetail->catatan ?? '' }}</textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td width="35%">No. Lab/ No. Reg</td>
                                            <td>
                                                <input type="text" name="hasil_no_lab" value="{{ $labResult->lab_number ?? '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td>
                                                <input type="datetime-local" name="hasil_tanggal" value="{{ $labResult->result_at ? \Carbon\Carbon::parse($labResult->result_at)->format('Y-m-d\TH:i:s') : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dokter Pengirim</td>
                                            <td colspan="2">
                                                <input type="text" name="hasil_dokter_pengirim" value="{{ $pasienHasilDetail->dokter_pengirim ?? '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dokter Penanggung Jawab</td>
                                            <td colspan="2">
                                                <input type="text" name="hasil_dokter_penanggung_jawab" value="{{ $pasienHasilDetail->dokter_penanggung_jawab ?? '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ruangan/Poli</td>
                                            <td colspan="2">
                                                <input type="text" name="hasil_ruangan_poli" value="{{ $pasienHasilDetail->ruangan_poli ?? '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Petugas</td>
                                            <td colspan="2">
                                                <input type="text" name="hasil_petugas" value="{{ $pasienHasilDetail->petugas ?? '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Verifikasi</td>
                                            <td colspan="2">
                                                <input type="text" name="hasil_verifikasi" value="{{ $pasienHasilDetail->verifikasi ?? '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status Pasien</td>
                                            <td colspan="2">
                                                <select name="hasil_status_pasien" id="">
                                                    <option value="Umum" {{ ($pasienHasilDetail->status ?? '') == 'Umum' ? 'selected' : '' }}>Umum</option>
                                                    <option value="BPJS" {{ ($pasienHasilDetail->status ?? '') == 'BPJS' ? 'selected' : '' }}>BPJS</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Layanan</td>
                                            <td colspan="2">
                                                <select name="hasil_jenis_layanan" id="">
                                                    <option value="Reguler" {{ ($pasienHasilDetail->jenis_layanan ?? '') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                                    <option value="VIP" {{ ($pasienHasilDetail->jenis_layanan ?? '') == 'VIP' ? 'selected' : '' }}>VIP</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right mb-2">
                            <i class="fa fa-save"></i> Simpan Detail Pemeriksaan Pasien
                        </button>
                    </div>
                </form>
            </div>
            <div class="card">
                <form action="{{ url('pasien'.'/'.$pasien->uid.'/hasil-pemeriksaan/'.$labResult->uid) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8 px-0">
                                <h5 class="mb-3">Detail Pemeriksaan Laboratorium</h5>
                                <table class="table table-striped table-sm">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Hasil</th>
                                            <th>Unit</th>
                                            <th width="20%">Nilai Rujukan</th>
                                            <th width="5%" class="text-center">Flag</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($labDetails as $detail)
                                            <tr>
                                                <td width="20%">{{ $detail->labParameter->code ?? '-' }}</td>
                                                <td width="30%">
                                                    <input type="hidden" name="detail_ids[]" value="{{ $detail->id }}">
                                                    <input type="text" name="lab_parameter_result[]" value="{{ $detail->result }}"
                                                        style="width: 30%">
                                                </td>
                                                <td width="20%">{{ $detail->unit }}</td>
                                                <td width="20%">{{ $detail->reference_range }}</td>
                                                <td class="text-center">
                                                    @if ($detail->reference_range)
                                                        @php
                                                            // Memecah rentang referensi menjadi batas bawah dan atas
                                                            [$min, $max] = explode('-', $detail->reference_range);

                                                            // Trim whitespace dan ubah menjadi float
                                                            $min = (float) trim($min);
                                                            $max = (float) trim($max);
                                                            $result = (float) $detail->result;
                                                        @endphp

                                                        @if ($result < $min)
                                                            <span style="color: red; font-weight: bold;">
                                                                <i class="fa fa-arrow-down"></i>
                                                            </span>
                                                        @elseif ($result > $max)
                                                            <span style="color: red; font-weight: bold;">
                                                                <i class="fa fa-arrow-up"></i>
                                                            </span>
                                                        @else
                                                            <span style="color: green;">✔</span>
                                                        @endif
                                                    @else
                                                        <span style="color: gray;">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada hasil lab ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4 pr-md-0">
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
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right mb-2">
                            <i class="fa fa-save"></i> Simpan Detail Hasil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function printHasil(pasienUid, hasilUid) {
            window.location.href = `{{ url('pasien/${pasienUid}/print/${hasilUid}') }}`;
        }
    </script>
@endsection
