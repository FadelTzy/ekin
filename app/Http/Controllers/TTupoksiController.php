<?php

namespace App\Http\Controllers;

use App\Models\t_jabatan;
use App\Models\t_tupoksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\importTupoksi;

class TTupoksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = request()->input('id');
        if (request()->ajax()) {
            return datatables()->of(t_tupoksi::where('id_jab', $id)->get())->addIndexColumn()->addColumn('aksi', function ($data) {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyall()
    {
        if (request()->has('rb')) {
            $data = request()->input('rb');
            try {
                t_tupoksi::destroy($data);
                return "suc";
            } catch (\Throwable $th) {
                return "err";
            }
        }
        return "no";
    }
    public function storefile(Request $request)
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
                    if ($key == 0) {
                        continue;
                    }
                    $item = new t_tupoksi();
                    $item->id_jab = $i;
                    $item->hasil = $value[0];
                    $item->uraian = $value[1];
                    $item->save();
                }
                return "success";
            } catch (\Throwable $th) {
                return $th;
            }
        }
        return request()->all();
    }
    public function create(Request $request)
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
        $d = request()->input('name');
        $arr = array_chunk($d, 2);
        $i = request()->input('id');
        if ($d == null) {
            return 'null';
        }
        try {
            foreach ($arr as $key => $value) {
                if ($value[0] == '' || $value[1] == '') {
                    continue;
                }

                $item = new t_tupoksi();
                $item->id_jab = $i;
                $item->uraian = $value[0];
                $item->hasil = $value[1];
                $item->save();
            }
        } catch (\Throwable $th) {
            return $th;
        }


        return "d";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\t_tupoksi  $t_tupoksi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tupoksi = t_jabatan::where('id', $id)->first();
        return view('admin.jabatans.tambahtupoksi', compact('tupoksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\t_tupoksi  $t_tupoksi
     * @return \Illuminate\Http\Response
     */
    public function edit(t_tupoksi $t_tupoksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\t_tupoksi  $t_tupoksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, t_tupoksi $t_tupoksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\t_tupoksi  $t_tupoksi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = t_tupoksi::findOrFail($id);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
}
