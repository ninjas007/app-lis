<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use App\Models\Master\MasterJenisLayanan;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PasienHasilDetail;
use App\Models\Master\MasterRuangan;
use App\Models\Master\MasterStatusPasien;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasienController extends Controller
{
    public $page = 'pasien';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('patients.index', [
            'page' => $this->page,
            'title' => 'Pasien'
        ]);
    }

    public function show($uid)
    {
        $patient = Patient::where('uid', $uid)->first();
        if (!$patient) {
            return redirect()->back()->with('error', 'Pasien tidak ditemukan');
        }
        return view('patients.show', [
            'page' => $this->page,
            'title' => 'Detail Pasien',
            'patient' => $patient
        ]);
    }

    public function detail($pasienUid, $resultUid)
    {
        $pasien = Patient::where('uid', $pasienUid)->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Pasien tidak ditemukan');
        }

        $labResult = LabResult::where('uid', $resultUid)->first();

        if (!$labResult) {
            return redirect()->back()->with('error', 'Hasil lab tidak ditemukan');
        }

        $pasienHasilDetail = PasienHasilDetail::where('hasil_id', $labResult->id)
                ->where('patient_id', $pasien->id)
                ->first();

        $labResultDetail = $labResult->details()->get();
        $labResultImages = $labResult->resultImages()->get();
        $ruangans = MasterRuangan::get();
        $statusPasien = MasterStatusPasien::get();
        $jenisLayanan = MasterJenisLayanan::get();

        return view('patients.detail', [
            'page' => $this->page,
            'title' => 'Detail Pasien',
            'labResult' => $labResult,
            'pasien' => $pasien,
            'labDetails' => $labResultDetail,
            'labResultImages' => $labResultImages,
            'pasienHasilDetail' => $pasienHasilDetail,
            'ruangans' => $ruangans,
            'statusPasien' => $statusPasien,
            'jenisLayanan' => $jenisLayanan,
        ]);
    }

    public function print($pasienUid, $resultUid)
    {
        $pasien = Patient::where('uid', $pasienUid)->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Pasien tidak ditemukan');
        }

        $labResult = LabResult::where('uid', $resultUid)->first();

        if (!$labResult) {
            return redirect()->back()->with('error', 'Hasil lab tidak ditemukan');
        }

        $labResultDetail = $labResult->details()->get();
        $labResultImages = $labResult->resultImages()->get();
        $pasienHasilDetail = PasienHasilDetail::where('hasil_id', $labResult->id)
                            ->where('patient_id', $pasien->id)
                            ->first();

        // return view('patients.print');

        $pdf = Pdf::loadView('patients.print', [
            'page' => $this->page,
            'labResult' => $labResult,
            'pasien' => $pasien,
            'labDetails' => $labResultDetail,
            'labResultImages' => $labResultImages,
            'pasienHasilDetail' => $pasienHasilDetail
        ]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        return $pdf->stream("Hasil Lab $pasien->name.pdf");
    }

    public function saveDetail(Request $request, $pasienUid, $resultUid)
    {
        $this->validate($request, [
            'pasien_norm' => 'required',
        ], [
            'pasien_norm.required' => 'No RM harus diisi',
        ]);

        $pasien = Patient::where('uid', $pasienUid)->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Pasien tidak ditemukan');
        }

        $labResult = LabResult::where('uid', $resultUid)->first();

        if (!$labResult) {
            return redirect()->back()->with('error', 'Hasil lab tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $pasien->no_rm = $request->pasien_norm;
            $pasien->medical_record_number = $request->pasien_norm;
            $pasien->name = $request->pasien_nama;
            $pasien->birth_date = $request->pasien_lahir ? Carbon::parse($request->pasien_lahir)->format('Y-m-d') : null;
            $pasien->gender = $request->pasien_gender;
            $pasien->address = $request->pasien_alamat;

            $pasien->save();

            $labResult->lab_number = $request->hasil_no_lab;
            $labResult->result_at = $request->hasil_tanggal ? Carbon::parse($request->hasil_tanggal)->format('Y-m-d H:i:s') : null;
            $labResult->save();


            $pasienHasilDetail = PasienHasilDetail::where('hasil_id', $labResult->id)
                ->where('patient_id', $pasien->id)
                ->first();

            if (!$pasienHasilDetail) {
                $pasienHasilDetail = new PasienHasilDetail();
                $pasienHasilDetail->patient_id = $pasien->id;
                $pasienHasilDetail->hasil_id = $labResult->id;
                $pasienHasilDetail->uid = Str::uuid();
            }

            $pasienHasilDetail->diagnosa = $request->hasil_diagnosa;
            $pasienHasilDetail->catatan = $request->hasil_catatan;
            $pasienHasilDetail->dokter_pengirim = $request->hasil_dokter_pengirim;
            $pasienHasilDetail->dokter_penanggung_jawab = $request->hasil_dokter_penanggung_jawab;
            $pasienHasilDetail->ruangan_poli = $request->hasil_ruangan_poli;
            $pasienHasilDetail->petugas = $request->hasil_petugas;
            $pasienHasilDetail->verifikasi = $request->hasil_verifikasi;
            $pasienHasilDetail->status = $request->hasil_status_pasien;
            $pasienHasilDetail->jenis_layanan = $request->hasil_jenis_layanan;

            $pasienHasilDetail->save();

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logError($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan kontak admin');
        }
    }

    public function saveHasilPemeriksaan(Request $request, $pasienUid, $resultUid)
    {
        $pasien = Patient::where('uid', $pasienUid)->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Pasien tidak ditemukan');
        }

        $labResult = LabResult::where('uid', $resultUid)->first();

        if (!$labResult) {
            return redirect()->back()->with('error', 'Hasil lab tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $detailIds = $request->detail_ids;  // ID detail yang ingin di-update
            $parameterResults = $request->lab_parameter_result;  // Hasil lab dari request

            $cases = [];
            $bindings = [];
            $ids = [];

            foreach ($detailIds as $index => $id) {
                $cases[] = "WHEN id = ? THEN ?";
                $bindings[] = $id;
                $bindings[] = $parameterResults[$index]; // Ambil nilai result sesuai index
                $ids[] = $id;
            }

            // Susun query
            $query = "
                UPDATE lab_result_details
                SET result = CASE " . implode(' ', $cases) . " END
                WHERE id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")
            ";

            // Gabungkan bindings ID di akhir
            $bindings = array_merge($bindings, $ids);

            // Jalankan query
            DB::update($query, $bindings);

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logError($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan kontak admin');
        }
    }

    // public function preview($pasienUid, $resultUid)
    // {
    //     $pasien = Patient::where('uid', $pasienUid)->first();

    //     if (!$pasien) {
    //         return redirect()->back()->with('error', 'Pasien tidak ditemukan');
    //     }

    //     $labResult = LabResult::where('uid', $resultUid)->first();

    //     if (!$labResult) {
    //         return redirect()->back()->with('error', 'Hasil lab tidak ditemukan');
    //     }

    //     $labResultDetail = $labResult->details()->get();
    //     $labResultImages = $labResult->resultImages()->get();

    //     return view('patients.preview', [
    //         'page' => $this->page,
    //         'title' => 'Detail Pasien',
    //         'labResult' => $labResult,
    //         'pasien' => $pasien,
    //         'labDetails' => $labResultDetail,
    //         'labResultImages' => $labResultImages
    //     ]);
    // }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Patient::query();
            return DataTables::of($data)
                ->addColumn('hasil_lab', function ($row) {
                    return '<a href="/pasien/' . $row->uid . '" class="btn btn-sm btn-outline-primary" title="Hasil Lab">
                        <i class="fa fa-list"></i>
                    </a>';
                })
                ->addColumn('total_test', function ($row) {
                    return $row->labResults()->count();
                })
                ->addColumn('age', function ($row) {
                    if ($row->birth_date) {
                        return \Carbon\Carbon::parse($row->birth_date)->age . ' yrs';
                    } else {
                        return '-';
                    }
                })
                ->rawColumns(['hasil_lab', 'age'])
                ->make(true);
        }
    }

    public function getDataResult($uid)
    {
        $patient = Patient::where('uid', $uid)->first();

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pasien tidak ditemukan'
            ]);
        }

        $data = $patient->labResults()->with('details')->get();

        return DataTables::of($data)
            ->addColumn('detail', function ($row) {
                return '<a href="/pasien/' . $row->patient->uid . '/detail/' . $row->uid . '" class="btn btn-primary btn-sm text-white" title="Detail Hasil Lab">
                    <i class="fa fa-file"></i> Lihat
                </a>';
            })
            ->rawColumns(['detail'])
            ->make(true);
    }
}
