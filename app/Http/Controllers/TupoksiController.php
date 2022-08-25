<?php

namespace App\Http\Controllers;

use App\Models\Tupoksi;
use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use App\Models\Itemtupok;
use App\Models\Periode;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\importTupoksi;
use App\Models\t_jabatan;
use App\Models\t_tupoksi;

class TupoksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Tupoksi::all())->addIndexColumn()->addColumn('namaj', function ($data) {
                return $data->jabatan->jabatan;
            })->addColumn('unitj', function ($data) {
                return $data->unit->unit;
            })->addColumn('statusr', function ($data) {
                return $data->jabatan->status_r;
            })->addColumn('tupoks', function ($data) {
                $btn = '  <ul class="list-inline table-action m-0">';
                $btn .= '<li class="list-inline-item">
                    <a href="' . route("tupoksi.show", $data->id) . '" class="action-icon">
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
        $jab = Jabatan::where('status_k', 'tendik')->orderBy('jabatan')->get();
        $unit = Unit::orderBy('unit')->get();
        return view('admin.tupoksi.index', compact('jab', 'unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showtupok($id)
    {
        $datat = t_tupoksi::where('id_jab', $id)->get();
        $jab = t_jabatan::find($id);
        return view('admin.tupoksi.lihattupok', compact('datat', 'jab'));
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
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $saved = Tupoksi::create([
                'jab_id' => $request->jab,
                'unit_id' => $request->unit,


            ]);

            if ($saved) {

                return response()->json(['success' => 'Data Berhasil Terupload']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tupoksi  $tupoksi
     * @return \Illuminate\Http\Response
     */
    public function show(Tupoksi $tupoksi)
    {

        return view('admin.tupoksi.tambahtupoksi', compact('tupoksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tupoksi  $tupoksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Tupoksi $tupoksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tupoksi  $tupoksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tupoksi $tupoksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tupoksi  $tupoksi
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $data =  request()->input('data');
        $res = Tupoksi::findOrFail($data);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }

    //item
    public function hapustupok()
    {
        $data =  request()->input('data');
        $res = Itemtupok::findOrFail($data);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
    public function updatetupok($id)
    {
        $validator = Validator::make(request()->all(), [
            'item' => 'required|min:2|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $jabat = Itemtupok::find($id);
            $jabat->item = request()->input('item');
            $jabat->save();
            // $jabat->jabatan = $jabatan->
            return response()->json(['success' => 'Data Berhasil Terupload']);
        }
    }
    public function gettupok($id)
    {

        if (request()->ajax()) {
            return datatables()->of(Itemtupok::where('jab_id', $id)->get())->addIndexColumn()->addColumn('aksi', function ($data) {
                $btn = '<ul class="list-inline table-action m-0">';
                $btn .= '<li class="list-inline-item">
                    <a href="javascript:void(0);" onclick="updatej(' . $data->id . ')" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                </li>';
                $btn .= '<li class="list-inline-item">
                    <a href="javascript:void(0);" onclick="deletej(' . $data->id . ')" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                </li>
            </ul>';
                return $btn;
            })->addColumn('rb', function ($data) {
                return '<div class="form-check"><input class="form-check-input itemdel" name="rb[]" type="checkbox" value="' . $data->id . '" id="flexCheckChecked"></div>';
            })->rawColumns(['aksi', 'rb'])->make(true);
        }
    }
    public function edittupok($id)
    {
        $data = Itemtupok::find($id);
        if ($data != null) {
            # code...
            return $data;
        }
        return false;
    }
    public function hapusitem()
    {
        if (request()->has('rb')) {
            $data = request()->input('rb');
            try {
                Itemtupok::destroy($data);
                return "suc";
            } catch (\Throwable $th) {
                return "err";
            }
        }
        return "no";
    }
    public function storetupok2(Request $request)
    {

        if (request()->hasFile('upload')) {
            try {
                $request->validate([
                    'upload' => 'required'
                ]);
                $path = request()->file('upload')->getRealPath();
                $i = request()->input('id');
                $array = Excel::toArray(new importTupoksi, request()->file('upload'));

                foreach ($array[0] as $key => $value) {

                    $item = new Itemtupok();
                    $item->jab_id = $i;
                    $item->item = $value[0];
                    $item->save();
                }
                return "success";
            } catch (\Throwable $th) {
                return $th;
            }
        }
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
                continue;
            }

            $item = new Itemtupok();
            $item->jab_id = $i;
            $item->item = $value;
            $item->save();
        }
        return "d";
    }
}
