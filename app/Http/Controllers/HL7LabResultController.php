<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabResult;

class HL7LabResultController extends Controller
{
    public function index(Request $request)
    {
        $query = LabResult::with(['patient', 'details', 'details.labParameter']);

        if ($request->filled('search_name') || $request->filled('search_mrn')) {
            $query->whereHas('patient', function ($q) use ($request) {
                if ($request->filled('search_name')) {
                    $q->where('name', 'like', '%' . $request->input('search_name') . '%');
                }
                if ($request->filled('search_mrn')) {
                    $q->where('medical_record_number', 'like', '%' . $request->input('search_mrn') . '%');
                }
            });
        }

        $results = $query->latest()->paginate(10);

        return view('hl7.index', compact('results'));
    }
}
