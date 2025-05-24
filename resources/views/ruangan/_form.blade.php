<form action="{{ isset($ruangan) ? route('master.ruangan.update', $ruangan->uid) : route('master.ruangan.store') }}"
    method="POST">
    @if (isset($ruangan))
        @method('PUT')
    @endif
    @csrf

    <div class="form-group">
        <label for="name">Nama Ruangan</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama"
            required value="{{ isset($ruangan) ? $ruangan->name : old('name') }}">

        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Deskripsi</label>
        <input type="text" name="description" id="description" class="form-control" placeholder="Masukkan Deskripsi" value="{{ isset($ruangan) ? $ruangan->description : old('description') }}">
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
