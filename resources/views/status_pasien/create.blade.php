@extends('layouts.app')

@section('content-app')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3"><i class="fa fa-plus"></i> Tambah Status Pasien</h4>
                    @include('status_pasien._form')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
