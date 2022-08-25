<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Statusremun;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Jabatan::all())->addIndexColumn()->make(true);
        }
        return view('admin.jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jabatan.createj');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jabatan' => 'required|min:2|max:50',
            'ket' => 'max:200'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $saved = Jabatan::create([
                'jabatan' => $request->jabatan,
                'status_k' => $request->statuskepe,
                'status_r' => $request->statusremun,
                'keterangan' => $request->ket
            ]);

            if ($saved) {
                session()->flash('message', 'Berhasil Menambah Data');

                return response()->json(['success' => 'Data Berhasil Terupload']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        if ($jabatan != null) {
            # code...
            return $jabatan;
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jabatan-e' => 'required|min:2|max:50',
            'ket-e' => 'max:200'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $jabat = Jabatan::find($id);
            $jabat->jabatan = request()->input('jabatan-e');
            $jabat->keterangan = request()->input('ket-e');
            $jabat->status_r = request()->input('statusremun-e');
            $jabat->status_k = request()->input('statuskepe-e');

            $jabat->save();
            // $jabat->jabatan = $jabatan->
            return response()->json(['success' => 'Data Berhasil Terupload']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $data =  request()->input('data');
        $res = Jabatan::findOrFail($data);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
    public function gethem()
    {
        $datajabat = Jabatan::latest()->get();
        return view('admin.jabatan.tabel', compact('datajabat'));
    }
}
