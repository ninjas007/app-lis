@extends('layouts.app')

@section('content-app')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3"><i class="fa fa-edit"></i> Edit Parameter</h4>
                    <form action="{{ route('parameter.update', $parameter->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="code">Kode Parameter</label>
                            <input type="text" name="code" id="code" class="form-control"
                                placeholder="Masukkan Kode Parameter" required value="{{ $parameter->code }}">

                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Parameter</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Masukkan Nama Parameter" required value="{{ $parameter->name }}">

                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="loinc_code">Loinc Code</label>
                            <input type="text" name="loinc_code" id="loinc_code" class="form-control"
                                placeholder="Masukkan LOINC Code" value="{{ $parameter->loinc_code }}">
                        </div>

                        <div class="form-group">
                            <label for="default_unit">Default Unit</label>
                            <input type="text" name="default_unit" id="default_unit" class="form-control"
                                placeholder="Masukkan Default Unit" value="{{ $parameter->default_unit }}">
                        </div>

                        <div class="form-group">
                            <label for="default_ref_range">Default Reference Range</label>
                            <input type="text" name="default_ref_range" id="default_ref_range" class="form-control"
                                placeholder="Masukkan Default Reference Range" value="{{ $parameter->default_ref_range }}">
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ url('/parameter') }}" class="btn btn-sm btn-danger">
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
