<form action="{{ isset($petugas) ? route('master.petugas.update', $petugas->uid) : route('master.petugas.store') }}"
    method="POST">
    @if (isset($petugas))
        @method('PUT')
    @endif
    @csrf

    <div class="form-group">
        <label for="name">Nama petugas</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama"
            required value="{{ isset($petugas) ? $petugas->name : old('name') }}">

        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Deskripsi</label>
        <input type="text" name="description" id="description" class="form-control" placeholder="Masukkan Deskripsi" value="{{ isset($petugas) ? $petugas->description : old('description') }}">
    </div>

    <div class="form-group mt-4 text-right">
        <a href="{{ url('/petugas') }}" class="btn btn-sm btn-danger">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-sm btn-primary">
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>
</form>
