<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingAlat;
use App\Models\SettingGeneral;
use Illuminate\Support\Str;

class AlatController extends Controller
{
    protected $page = 'setting';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alats = SettingAlat::paginate(10);
        $limitConnection = SettingGeneral::where('key', 'limit_connection')->first();

        if ($limitConnection) {
            $limitConnection = json_decode($limitConnection->value);
        } else {
            return redirect()->route('setting.general')->with('warning', 'Limit Pengecekan Koneksi belum diatur');
        }

        return view('setting.alat.index', [
            'page' => $this->page,
            'title' => 'Setting Alat',
            'alats' => $alats,
            'limitConnection' => $limitConnection->value ?? 1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting.alat.create', [
            'page' => $this->page,
            'title' => 'Tambah Alat'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'ip_address' => 'required',
            'port' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Nama alat harus diisi',
            'ip_address.required' => 'IP Address alat harus diisi',
            'port.required' => 'Port alat harus diisi',
            'status.required' => 'Status alat harus diisi',
        ]);

        try {
            $alat = new SettingAlat();
            $alat->uid = Str::uuid();
            $alat->name = $request->name;
            $alat->ip_address = $request->ip_address;
            $alat->port = $request->port;
            $alat->status = $request->status;
            $alat->auto_connect = $request->auto_connect == 'on' ? 1 : 0;
            $alat->created_at = now();
            $alat->updated_at = now();

            $alat->save();

            return redirect()->route('setting.alat')->with('success', 'Alat berhasil ditambahkan');
        } catch (\Throwable $th) {
            $this->logError($th);
            return redirect()->route('setting.alat')->with('error', 'Alat gagal ditambahkan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uid)
    {
        $alat = SettingAlat::where('uid', $uid)->first();

        if (!$alat) {
            return redirect()->route('setting.alat')->with('error', 'Alat tidak ditemukan');
        }

        return view('setting.alat.edit', [
            'page' => $this->page,
            'title' => 'Edit Alat',
            'alat' => $alat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uid)
    {
        $this->validate($request, [
            'name' => 'required',
            'ip_address' => 'required',
            'port' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Nama alat harus diisi',
            'ip_address.required' => 'IP Address alat harus diisi',
            'port.required' => 'Port alat harus diisi',
            'status.required' => 'Status alat harus diisi',
        ]);

        try {
            $alat = SettingAlat::where('uid', $uid)->first();

            if (!$alat) {
                return redirect()->route('setting.alat')->with('error', 'Alat tidak ditemukan');
            }

            $alat->name = $request->name;
            $alat->ip_address = $request->ip_address;
            $alat->port = $request->port;
            $alat->status = $request->status;
            $alat->auto_connect = $request->auto_connect == 'on' ? 1 : 0;
            $alat->updated_at = now();
            $alat->save();

            return redirect()->route('setting.alat')->with('success', 'Alat berhasil diubah');
        } catch (\Throwable $th) {
            $this->logError($th);
            return redirect()->route('setting.alat')->with('error', 'Alat gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uid)
    {
        $alat = SettingAlat::where('uid', $uid)->first();

        if (!$alat) {
            return redirect()->route('setting.alat')->with('error', 'Alat tidak ditemukan');
        }

        try {
            $alat->delete();

            return redirect()->route('setting.alat')->with('success', 'Alat berhasil dihapus');
        } catch (\Throwable $th) {
            $this->logError($th);
            return redirect()->route('setting.alat')->with('error', 'Alat gagal dihapus');
        }
    }
}
