<?php

namespace App\Console\Commands;

use App\Models\LabParameter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Patient;

class ProcessHl7Files extends Command
{
    protected $signature = 'hl7:process';
    protected $description = 'Process HL7 files and store data to database';

    public function handle()
    {
        // check directory
        if (!Storage::disk('local')->exists('hl7')) {
            Storage::disk('local')->makeDirectory('hl7');
            $this->call('storage:link');
            $this->info('Folder "hl7" created and storage linked.');
        }

        $files = Storage::disk('local')->files('hl7');

        if (empty($files)) {
            $this->info('No HL7 files to process.');
            return;
        }

        foreach ($files as $file) {
            $this->info("Processing file: $file");

            $contents = Storage::disk('local')->get($file);
            $hl7 = $this->parseHL7($contents);

            try {
                if (!empty($hl7['OBX'])) {
                    $patient = $this->saveToPatient($hl7);
                    $result = $this->saveToLabResult($hl7, $patient->id);
                    $this->saveToLabResultDetail($hl7, $result->id);
                    $this->saveToLabResultImage($hl7, $result->id);
                    $this->saveToLabResultMessage($hl7, $result->id);

                    $this->info("Saved HL7 data to database.");
                } else {
                    $this->warn("No OBX segments (lab results) found in $file.");
                }

                if (env('HL7_DELETE_AFTER_PROCESS')) {
                    Storage::disk('local')->delete($file);
                    $this->info("Deleted file: $file");
                } else {
                    $this->info("File retained: $file");
                }
            } catch (\Exception $e) {
                $this->error("Failed to process $file: " . $e->getMessage());
                Storage::disk('local')->delete($file);
            }
        }
    }

    public function parseHL7($contents)
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($contents));
        $segments = [];
        $currentSegment = null;

        // Segment yang dianggap "awal baru"
        $validSegments = ['MSH', 'PID', 'PV1', 'OBR', 'OBX'];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            $code = substr($line, 0, 3);

            // Jika baris dimulai dengan SEGMENT| (misal OBR|, OBX|), maka segment baru
            if (in_array($code, $validSegments) && str_starts_with($line, $code . '|')) {
                $parts = explode('|', $line);
                $segments[$code][] = $parts;
                $currentSegment = $code;
            } else {
                // Jika tidak dimulai dengan SEGMENT|, gabung ke field terakhir dari segment sebelumnya
                if ($currentSegment !== null) {
                    $lastIndex = count($segments[$currentSegment]) - 1;
                    $lastFieldIndex = count($segments[$currentSegment][$lastIndex]) - 1;

                    // Gabungkan baris ke field terakhir (dengan spasi)
                    $segments[$currentSegment][$lastIndex][$lastFieldIndex] .= ' ' . $line;
                }
            }
        }

        return $segments;
    }


    public function saveToPatient($segments)
    {
        // == Parse MSH ==
        $msh = $segments['MSH'][0] ?? null;

        // == Parse & Save Patient ==
        $pid = $segments['PID'][0] ?? null;
        if (!$pid) throw new \Exception("PID segment not found.");

        $medicalRecordNumber = $pid[3] ?? null;
        $patientName = $pid[5] ?? '';
        $birthDate = $pid[7] ?? null;
        $stringPid = $pid[8] ?? null;

        // Format nama pasien: ^Zhang San -> Zhang San
        $name = trim(str_replace('^', ' ', $patientName));

        // hanya ambil angka saja dari medical record number
        $medicalRecordNumber = preg_replace('/\D/', '', $medicalRecordNumber);

        // generate uid
        $uid = Str::uuid()->toString();

        $pasien = Patient::where('medical_record_number', $medicalRecordNumber)->first();

        if ($pasien) {
            $pasien->update([
                'uid' => $uid,
                'name' => $name,
                'birth_date' => $birthDate ? \Carbon\Carbon::parse($birthDate)->format('Y-m-d') : $pasien->birth_date,
                'gender' => $this->getGender($stringPid),
            ]);
        } else {
            $pasien = Patient::create([
                'uid' => $uid,
                'medical_record_number' => $medicalRecordNumber,
                'name' => $name,
                'birth_date' => $birthDate ? \Carbon\Carbon::parse($birthDate)->format('Y-m-d') : null,
                'gender' => $this->getGender($stringPid),
            ]);
        }

        return $pasien;
    }

    public function saveToLabResult($segments, $patientId)
    {
        // == Parse OBR ==
        $obr = $segments['OBR'][0] ?? null;
        if (!$obr) throw new \Exception("OBR segment not found.");

        $labNumber = $obr[3] ?? null;
        $testType = $obr[4] ?? '';
        $sampleTaken = $obr[6] ?? null;
        $resultDate = $obr[7] ?? null;
        $doctor = $obr[10] ?? null;

        // format sampleTaken dan resultDate itu seperti ini "20140918091000"
        // mau ubah ke format datetime
        $sampleTaken = \Carbon\Carbon::createFromFormat('YmdHis', $sampleTaken)->format('Y-m-d H:i:s');
        $resultDate = \Carbon\Carbon::createFromFormat('YmdHis', $resultDate)->format('Y-m-d H:i:s');

        $labResult = [
            'uid' => Str::uuid()->toString(),
            'patient_id' => $patientId,
            'lab_number' => $labNumber,
            'test_type' => $testType,
            'sample_taken_at' => $sampleTaken ? $sampleTaken : null,
            'result_at' => $resultDate ? $resultDate : null,
            'doctor' => $doctor,
        ];

        $labResult = \App\Models\LabResult::create($labResult);

        return $labResult;
    }

    public function saveToLabResultDetail($segments, $labResultId)
    {
        // == Parse OBX Segments ==
        $obxSegments = $segments['OBX'] ?? [];

        // get code and id from LabParameter key by code
        $labParameters = LabParameter::pluck('id', 'code')->toArray();

        $data = [];
        foreach ($obxSegments as $obx) {
            $paramCodeDesc = $obx[3] ?? '';
            $result = $obx[5] ?? null;
            $unit = $obx[6] ?? null;
            $refRange = $obx[7] ?? null;

            // Safe parsing of code and description
            $parts = explode('^', $paramCodeDesc);
            $code = $parts[1] ?? null;

            if (!isset($labParameters[$code])) {
                $this->warn("Lab parameter code $code not found in database.");
                continue;
            }

            $data[] = [
                'uid' => Str::uuid()->toString(),
                'lab_result_id' => $labResultId,
                'lab_parameter_id' => $labParameters[$code],
                'result' => $result,
                'unit' => $unit,
                'reference_range' => $refRange ?? null,
                'created_at' => now(),
            ];
        }

        // Save Detail Result
        \App\Models\LabResultDetail::insert($data);
    }

    public function saveToLabResultImage($segments, $labResultId)
    {
        $obxSegments = $segments['OBX'] ?? [];

        // Buat array untuk menampung data gambar
        $imageData = [];

        foreach ($obxSegments as $obx) {
            $dataType = $obx[2] ?? '';
            $paramDesc = $obx[3] ?? '';
            $imageInfo = $obx[5] ?? '';

            // Cek jika tipe datanya "ED" dan deskripsinya mengandung Histogram atau Scattergram
            if ($dataType === 'ED' && (str_contains($paramDesc, 'Histogram') || str_contains($paramDesc, 'Scattergram'))) {

                // Parse data image
                $imageParts = explode('^', $imageInfo);

                if (count($imageParts) >= 4) {
                    $format = strtolower($imageParts[2]);  // png, bmp, jpg, dll
                    $base64Data = $imageParts[4];

                    // Generate nama file unik
                    $fileName = Str::uuid()->toString() . '.' . $format;

                    // Decode base64
                    $decodedImage = base64_decode($base64Data);

                    // Simpan ke storage Laravel (ke dalam folder `public/lab_results`)
                    $filePath = "public/lab_results/{$fileName}";
                    Storage::put($filePath, $decodedImage);

                    // Simpan informasi gambar ke dalam array
                    $imageData[] = [
                        'uid' => Str::uuid()->toString(),
                        'lab_result_id' => $labResultId,
                        'description' => $paramDesc,
                        'file_path' => "lab_results/{$fileName}",
                        'created_at' => now(),
                    ];
                }
            }
        }

        // Jika ada data, insert ke database
        if (count($imageData) > 0) {
            \App\Models\LabResultImage::insert($imageData);
        }
    }

    public function saveToLabResultMessage($segments, $labResultId)
    {
        $obxSegments = $segments['OBX'] ?? [];
        $messageData = [];

        foreach ($obxSegments as $obx) {
            $dataType = $obx[2] ?? '';
            $messageContent = $obx[3] ?? '';
            $value = $obx[5] ?? ''; // Field ke-5 (nilai)

            // Ambil IS dengan value tertentu
            if ($dataType === 'IS' && in_array($value, ['W', 'CBC+DIFF', 'T'])) {
                $content = explode('^', $messageContent);
                $codeRaw = $content[0] ?? null;
                $text = $content[1] ?? null;

                $code = $codeRaw;
                if (strpos($codeRaw, '-') !== false) {
                    $codeParts = explode('-', $codeRaw);
                    $code = $codeParts[0];
                }

                // Menentukan grup berdasarkan kode
                $group = null;
                if (preg_match('/^13\d+$/', $code)) {
                    $group = 'WBC';
                } elseif (preg_match('/^15\d+$/', $code)) {
                    $group = 'RBC';
                } elseif (preg_match('/^34\d+$/', $code)) {
                    $group = 'PLT';
                } else {
                    $group = 'OTHER';
                }

                $messageData[] = [
                    'uid' => Str::uuid()->toString(),
                    'lab_result_id' => $labResultId,
                    'code' => $codeRaw, // Tetap simpan kode asli lengkap
                    'content' => $text,
                    'group' => $group,  // Tambahkan field group
                    'created_at' => now(),
                ];
            }
        }

        if (count($messageData) > 0) {
            \App\Models\LabResultMessage::insert($messageData);
        }
    }


    private function getGender($string)
    {
        $gender = explode(' ', $string);

        return $gender[0];
    }


    // public function saveToLabResult($segments, $raw)
    // {
    //     // == Parse MSH ==
    //     $msh = $segments['MSH'][0] ?? null;

    //     // == Parse & Save Patient ==
    //     $pid = $segments['PID'][0] ?? null;
    //     if (!$pid) throw new \Exception("PID segment not found.");

    //     $medicalRecordNumber = $pid[1] ?? null;
    //     $patientName = $pid[5] ?? '';
    //     $birthDate = $pid[7] ?? null;
    //     $gender = $pid[8] ?? null;

    //     // Format nama pasien: ^Zhang San -> Zhang San
    //     $name = trim(str_replace('^', ' ', $patientName));

    //     $patient = \App\Models\Patient::firstOrCreate(
    //         ['medical_record_number' => $medicalRecordNumber],
    //         [
    //             'name' => $name,
    //             'birth_date' => $birthDate ? \Carbon\Carbon::parse($birthDate)->format('Y-m-d') : null,
    //             'gender' => $gender,
    //         ]
    //     );

    //     // == Parse PV1 ==
    //     $pv1 = $segments['PV1'][0] ?? [];
    //     $department = $pv1[3] ?? null;

    //     // == Parse OBR ==
    //     $obr = $segments['OBR'][0] ?? null;
    //     if (!$obr) throw new \Exception("OBR segment not found.");

    //     dd($segments['OBR']);

    //     $labNumber = $obr[3] ?? null;
    //     $testType = $obr[4] ?? '';
    //     $sampleTaken = $obr[6] ?? null;
    //     $resultDate = $obr[7] ?? null;
    //     $doctor = $obr[10] ?? null;

    //     // == Save Lab Result ==
    //     $labResult = \App\Models\LabResult::create([
    //         'patient_id' => $patient->id,
    //         'lab_number' => $labNumber,
    //         'test_type' => $testType,
    //         'sample_taken_at' => $sampleTaken ? \Carbon\Carbon::parse($sampleTaken) : null,
    //         'result_at' => $resultDate ? \Carbon\Carbon::parse($resultDate) : null,
    //         'doctor_name' => $doctor,
    //         'department' => $department,
    //     ]);


    //     // 'lab_parameter_id',
    //     // 'result_value',
    //     // 'unit',
    //     // 'reference_range',
    //     // 'result_date',


    //     // == Parse OBX Segments ==
    //     $obxSegments = $segments['OBX'] ?? [];
    //     // get code and id from LabParameter key by code
    //     $paramCodeDesc = LabParameter::pluck('id', 'code')->toArray();

    //     // $parameterCodes = array_map(function ($code) {
    //     dd($paramCodeDesc);
    //     // $obxSegments = array_filter($obxSegments, function ($obx) use ($parameterCodes) {
    //     //     $paramCodeDesc = $obx[3] ?? '';
    //     //     $parts = explode('^', $paramCodeDesc);
    //     //     $code = $parts[0] ?? null;
    //     //     $desc = $parts[1] ?? null;

    //     //     return true;
    //     // });

    //     foreach ($obxSegments as $obx) {
    //         $paramCodeDesc = $obx[3] ?? '';
    //         $result = $obx[5] ?? null;
    //         $unit = $obx[6] ?? null;
    //         $refRange = $obx[7] ?? null;

    //         // Safe parsing of code and description
    //         $parts = explode('^', $paramCodeDesc);
    //         $code = $parts[1] ?? null;

    //         // jika $code seperti WBC, etc tidak ada di $paramCodeDesc
    //         if (empty($code)) {
    //             continue;
    //         }

    //         // Save Detail Result
    //         \App\Models\LabResultDetail::create([
    //             'lab_result_id' => $labResult->id,
    //             'lab_parameter_id' => $paramCodeDesc[$code],
    //             'result' => $result,
    //             'unit' => $unit,
    //             'ref_range' => $refRange,
    //         ]);
    //     }
    // }
}
