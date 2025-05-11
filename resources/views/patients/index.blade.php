@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('theme') }}/css/jquery.dataTables.min.css">

    <style>
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
                <h4 class="mb-3"><i class="fa fa-user"></i> Pasien</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover bg-light" id="datatable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No</th>
                                <th>MRN</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Usia</th>
                                <th>Total Test</th>
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
                    },
                    {
                        data: 'gender',
                        name: 'gender',
                        width: '15%',
                        render: function(data, type, row) {
                            return getGenderContent(data);
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
                        data: 'total_test',
                        name: 'total_test',
                        className: 'text-center',
                        width: '10%',
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
                    return `<span class="badge badge-primary font-weight-bold">${gender}</span>`;
                } else if (gender == 'Female') {
                    return `<span class="badge badge-danger font-weight-bold">${gender}</span>`;
                }
            }
        });
    </script>
@endsection
