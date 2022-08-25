<?php

namespace App\Http\Controllers;

use App\Models\t_jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(t_jabatan::all())->addIndexColumn()->addColumn('tupoks', function ($data) {
                $btn = '  <ul class="list-inline table-action m-0">';
                $btn .= '<li class="list-inline-item">
                    <a href="' . route("tupoksis.show", $data->id) . '" class="action-icon">
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
            })->addColumn('statusbtn', function ($data) {
                if ($data->status == 1) {
                    $btn = "<div class='badge badge-success'> Aktif </div>";
                } else {
                    $btn = "<div class='badge badge-danger'> Non </div>";
                }
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
            })->rawColumns(['tupoks', 'aksi', 'statusbtn'])->make(true);
        }

        return view('admin.jabatans.index');
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
        try {
            $validator = Validator::make($request->all(), [
                'jabatan' => 'required|min:1|max:100',
                'kode' => 'required|min:1|max:10',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            } else {
                $saved = t_jabatan::create([
                    'kode' => $request->kode,
                    'jabatan' => $request->jabatan,
                    'status' => $request->status == "on" ? 1 : 2
                ]);

                if ($saved) {
                    return response()->json(['success' => 'Data Berhasil Terupload']);
                }
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\t_jabatan  $t_jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(t_jabatan $t_jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\t_jabatan  $t_jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(t_jabatan $t_jabatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\t_jabatan  $t_jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, t_jabatan $t_jabatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\t_jabatan  $t_jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = t_jabatan::findOrFail($id);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
}
