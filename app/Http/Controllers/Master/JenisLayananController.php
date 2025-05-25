<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Models\Master\MasterJenisLayanan as JenisLayanan;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class JenisLayananController extends Controller
{
    protected $page = 'jenislayanan';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisLayanan = JenisLayanan::paginate(10);

        return view('jenis_layanan.index', [
            'page' => $this->page,
            'title' => 'Jenis Layanan',
            'jenisLayanan' => $jenisLayanan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis_layanan.create', [
            'page' => $this->page,
            'title' => 'Tambah Jenis Layanan'
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
            $jenisLayanan = new JenisLayanan();
            $jenisLayanan->uid = Str::uuid();
            $jenisLayanan->name = $request->name;
            $jenisLayanan->description = $request->description;
            $jenisLayanan->created_at = now();
            $jenisLayanan->updated_at = now();
            $jenisLayanan->save();

            return redirect()->route('master.jenis-layanan.index')->with('success', 'Data berhasil ditambahkan');
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
        return view('jenis_layanan.edit', [
            'page' => $this->page,
            'title' => 'Edit Jenis Layanan',
            'jenisLayanan' => JenisLayanan::where('uid', $uid)->firstOrFail()
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
            'name.required' => 'Nama jenis layanan harus diisi',
        ]);

        try {
            $jenisLayanan = JenisLayanan::where('uid', $uid)->firstOrFail();
            $jenisLayanan->name = $request->name;
            $jenisLayanan->description = $request->description;
            $jenisLayanan->updated_at = now();
            $jenisLayanan->save();

            return redirect()->route('master.jenis-layanan.index')->with('success', 'Data berhasil diubah');
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
        $jenisLayanan = JenisLayanan::where('uid', $uid)->first();
        if (!$jenisLayanan) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        try {
            $jenisLayanan->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            $this->logError($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan, silahkan coba lagi']);
        }
    }
}
