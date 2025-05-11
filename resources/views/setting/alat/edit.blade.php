@extends('layouts.app')

@section('content-app')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3"><i class="fa fa-plus"></i> Tambah Alat</h4>
                    <form action="{{ route('setting.alat.update', $alat->uid) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Masukkan Nama" required value="{{ $alat->name }}">

                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ip_address">IP Address</label>
                            <input type="ip" name="ip_address" id="ip_address" class="form-control"
                                placeholder="Masukkan IP Address" required value="{{ $alat->ip_address }}">

                            @error('ip_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="port">Port</label>
                            <input type="text" name="port" id="port" class="form-control"
                                placeholder="Masukkan Port" value="{{ $alat->port }}">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" id="status">
                                <option value="active" {{ $alat->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $alat->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" id="auto_connect" name="auto_connect" type="checkbox" {{ $alat->auto_connect == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="auto_connect" >Auto-reconnect on connection loss</label>
                            </div>
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ url('/setting/alat') }}" class="btn btn-sm btn-danger">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
