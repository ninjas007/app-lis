<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LabResult;
use Carbon\Carbon;

class LabResultController extends Controller
{
    private $page = 'hasil';

    public function index()
    {
        return view('hasil.index', [
            'page' => $this->page,
            'title' => 'Hasil Lab'
        ]);
    }

    public function getData()
    {
        $labResults = LabResult::query();
        $labResults->with(['details.labParameter', 'patient']);

        return DataTables::of($labResults)
            ->addColumn('medical_record_number', function ($row) {
                if ($row->patient->medical_record_number == "") {
                    return '-';
                }

                return $row->patient->medical_record_number ?? '-';
            })
            ->addColumn('pasien', function ($row) {
                return '<a href="/pasien/' . $row->patient->uid . '" target="_blank"><strong>' . $row->patient->name . '</strong>
                    <span class="badge text-white bg-primary">' . $row->patient->gender . '</span>
                </a>';
            })
            ->editColumn('sample_taken_at', function ($row) {
                return Carbon::parse($row->sample_taken_at)->format('d-m-Y H:i:s');
            })
            ->rawColumns(['pasien'])
            ->make(true);
    }
}
