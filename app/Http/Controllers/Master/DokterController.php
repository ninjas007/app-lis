<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Models\Master\MasterDokter as Dokter;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class DokterController extends Controller
{
    protected $page = 'dokter';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = Dokter::paginate(10);

        return view('dokter.index', [
            'page' => $this->page,
            'title' => 'Dokter',
            'dokters' => $dokters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokter.create', [
            'page' => $this->page,
            'title' => 'Tambah Dokter'
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
            $dokter = new Dokter();
            $dokter->uid = Str::uuid();
            $dokter->name = $request->name;
            $dokter->description = $request->description;
            $dokter->created_at = now();
            $dokter->updated_at = now();
            $dokter->save();

            return redirect()->route('master.dokter.index')->with('success', 'Data berhasil ditambahkan');
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
        return view('dokter.edit', [
            'page' => $this->page,
            'title' => 'Edit Dokter',
            'dokter' => Dokter::where('uid', $uid)->firstOrFail()
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
            $dokter = Dokter::where('uid', $uid)->firstOrFail();
            $dokter->name = $request->name;
            $dokter->description = $request->description;
            $dokter->updated_at = now();
            $dokter->save();

            return redirect()->route('master.dokter.index')->with('success', 'Data berhasil diubah');
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
        $dokter = Dokter::where('uid', $uid)->first();
        if (!$dokter) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        try {
            $dokter->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            $this->logError($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan, silahkan coba lagi']);
        }
    }
}
