<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Models\Master\MasterPetugas as Petugas;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class PetugasController extends Controller
{
    protected $page = 'petugas';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petugas = Petugas::paginate(10);

        return view('petugas.index', [
            'page' => $this->page,
            'title' => 'Petugas',
            'petugas' => $petugas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.create', [
            'page' => $this->page,
            'title' => 'Tambah Petugas'
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
            $petugas = new Petugas();
            $petugas->uid = Str::uuid();
            $petugas->name = $request->name;
            $petugas->description = $request->description;
            $petugas->created_at = now();
            $petugas->updated_at = now();
            $petugas->save();

            return redirect()->route('master.petugas.index')->with('success', 'Data berhasil ditambahkan');
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
        return view('petugas.edit', [
            'page' => $this->page,
            'title' => 'Edit Petugas',
            'petugas' => Petugas::where('uid', $uid)->firstOrFail()
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
            'name.required' => 'Nama harus diisi',
        ]);

        try {
            $petugas = Petugas::where('uid', $uid)->firstOrFail();
            $petugas->name = $request->name;
            $petugas->description = $request->description;
            $petugas->updated_at = now();
            $petugas->save();

            return redirect()->route('master.petugas.index')->with('success', 'Data berhasil diubah');
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
        $dokter = Petugas::where('uid', $uid)->first();
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
