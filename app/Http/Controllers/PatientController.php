<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
class HL7LabResultController extends Controller
{
    public function index(Request $request)
    {
       $results = Patient::with(['labResults', 'labResults.details', 'labResults.details.labParameter'])
            ->when($request->filled('search_name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search_name') . '%');
            })
            ->when($request->filled('search_mrn'), function ($query) use ($request) {
                $query->where('medical_record_number', 'like', '%' . $request->input('search_mrn') . '%');
            })
            ->latest()
            ->paginate(10);

        return view('patients.index', compact('results'));
    }
}
