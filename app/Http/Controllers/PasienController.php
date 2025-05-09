<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use Illuminate\Http\Request;
use App\Models\Patient;
use Yajra\DataTables\Facades\DataTables;

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

        $labResultDetail = $labResult->details()->get();
        $labResultImages = $labResult->resultImages()->get();

        return view('patients.detail', [
            'page' => $this->page,
            'title' => 'Detail Pasien',
            'labResult' => $labResult,
            'pasien' => $pasien,
            'labDetails' => $labResultDetail,
            'labResultImages' => $labResultImages
        ]);
    }

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
