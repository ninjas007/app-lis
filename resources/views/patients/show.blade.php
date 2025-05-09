@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('theme') }}/css/jquery.dataTables.min.css">
@endsection

@section('content-app')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title pt-4">
               <i class="fa fa-medkit"></i> Hasil Lab Pasien
               <br>
               <small class="badge badge-primary mt-1">{{ $patient->name }}</small>
            </h4>
            <div class="card-tools pt-4">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-danger">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover" id="datatable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No</th>
                                <th>Tgl Pengambilan</th>
                                <th>Tgl Hasil</th>
                                <th width="15%">Detail Hasil Lab</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('theme') }}/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url('pasien/' . $patient->uid . '/lab') }}`,
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        width: '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'sample_taken_at',
                        name: 'sample_taken_at',
                    },
                    {
                        data: 'result_at',
                        name: 'result_at'
                    },
                    {
                        data: 'detail',
                        name: 'detail',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                    }
                ]
            });
        });
    </script>
@endsection
