@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('theme') }}/css/jquery.dataTables.min.css">

    <style>
        .status-validated {
            background-color: #d1e7dd;
            color: #198754;
            padding: 3px 8px;
            border-radius: 5px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 3px 8px;
            border-radius: 5px;
        }

        .datatable-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .table thead th {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>
@endsection

@section('content-app')
    <div class="card">
        <div class="card-body">
            <div class="datatable-header">
                <h4 class="mb-3">Hasil Pemeriksaan</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover bg-light table-bordered" id="datatable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No</th>
                                <th>MRN</th>
                                <th>Pasien</th>
                                <th>Tanggal Periksa</th>
                                <th>WBC</th>
                                <th>RBC</th>
                                <th>HGB</th>
                                <th>HCT</th>
                                <th>PLT</th>
                                <th>#</th>
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
    <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                createdRow: function(row, data, dataIndex) {
                    $('td', row).css('white-space', 'pre-line');
                },
                ajax: "{{ url('hasil/data') }}",
                columns: [
                    {
                        width: '5%',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'medical_record_number',
                        name: 'medical_record_number',
                        render: function (data, type, row) {
                            return row.patient.medical_record_number || '-'
                        }
                    },
                    {
                        data: 'pasien',
                        name: 'pasien',
                        render: function (data, type, row) {
                            return data
                        }
                    },
                    {
                        data: 'sample_taken_at',
                        name: 'sample_taken_at'
                    },
                    {
                        data: null,
                        name: 'wbc',
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            const detail = row.details.find(detail => detail.lab_parameter.code == 'WBC')
                            return detail.result
                        }
                    },
                    {
                        data: null,
                        name: 'rbc',
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            return row.details.find(detail => detail.lab_parameter.code == 'RBC').result
                        }
                    },
                    {
                        data: null,
                        name: 'hgb',
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            return row.details.find(detail => detail.lab_parameter.code == 'HGB').result
                        }
                    },
                    {
                        data: null,
                        name: 'hct',
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            return row.details.find(detail => detail.lab_parameter.code == 'HCT').result
                        }
                    },
                    {
                        data: null,
                        name: 'plt',
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            return row.details.find(detail => detail.lab_parameter.code == 'PLT').result
                        }
                    },
                    {
                        data: null,
                        name: 'detail',
                        searchable: false,
                        sortable: false,
                        className: 'text-center',
                        width: '5%',
                        render: function(data, type, row) {
                            return `<a href="{{ url('pasien') }}/${row.patient.uid}/detail/${row.uid}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-eye"></i>
                            </a>`;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
