<?php

namespace App\Http\Controllers;

use App\Models\Iku;
use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\Jabatan;
use App\Models\Unit;
use App\Models\statusJabDosen;
use Illuminate\Support\Facades\Validator;
use App\Models\Itemikudosen;

class IkuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Iku::all())->addIndexColumn()->addColumn('namaj', function ($data) {
                return $data->jabatan->jabatan;
            })->addColumn('unitj', function ($data) {
                return $data->unit->unit;
            })->addColumn('statusr', function ($data) {
                return $data->stat_id;
            })->addColumn('tupoks', function ($data) {
                $btn = '  <ul class="list-inline table-action m-0">';
                $btn .= '<li class="list-inline-item">
                    <a href="' . route("iku.show", $data->id) . '" class="action-icon">
                        <i class="mdi mdi-plus-box"></i> </a>   </li>';
                $btn .= '<li class="list-inline-item">
                    <a href="javascript:void(0);" onclick="lihatt(' . $data->id . ')" class="action-icon">';
                if ($data->item->count() == 0) {
                    $btn .= '<i class="mdi mdi-eye-outline"></i>';
                } else {
                    $btn .= '<i class="mdi mdi-eye"></i>';
                }
                $btn .= '</a> </li>  </ul>';
                return $btn;
            })->addColumn('aksi', function ($data) {
                $btn = '       <ul class="list-inline table-action m-0">';
                $btn .= '<li class="list-inline-item">
                    <a href="javascript:void(0);" onclick="updatej(' . $data->id . ')" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                </li>';
                $btn .= '
                <li class="list-inline-item">
                    <a href="javascript:void(0);" onclick="deletej(' . $data->id . ')" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                </li>
            </ul>';
                return $btn;
            })->rawColumns(['namaj', 'unitj', 'statusr', 'tupoks', 'aksi'])->make(true);
        }
        $jab = Jabatan::where('status_r', '!=', 'Tendik Biasa')->orderBy('jabatan')->get();
        $sfd = statusJabDosen::all();
        $unit = Unit::orderBy('unit')->get();
        $period = Periode::orderByDesc('tahun_ajar')->get();
        return view('admin.iku.index', compact('jab', 'unit', 'period', 'sfd'));
    }
    public function getsi()
    {
        return view('admin.iku.tabel');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->jab == "Pilih Jabatan" || $request->unit == "Pilih Unit" || $request->periode == "Pilih Periode") {
            return response()->json(['error' => 'error']);
        }
        $validator = Validator::make($request->all(), [
            'jab' => 'required',
            'unit' => 'required',
            'sfd' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $saved = Iku::create([
                'jab_id' => $request->jab,
                'unit_id' => $request->unit,
                'stat_id'  => $request->sfd


            ]);

            if ($saved) {

                return response()->json(['success' => 'Data Berhasil Terupload']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iku  $iku
     * @return \Illuminate\Http\Response
     */
    public function show(Iku $iku)
    {
        return view('admin.iku.tambahiku', compact('iku'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iku  $iku
     * @return \Illuminate\Http\Response
     */
    public function edit(Iku $iku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Iku  $iku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Iku $iku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iku  $iku
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iku $iku)
    {
        $data =  request()->input('data');
        $res = Iku::findOrFail($data);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
    public function gettupok($id)
    {

        $datatupok = Itemikudosen::where('iku_id', $id)->get();
        return view('admin.iku.tabeltupoksi', compact('datatupok'));
    }
    public function hapustupok()
    {
        $data =  request()->input('data');
        $res = Itemikudosen::findOrFail($data);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
    public function storetupok()
    {
        $d = request()->input('name');
        $i = request()->input('id');
        if ($d == null) {
            return 'null';
        }
        foreach ($d as $key => $value) {
            if ($value == '') {
                return 'error';
            }

            $item = new Itemikudosen();
            $item->iku_id = $i;
            $item->item = $value;
            $item->save();
        }
        return "d";
    }
}
