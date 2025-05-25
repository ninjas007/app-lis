<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Models\Master\MasterStatusPasien as StatusPasien;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class StatusPasienController extends Controller
{
    protected $page = 'statusPasien';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statusPasiens = StatusPasien::paginate(10);

        return view('status_pasien.index', [
            'page' => $this->page,
            'title' => 'Status Pasien',
            'statusPasiens' => $statusPasiens
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('status_pasien.create', [
            'page' => $this->page,
            'title' => 'Tambah Status Pasien'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'Nama harus diisi',
        ]);

        try {
            $statusPasien = new StatusPasien();
            $statusPasien->uid = Str::uuid();
            $statusPasien->name = $request->name;
            $statusPasien->description = $request->description;
            $statusPasien->created_at = now();
            $statusPasien->updated_at = now();
            $statusPasien->save();

            return redirect()->route('master.status-pasien.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            $this->logError($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uid)
    {
        return view('status_pasien.edit', [
            'page' => $this->page,
            'title' => 'Edit Status Pasien',
            'statusPasien' => StatusPasien::where('uid', $uid)->firstOrFail()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uid)
    {
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'Nama Status harus diisi',
        ]);

        try {
            $statusPasien = StatusPasien::where('uid', $uid)->firstOrFail();
            $statusPasien->name = $request->name;
            $statusPasien->description = $request->description;
            $statusPasien->updated_at = now();
            $statusPasien->save();

            return redirect()->route('master.status-pasien.index')->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            $this->logError($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uid)
    {
        $statusPasien = StatusPasien::where('uid', $uid)->first();
        if (!$statusPasien) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        try {
            $statusPasien->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            $this->logError($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan, silahkan coba lagi']);
        }
    }
}
