<?php

namespace App\Http\Controllers;

use App\Models\t_periode;
use App\Models\t_periodetahunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class TPeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(t_periode::all())->addIndexColumn()->addColumn('status', function ($data) {
                if ($data->status_aktif == 1) {
                    return "<div class='badge badge-primary'>Aktif</div>";
                } else {
                    return "<div class='badge badge-danger'>Non Aktif</div>";
                }
            })->addColumn('aksi', function ($data) {
                $btn = '<div class="d-flex">';
                $btn .= "<a onclick='upd(" . $data . ")' class='pr-2' type='button'> <i class='mdi mdi-square-edit-outline'> </i> </a>";
                $btn .= '<a onclick="del(' . $data->id . ')"  type="button"> <i class="mdi mdi-delete"> </i> </a>';

                $btn .= '</div>';
                return $btn;
            })->addColumn('set', function ($data) {
                $btns = '<a onclick="set(' . $data->id . ')" class="btn btn-success btn-sm waves-effect waves-light mb-2" >Set</a>';

                return $btns;
            })->rawColumns(['status', 'aksi', 'set'])->make(true);
        }
        return view('admin.periodes.index');
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

            $year = request()->input('awal');
            $awals1 = date('01-M-Y', strtotime('January 01' . ' ' . $year));
            $akhirs1 = date('t-M-Y', strtotime('June 01' . ' ' . $year));
            $awals2 = date('01-M-Y', strtotime('july 01' . ' ' . $year));
            $akhirs2 = date('t-M-Y', strtotime('december 01' . ' ' . $year));

            $bulan1 =  'Januari' . ' - ' . 'Juni' . ' ' . $year;
            $bulan2 =  'Juli' . ' - ' . 'Desember' . ' ' . $year;
            $nama1 = str_replace('-', ' ', $awals1)  . ' - ' . str_replace('-', ' ', $akhirs1);
            $nama2 = str_replace('-', ' ', $awals2) . ' - ' . str_replace('-', ' ', $akhirs2);

            $saved = t_periode::updateOrCreate(
                [
                    'tahun' => $year,
                    'semester' => 1,
                ],
                [
                    'awal' => $awals1,
                    'akhir' =>  $akhirs1,
                    'nama_periode' => $nama1,
                    'semester' => 1,
                    'status_aktif' => 0,
                    'sa' => 0,
                    'status_bulan' =>  $bulan1,
                    'tahun' => $year,
                ]
            );
            $saved = t_periode::updateOrCreate(
                [
                    'tahun' => $year,
                    'semester' => 2,
                ],
                [
                    'awal' =>  $awals2,
                    'akhir' =>  $akhirs2,
                    'nama_periode' => $nama2,
                    'semester' => 2,
                    'status_aktif' => 0,
                    'sa' => 0,
                    'status_bulan' =>  $bulan2,
                    'tahun' => $year,
                ]
            );
            if ($saved) {
                t_periodetahunan::updateOrCreate([
                    'tahun' => $year
                ]);
            }
            return 'success';
        } catch (\Throwable $th) {
            return $th;
        }
        return request()->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\t_periode  $t_periode
     * @return \Illuminate\Http\Response
     */
    public function show(t_periode $t_periode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\t_periode  $t_periode
     * @return \Illuminate\Http\Response
     */
    public function edit(t_periode $t_periode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\t_periode  $t_periode
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'nama' => 'required|min:2|max:30',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            } else {
                $stat = request()->input('status');
                if ($stat) {
                    t_periode::where('status_aktif', 1)->update(['status_aktif' => 0]);
                }
                $awalt = explode("-", request()->input('awal'))[2];
                $akhirt = explode("-", request()->input('akhir'))[2];
                $tahun = $awalt == $akhirt ? $awalt : $awalt . '-' . $akhirt;
                setlocale(LC_TIME, 'id_ID');
                $bulan_a = Carbon::parse(request()->input('awal'))->translatedFormat('F');
                $bulan_ak = Carbon::parse(request()->input('akhir'))->translatedFormat('F');
                $bulan =  $bulan_a . ' - ' . $bulan_ak . ' ' . $tahun;
                if (!$request->status) {
                    $request->status = "off";
                }
                $saved = t_periode::where('id', $id)->update([
                    'awal' => date("Y-m-d", strtotime($request->awal)),
                    'akhir' => date("Y-m-d", strtotime($request->akhir)),
                    'nama_periode' => $request->nama,
                    'semester' => $request->smsr,
                    'status_aktif' => $request->status == "on" ? 1 : 0,
                    'sa' => 0,


                ]);
                return $bulan;
            }
        } catch (\Throwable $th) {
            return $th;
        }
        return request()->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\t_periode  $t_periode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = t_periode::findOrFail($id);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
    public function set()
    {
        try {
            $id = request()->input('id');

            if ($id) {
                t_periode::where('status_aktif', 1)->update(['status_aktif' => 0]);
                t_periode::where('id', $id)->update(['status_aktif' => 1]);
            }
            return "success";
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
