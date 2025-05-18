<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\LabResult;

class DashboardController extends Controller
{
    public $page = 'dashboard';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPasien = Patient::count();
        $totalHasilLab = LabResult::count();
        $totalPending = LabResult::whereNull('result_at')->count();
        $totalSelesai = $totalHasilLab - $totalPending;
        $hasilLabTerbaruList = LabResult::with(['patient', 'details', 'details.labParameter'])
                ->orderBy('created_at', 'desc')
                ->limit(5)->get();

        return view('dashboard.index', [
            'page' => $this->page,
            'title' => 'Dashboard',
            'hasilLabTerbaruList' => $hasilLabTerbaruList,
            'totalPasien' => $totalPasien,
            'totalHasilLab' => $totalHasilLab,
            'totalPending' => $totalPending,
            'totalSelesai' => $totalSelesai
        ]);
    }
}
