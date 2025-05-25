<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Models\Master\MasterRuangan as Ruangan;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class RuanganController extends Controller
{
    protected $page = 'ruangan';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangans = Ruangan::paginate(10);

        return view('ruangan.index', [
            'page' => $this->page,
            'title' => 'ruangan',
            'ruangans' => $ruangans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ruangan.create', [
            'page' => $this->page,
            'title' => 'Tambah ruangan'
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
            'name.required' => 'Nama ruangan harus diisi',
        ]);

        try {
            $ruangan = new Ruangan();
            $ruangan->uid = Str::uuid();
            $ruangan->name = $request->name;
            $ruangan->description = $request->description;
            $ruangan->created_at = now();
            $ruangan->updated_at = now();
            $ruangan->save();

            return redirect()->route('master.ruangan.index')->with('success', 'Data berhasil ditambahkan');
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
        return view('ruangan.edit', [
            'page' => $this->page,
            'title' => 'Edit ruangan',
            'ruangan' => Ruangan::where('uid', $uid)->firstOrFail()
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
            'name.required' => 'Nama ruangan harus diisi',
        ]);

        try {
            $ruangan = Ruangan::where('uid', $uid)->firstOrFail();
            $ruangan->name = $request->name;
            $ruangan->description = $request->description;
            $ruangan->updated_at = now();
            $ruangan->save();

            return redirect()->route('master.ruangan.index')->with('success', 'Data berhasil diubah');
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
        $ruangan = Ruangan::where('uid', $uid)->first();
        if (!$ruangan) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        try {
            $ruangan->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            $this->logError($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan, silahkan coba lagi']);
        }
    }
}
