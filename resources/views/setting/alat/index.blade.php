@extends('layouts.app')

@section('content-app')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa fa-wifi"></i> Koneksi Alat</h4>
                    <small class="text-muted">Konfigurasi alat yang terhubung ke aplikasi</small>
                    <a href="{{ url('/setting/alat/create') }}">
                        <button class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i> Tambah Alat</button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5>Alat Terhubung</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th>Nama</th>
                                    <th>IP Address Alat</th>
                                    <th>Port</th>
                                    <th>Status</th>
                                    <th>Connection</th>
                                    <th width="8%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alats as $alat)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $alat->name }}</td>
                                        <td>{{ $alat->ip_address }}</td>
                                        <td>{{ $alat->port }}</td>
                                        <td>
                                            {!! $alat->status == 'active'
                                                ? '<span class="badge badge-success text-white">Active</span>'
                                                : '<span class="badge badge-danger text-white">Inactive</span>' !!}
                                        </td>
                                        <td>
                                            @if ($alat->last_connected_at != null && now()->diffInMinutes($alat->last_connected_at) <= $limitConnection)
                                                <span class="badge badge-success text-white">
                                                   <i class="fa fa-wifi"></i> Connected
                                                </span>
                                            @else
                                                <span class="badge text-white" style="background-color: #b1b1b1">
                                                   <i class="fa fa-wifi"></i> Disconnected
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('setting.alat.edit', $alat->uid) }}"
                                                class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" onclick="deleteData(`{{ $alat->uid }}`)"
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
                            {{ $alats->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function deleteData(uid) {
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
                        url: "{{ url('setting/alat') }}" + '/' + uid + '/destroy',
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
                                        window.location.href = "{{ url('setting/alat') }}";
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
