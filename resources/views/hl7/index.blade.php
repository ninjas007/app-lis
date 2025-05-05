<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hasil Lab HL7</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-4">Daftar Hasil Lab HL7</h2>

        <form method="GET" class="mb-4">
            <div class="form-row">
                <div class="col-md-5">
                    <input type="text" name="search_name" value="{{ request('search_name') }}" class="form-control"
                        placeholder="Cari Nama Pasien">
                </div>
                <div class="col-md-5">
                    <input type="text" name="search_mrn" value="{{ request('search_mrn') }}" class="form-control"
                        placeholder="Cari Medical Record Number">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">Cari</button>
                </div>
            </div>
        </form>

        @forelse($results as $result)
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <strong>Nama:</strong> {{ $result->patient->name ?? '-' }} |
                    <strong>Tgl Lahir:</strong> {{ $result->patient->birth_date ?? '-' }} |
                    <strong>Umur:</strong> {{ \Carbon\Carbon::parse($result->patient->birth_date)->age ?? '-' }} tahun |
                    <strong>MRN:</strong> {{ preg_replace('/\D/', '', $result->patient->medical_record_number); }}
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Parameter</th>
                                <th>Hasil</th>
                                <th>Satuan</th>
                                <th>Nilai Rujukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result->details as $detail)
                                <tr>
                                    <td>{{ $detail->labParameter->code ?? '-' }}</td>
                                    <td>{{ $detail->result }}</td>
                                    <td>{{ $detail->unit }}</td>
                                    <td>{{ $detail->reference_range }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">Tidak ada hasil lab ditemukan.</div>
        @endforelse

        <div class="d-flex justify-content-center">
            {{ $results->links() }}
        </div>
    </div>
</body>

</html>
