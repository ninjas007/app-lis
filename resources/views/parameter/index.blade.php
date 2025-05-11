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

        .datatable-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content-app')
    <div class="card">
        <div class="card-body">
            <div class="datatable-header">
                <h4 class="mb-3"><i class="fa fa-list"></i> Parameter</h4>
                <a href="{{ url('/parameter/create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Tambah Parameter
                </a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover bg-light table-bordered" id="datatable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Code</th>
                                <th>Nama</th>
                                <th>Loinc Code</th>
                                <th>Default Unit</th>
                                <th>Default Ref Range</th>
                                <th width="8%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($parameters as $parameter)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $parameter->code ?? '' }}</td>
                                    <td>{{ $parameter->name ?? '' }}</td>
                                    <td>{{ $parameter->loinc_code ?? '' }}</td>
                                    <td>{{ $parameter->default_unit ?? '' }}</td>
                                    <td>{{ $parameter->default_ref_range ?? '' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('parameter.edit', $parameter->id) }}"
                                            class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="deleteData(`{{ $parameter->id }}`)"
                                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $parameters->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function deleteData(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak, Batalkan!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('parameter') }}" + '/' + id,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                )
                                .then(() => {
                                    window.location.href = "{{ url('parameter') }}";
                                })
                            } else {
                                swalWithBootstrapButtons.fire(
                                    'Gagal!',
                                    data.message,
                                    'error'
                                )
                            }
                        },
                        error: function(data) {
                            console.log(data);
                            swalWithBootstrapButtons.fire(
                                'Gagal!',
                                'Terjadi kesalahan. Silahkan kontak admin',
                                'error'
                            )
                        }
                    })
                }
            })
        }
    </script>
@endsection
