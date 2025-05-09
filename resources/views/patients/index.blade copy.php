@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('theme') }}/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <div>
                    <button class="btn btn-outline-primary"><i class="fas fa-sync-alt"></i> Refresh</button>
                    <button class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
            <table class="table table-hover" id="datatable">
                <thead>
                    <tr>
                        <th>Medical Record</th>
                        <th>Name</th>
                        <th>Gender/Age</th>
                        <th>Test Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('theme') }}/js/jquery.dataTables.min.js"></script>

    <script>
        $(function () {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('patients.data') }}',
                columns: [
                    {
                        data: 'medical_record_number',
                        name: 'medical_record_number',
                        render: function (data, type, row) {
                            return `<strong>${data}</strong>`;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function (data, type, row) {
                            return `<a href="{{ url('pasien') }}/${row.uid}">${data}</a>`;
                        }
                    },
                    {
                        data: null,
                        name: 'gender_age',
                        render: function (data, type, row) {
                            const genderClass = row.gender === 'Male' ? 'text-primary' : 'text-danger';
                            return `<span class="${genderClass}">${row.gender}</span>, ${row.age}y`;
                        }
                    },
                    {
                        data: 'test_date',
                        name: 'test_date',
                        render: function (data) {
                            return new Date(data).toLocaleString();
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function (data) {
                            if (data === 'Validated') {
                                return '<span class="status-validated">Validated</span>';
                            } else {
                                return '<span class="status-pending">Pending</span>';
                            }
                        }
                    },
                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function () {
                            return '<button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>';
                        }
                    }
                ],
                language: {
                    search: "Search patient name or ID...",
                    lengthMenu: "Showing _MENU_ results",
                    info: "Showing _START_ to _END_ of _TOTAL_ results",
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                }
            });
        });
    </script>
@endsection
