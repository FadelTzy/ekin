<?php

namespace App\Http\Controllers;

use App\Models\Perdtahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Peginfo;

class PerdtahunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'awal' => 'required',
            'akhir' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            try {
                if (Auth::check()) {
                    $id_p =  Auth::user()->id_peg;

                    $id = Peginfo::where('id_peg', $id_p)->first();
                    $id_atasan = $id->id_atasan ?? '0';
                    $id_pa = $id->id_ppa ?? '0';
                    $awal = Request()->input('awal');
                    $akhir = Request()->input('akhir');
                    $awalt = explode("-", $awal)[2];
                    $akhirt = explode("-", $akhir)[2];
                    $saved = Perdtahun::create([
                        'awal' => $awal,
                        'akhir' => $akhir,
                        'tahun' => $awalt == $akhirt ? $akhirt : $awalt . '-' . $akhirt,
                        'id_peg' => $id_p,
                        'status' => 0,
                        'status_a' => 0,
                        'id_atasan' => $id_atasan,
                        'id_pa' => $id_pa
                    ]);
                    if ($saved) {

                        return response()->json(['success' => 'Data Berhasil Terupload']);
                    }
                }
                return 'ca';
            } catch (\Throwable $th) {
                return $th;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perdtahun  $perdtahun
     * @return \Illuminate\Http\Response
     */
    public function show(Perdtahun $perdtahun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perdtahun  $perdtahun
     * @return \Illuminate\Http\Response
     */
    public function edit(Perdtahun $perdtahun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perdtahun  $perdtahun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perdtahun $perdtahun)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perdtahun  $perdtahun
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Perdtahun::findOrFail($id);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
}
