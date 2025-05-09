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
                <h4 class="mb-3">Pasien</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover bg-light" id="datatable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No</th>
                                <th>Medical Record</th>
                                <th>Name</th>
                                <th>Tanggal Lahir</th>
                                <th>Usia</th>
                                <th>List Hasil</th>
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
                ajax: '{{ route('patients.data') }}',
                columns: [
                    {
                        className: 'text-center',
                        width: '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'medical_record_number',
                        name: 'medical_record_number'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            return `<a href="{{ url('pasien') }}/${row.uid}">${data}</a>
                            <br>
                            ` + getGenderContent(row.gender) + ``;
                        }
                    },
                    {
                        data: 'birth_date',
                        name: 'birth_date',
                        width: '15%'
                    },
                    {
                        data: 'age',
                        name: 'age',
                        width: '15%'
                    },
                    {
                        data: 'hasil_lab',
                        name: 'hasil_lab',
                        className: 'text-center',
                        width: '10%',
                        orderable: false,
                        searchable: false,
                    }
                ]
            });

            function getGenderContent(gender) {
                if (gender == 'Male') {
                    return '<span class="badge badge-primary">Laki-laki</span>';
                } else if (gender == 'Female') {
                    return '<span class="badge badge-danger">Perempuan</span>';
                }
            }
        });
    </script>
@endsection
