<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabParameter;
use Illuminate\Support\Str;

class ParameterController extends Controller
{
    protected $page = 'parameter';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parameters = LabParameter::paginate(10);

        return view('parameter.index', [
            'page' => $this->page,
            'title' => 'Parameter',
            'parameters' => $parameters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parameter.create', [
            'page' => $this->page,
            'title' => 'Tambah Parameter'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required:unique:lab_parameters',
            'name' => 'required',
        ], [
            'code.required' => 'Kode parameter harus diisi',
            'code.unique' => 'Kode parameter sudah ada',
            'name.required' => 'Nama parameter harus diisi',
        ]);

        try {
            $parameter = new LabParameter();
            $parameter->uid = Str::uuid();
            $parameter->code = $request->code;
            $parameter->name = $request->name;
            $parameter->loinc_code = $request->loinc_code;
            $parameter->default_unit = $request->default_unit;
            $parameter->default_ref_range = $request->default_ref_range;
            $parameter->save();

            return redirect()->route('parameter.index')->with('success', 'Parameter berhasil ditambahkan');
        } catch (\Exception $e) {
            $this->logError($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('parameter.edit', [
            'page' => $this->page,
            'title' => 'Edit Parameter',
            'parameter' => LabParameter::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
        ], [
            'code.required' => 'Kode parameter harus diisi',
            'name.required' => 'Nama parameter harus diisi',
        ]);

        try {
            $parameter = LabParameter::find($id);
            $parameter->code = $request->code;
            $parameter->name = $request->name;
            $parameter->loinc_code = $request->loinc_code;
            $parameter->default_unit = $request->default_unit;
            $parameter->default_ref_range = $request->default_ref_range;
            $parameter->save();

            return redirect()->route('parameter.index')->with('success', 'Parameter berhasil diubah');
        } catch (\Exception $e) {
            $this->logError($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $parameter = LabParameter::findOrFail($id);

        try {
            $parameter->delete();

            return response()->json(['status' => 'success', 'message' => 'Parameter berhasil dihapus']);
        } catch (\Exception $e) {
            $this->logError($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan, silahkan coba lagi']);
        }
    }
}
