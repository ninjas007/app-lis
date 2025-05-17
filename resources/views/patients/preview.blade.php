<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Preview & Cetak</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .preview-list {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h4>Preview & Cetak</h4>
        <div class="row">
            <!-- Checklist Area -->
            <div class="col-md-6">
                <form id="printForm" method="POST" target="_blank">
                    @csrf

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="checkAll">
                        <label class="form-check-label">Pilih Semua</label>
                    </div>

                    @foreach ($labDetails as $detail)
                        <div class="form-check">
                            <input class="form-check-input item-checkbox"
                                   type="checkbox"
                                   name="selected_ids[]"
                                   value="{{ $detail->id }}"
                                   checked
                                   data-id="{{ $detail->id }}"
                                   data-code="{{ $detail->labParameter->code ?? '-' }}"
                                   data-result="{{ $detail->result }}"
                                   data-unit="{{ $detail->unit }}"
                                   data-range="{{ $detail->reference_range }}">
                            <label class="form-check-label">
                                {{ $detail->labParameter->code ?? '-' }} | {{ $detail->result }} {{ $detail->unit }}
                            </label>
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary mt-3">Cetak Terpilih</button>
                </form>
            </div>

            <!-- Preview Area -->
            <div class="col-md-6">
                <h5>Preview Terpilih:</h5>
                <div id="previewArea" class="preview-list">
                    <h5>Hasil Pemeriksaan Laboratorium</h5>
                    <p>Nama Pasien: <strong>{{ $pasien->name }}</strong></p>
                    <p>No. Rekam Medis: <strong>{{ $pasien->medical_record_number }}</strong></p>
                    <p>Tanggal Pemeriksaan: <strong>{{ $labResult->exam_date }}</strong></p>

                    <table id="previewTable">
                        <thead>
                            <tr>
                                <th>Kode Parameter</th>
                                <th>Hasil</th>
                                <th>Satuan</th>
                                <th>Rentang Referensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Preview hasil checklist akan tampil di sini -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select All Checkbox
        document.getElementById('checkAll').addEventListener('change', function () {
            const isChecked = this.checked;
            document.querySelectorAll('.item-checkbox').forEach(cb => {
                cb.checked = isChecked;
                togglePreview(cb);
            });
        });

        // Event Listener untuk setiap checkbox
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                togglePreview(this);
            });
        });

        // Function untuk menambah atau menghapus item di preview
        function togglePreview(checkbox) {
            const tableBody = document.querySelector("#previewTable tbody");
            const rowId = `row-${checkbox.value}`;

            if (checkbox.checked) {
                // Jika dicentang, tambahkan ke preview
                if (!document.getElementById(rowId)) {
                    const row = document.createElement('tr');
                    row.id = rowId;
                    row.innerHTML = `
                        <td>${checkbox.dataset.code}</td>
                        <td>${checkbox.dataset.result}</td>
                        <td>${checkbox.dataset.unit}</td>
                        <td>${checkbox.dataset.range}</td>
                    `;
                    tableBody.appendChild(row);
                }
            } else {
                // Jika di-*uncheck*, hapus dari preview
                const row = document.getElementById(rowId);
                if (row) row.remove();
            }
        }

        // Inisialisasi pertama kali (render semua yang checked)
        document.querySelectorAll('.item-checkbox').forEach(cb => togglePreview(cb));
    </script>
</body>

</html>
