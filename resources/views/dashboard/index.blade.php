@extends('layouts.app')

@section('content-app')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Total Pasien</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $totalPasien ?? 0 }}</h2>
                            <p class="text-white mb-0">Total pasien</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-user"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Total Hasil Lab</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $totalHasilLab ?? 0 }}</h2>
                            <p class="text-white mb-0">Total hasil lab</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-medkit"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-3">
                    <div class="card-body">
                        <h3 class="card-title text-white">Hasil Pending</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $totalPending ?? 0 }}</h2>
                            <p class="text-white mb-0">Hasil lab pending</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-refresh"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-6">
                    <div class="card-body">
                        <h3 class="card-title text-white">Hasil Selesai</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $totalSelesai ?? 0 }}</h2>
                            <p class="text-white mb-0">Hasil Lab Selesai</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-check"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Grafik Berdasarkan Usia</h4>
                        <div id="flotPie1" class="flot-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header p-2 pb-0">
                        <div class="card-title pt-2">Hasil Lab Terbaru</div>
                    </div>
                    <div class="card-body p-2">
                        <div class="active-member">
                            <div class="table-responsive">
                                <table class="table table-xs table-hover mb-0">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th width="30%">Pasien</th>
                                            <th width="20%">Waktu Test</th>
                                            <th width="10%">Status</th>
                                            <th width="10%">WBC</th>
                                            <th width="10%">RBC</th>
                                            <th width="5%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hasilLabTerbaruList as $hasil)
                                            <tr>
                                                <td>
                                                    {{ $hasil->patient->name ?? '-' }}
                                                    <br>
                                                    <small class="text-muted">
                                                        RM: {{ $hasil->patient->no_rm ?? '-' }}
                                                    </small>
                                                    <br>
                                                </td>
                                                <td class="font-weight-bold">
                                                    @if ($hasil->sample_taken_at != null)
                                                        {{ \Carbon\Carbon::parse($hasil->sample_taken_at)->format('d M Y') }}
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($hasil->sample_taken_at)->format('H:i') }}
                                                        </small>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($hasil->result_at != null)
                                                        <span class="badge badge-success text-white">Selesai</span>
                                                    @else
                                                        <span class="badge badge-danger text-white">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @foreach ($hasil->details as $detail)
                                                        @if ($detail->labParameter->code == 'WBC')
                                                            {{ $detail->result }}
                                                            @break;
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($hasil->details as $detail)
                                                        @if ($detail->labParameter->code == 'RBC')
                                                            {{ $detail->result }}
                                                            @break;
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{ url('pasien/' . $hasil->patient->uid . '/detail/' . $hasil->uid) }}">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('theme') }}/plugins/datamaps/datamaps.world.min.js"></script>

    <script src="{{ asset('theme') }}/plugins/chart.js/Chart.bundle.min.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.min.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.pie.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.resize.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.spline.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.init.js"></script>
@endsection
