<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Hasil Lab {{ $pasien->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
            margin-top: 5px;
            font-size: 12px;
        }

        body {
            font-family: Arial, sans-serif;
            /* margin: 20px; */
        }

        table {
            border-collapse: collapse;
            width: 100%
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table th,
        .table td {
            border: 0.5px solid #000;
            padding: 4px;
            text-align: left;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .images {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .image-box {
            width: 30%;
            text-align: center;
        }

        .image-box img {
            max-width: 100%;
            height: auto;
            display: inline-block
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
        }

        #tableFooter {
            position: fixed;
            bottom: 10%;
            left: 0;
            width: 100%;
            border-top: 1px solid #000;
            background-color: #fff;
        }

        #tableFooter td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h2 class="text-center">RS. BHAYANGKARA KUPANG</h2>
    </div>

    <!-- Informasi Pasien -->
    <div style="margin-bottom: 10px">
        <table>
            <tr>
                <td width="33%">
                    <table>
                        <tr>
                            <td width="28%">Name: </td>
                            <td>{{ $pasien->name }}</td>
                        </tr>
                        <tr>
                            <td>Gender: </td>
                            <td>{{ $pasien->gender }}</td>
                        </tr>
                        <tr>
                            <td>Diagnosis: </td>
                            <td>{{ $pasienHasilDetail->diagnosa ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td width="33%">Sample Type: </td>
                            <td>{{ $pasien->sampleType ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Department: </td>
                            <td>{{ $labResult->department ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>MRN: </td>
                            <td>{{ $pasien->medical_record_number ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                <td width="33%">
                    <table>
                        <tr>
                            <td width="30%">Sample ID: </td>
                            <td>{{ $pasien->sampleType ?? '-' }}</td>
                        </tr>

                        @php
                            $sampleTaken = Carbon\Carbon::parse($labResult->sample_taken_at);
                            $resultAt = Carbon\Carbon::parse($labResult->result_at);

                            // Menghitung selisih waktu dalam detik
                            $totalSeconds = $sampleTaken->diffInSeconds($resultAt);

                            // Konversi ke jam, menit, dan detik
                            $hours = floor($totalSeconds / 3600);
                            $minutes = floor(($totalSeconds % 3600) / 60);
                            $seconds = $totalSeconds % 60;

                            // Hasil akhir
                            $result = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                        @endphp

                        <tr>
                            <td>Run Time:</td>
                            <td>{{ $result }}</td>
                        </tr>
                        <tr>
                            <td>Age: </td>
                            <td>{{ Carbon\Carbon::parse($pasien->date_of_birth)->age }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tabel Hasil Pemeriksaan -->
    <table style="table">
        <tr>
            <td width="80%">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Result</th>
                            <th>Ref. Range</th>
                            <th>Unit</th>
                            <th style="width: 10px">Flag</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labDetails as $i => $detail)
                            <tr>
                                <td>{{ $detail->labParameter->code ?? '-' }}</td>
                                <td>{{ $detail->result }}</td>
                                <td>{{ $detail->reference_range }}</td>
                                <td>{{ $detail->unit }}</td>
                                <td>
                                    @php
                                        $min = explode('-', $detail->reference_range)[0];
                                        $max = explode('-', $detail->reference_range)[1];
                                    @endphp
                                    @if ($detail->result <= $max && $detail->result >= $min)
                                        <span style="color: green">Normal</span>
                                    @else
                                        <span style="color: red">Abnormal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            @if ($labResultImages->count() > 0)
                <td width="20%" style="vertical-align: top">
                    <table>
                        <tbody>
                            @foreach ($labResultImages->take(3) as $image)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $image->file_path) }}"
                                            style="width: 100%; height: 120px; object-fit: cover; margin-bottom: 4px">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            @endif
        </tr>
    </table>
    @if ($labResultImages->count() > 3)
        <table>
            <tr>
                @foreach ($labResultImages->skip(3) as $image)
                    <td>
                        <img src="{{ asset('storage/' . $image->file_path) }}">
                    </td>
                @endforeach
            </tr>
        </table>
    @endif

    <table style="margin-bottom: 10px" id="tableFooter">
        <tr>
            <td style="padding: 5px">Submitter: {{ $labResult->submitter ?? 'Siapa' }}</td>
            <td style="padding: 5px">Operator: {{ $labResult->operator ?? 'service' }}</td>
            <td style="padding: 5px">Approver: {{ $labResult->approver ?? 'DR. Radjsa' }} </td>
        </tr>
        <tr>
            <td>
                Sampling Time: {{ $labResult->sample_taken_at ?? '' }}
            </td>
            <td>
                Delivery Time: {{ $labResult->delivery_time_at ?? '' }}
            </td>
            <td>
                Validate Time: {{ $labResult->validate_time_at ?? '' }}
            </td>
        </tr>
        <tr>
            <td>
                Report Time: {{ $labResult->report_time_at ?? '' }}
            </td>
            <td>
                Remarks: {{ $labResult->remarks ?? '' }}
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <div style="padding-top: 20px; text-align: center; font-weight: bold; ">
                    *The report is responsible for this sample only. If you have any questions, please contact us in 24
                    hours.
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
