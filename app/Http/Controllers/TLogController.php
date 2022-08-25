<?php

namespace App\Http\Controllers;

use App\Models\Manajemen_p;
use App\Models\t_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\t_periode;
use App\Models\target_semester;
use  Illuminate\Support\Facades\Auth;

class TLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function item()
    {
        try {
            if (request()->ajax()) {
                if (Session::has('period')) {
                    $id_peg = Auth::user()->id_peg;
                    $id = Session::get('period');
                    $id_mn = Manajemen_p::where('id_ped', $id)->where('id_peg', $id_peg)->first();
                }
                $id  = request()->input('id');

                return datatables()->of(t_log::where('bulan', $id)->where('id_mn', $id_mn->id)->get())->addIndexColumn()->addColumn('inputtgl', function ($data) {
                    return date('Y-m-d H:s', strtotime($data->updated_at));
                })->addColumn('kegiatan', function ($data) {
                    return $data->target->kegiatan;
                })->addColumn('output', function ($data) {
                    return $data->kuantitas  . ' ' . $data->satuan;
                })->addColumn('aksi', function ($data) {
                    $b = "<button class='btn btn-sm btn-bordered-warning waves-effect waves-light mr-1' onclick='editj(" . json_encode($data) . ")'> <i class='fas fa-edit'></i></button>";
                    $b .= "<button type='button' class='btn btn-sm btn-bordered-danger waves-effect  mr-1 waves-light' onclick=delj('" . $data->id . "')> <i class='fa fa-trash'></i> </button>";
                    $b .= "<button type='button' class='btn btn-sm btn-bordered-info waves-effect waves-light' onclick='lg(" . json_encode($data) . ")'> <i class='far fa-file-image'></i> </button>";
                    return $b;
                })->rawColumns(['output', 'aksi', 'kegiatan', 'inputtgl'])->make(true);
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function itemtargets()
    {
        try {
            if (request()->ajax()) {
                if (Session::has('period')) {
                    $id_peg = Auth::user()->id_peg;
                    $id = Session::get('period');
                    $id_mn = Manajemen_p::where('id_ped', $id)->where('id_peg', $id_peg)->first();
                }
                $id  = request()->input('id');
                $bul  = request()->input('bul');


                return datatables()->of(t_log::where('id_mn', $id)->where('bulan', $bul)->get())->addIndexColumn()->addColumn('inputtgl', function ($data) {
                    return date('Y-m-d H:s', strtotime($data->updated_at));
                })->addColumn('kegiatan', function ($data) {
                    return $data->target->kegiatan;
                })->addColumn('output', function ($data) {
                    return $data->kuantitas  . ' ' . $data->satuan;
                })->addColumn('aksi', function ($data) {

                    $b = "<button type='button' class='btn btn-sm btn-bordered-info waves-effect waves-light' onclick='lg(" . json_encode($data) . ")'> <i class='far fa-file-image'></i> </button>";
                    return $b;
                })->rawColumns(['output', 'inputtgl', 'kegiatan', 'aksi'])->make(true);
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function itemtarget()
    {
        try {
            if (request()->ajax()) {
                if (Session::has('period')) {
                    $id_peg = Auth::user()->id_peg;
                    $id = Session::get('period');
                    $id_mn = Manajemen_p::where('id_ped', $id)->where('id_peg', $id_peg)->first();
                }
                $id  = request()->input('id');

                return datatables()->of(t_log::where('id_target', $id)->get())->addIndexColumn()->addColumn('kegiatan', function ($data) {
                    return $data->target->kegiatan;
                })->addColumn('inputtgl', function ($data) {
                    return date('Y-m-d H:s', strtotime($data->updated_at));
                })->addColumn('output', function ($data) {
                    return $data->kuantitas  . ' ' . $data->satuan;
                })->addColumn('aksi', function ($data) {

                    $b = "<button type='button' class='btn btn-sm btn-bordered-info waves-effect waves-light' onclick='lg(" . json_encode($data) . ")'> <i class='far fa-file-image'></i> </button>";
                    return $b;
                })->rawColumns(['output', 'inputtgl', 'aksi', 'kegiatan'])->make(true);
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function get()
    {
        if (Session::has('period')) {
            $id_peg = Auth::user()->id_peg;
            $id = Session::get('period');
            $id_mn = Manajemen_p::where('id_ped', $id)->where('id_peg', $id_peg)->first();
        }
        $month = explode('-', request()->input('date'))[1];
        $item = target_semester::where('bulan', $month)->where('id_ped', $id_mn->id)->get();
        $btn = '';

        if (request()->ajax()) {
            return datatables()->of(target_semester::where('bulan', $month)->where('id_ped', $id_mn->id)->get())->addIndexColumn()->addColumn('tupoksi', function ($data) {
                return $data->tupoksi->uraian;
            })->addColumn('Aksi', function ($data) {
                $btn = ' <button  onclick="copy(\'' . $data->kegiatan . '\',\'' . $data->id . '\')" class="btn why btn-sm btn-bordered-warning waves-effect waves-light">C</button>';
                return $btn;
            })->rawColumns(['Aksi', 'tupoksi'])->make(true);
        }


        return $btn;
    }
    public function index()
    {
        $smstr1 = [
            ['no' => 1, 'bulan' => 'Januari'],
            ['no' => 2, 'bulan' => 'Februari'],
            ['no' => 3, 'bulan' => 'Maret'],
            ['no' => 4, 'bulan' => 'April'],
            ['no' => 5, 'bulan' => 'Mei'],
            ['no' => 6, 'bulan' => 'Juni'],

        ];
        $smstr2 = [
            ['no' => 7, 'bulan' => 'Juli'],
            ['no' => 8, 'bulan' => 'Agustus'],
            ['no' => 9, 'bulan' => 'September'],
            ['no' => 10, 'bulan' => 'Oktober'],
            ['no' => 11, 'bulan' => 'November'],
            ['no' => 12, 'bulan' => 'Desember'],

        ];
        if (Session::has('period')) {
            $id = Session::get('period');
            $id_peg = Auth::user()->id_peg;
            $smst = '';
            $ids = '';
            $id_mn = Manajemen_p::where('id_ped', $id)->where('id_peg', $id_peg)->first() ?? "null";
            $datap = t_periode::where('id', $id)->first();
            if ($id_mn != "null") {
                $ids = $id_mn->status_target;
                if ($datap->semester == 1) {
                    foreach ($smstr1 as $key => $value) {
                        $data =  t_log::where('id_mn', $id_mn->id)->where('bulan', $value['no'])->count();
                        $smstr1[$key]["nilai"] = $data;
                    }
                    $smst = json_decode(json_encode($smstr1));
                } else {
                    foreach ($smstr2 as $key => $value) {
                        $data =  t_log::where('id_mn', $id_mn->id)->where('bulan', $value['no'])->count();
                        $smstr2[$key]["nilai"] = $data;
                    }
                    $smst = json_decode(json_encode($smstr2));
                }
            }
        }
        Session::flash('id_periode', $id_mn);
        Session::flash('id_status', $ids);

        return view('user.logharian.index', compact('smst', 'datap'))->with('hai', 'hai');
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
        if (Session::has('period')) {
            $id_peg = Auth::user()->id_peg;
            $id = Session::get('period');
            $id_mn = Manajemen_p::select('id')->where('id_ped', $id)->where('id_peg', $id_peg)->first();
            $month = explode('-', request()->input('awal'))[1];
            try {
                if (request()->file('gambar')) {
                    $gmbr = request()->file('gambar');

                    $nama_file = str_replace(' ', '_', time() . "_" . $gmbr->getClientOriginalName());
                    $tujuan_upload = 'image/log';
                    $gmbr->move($tujuan_upload, $nama_file);
                }
                $saved = t_log::create([
                    'id_mn' => $id_mn->id,
                    'gambar' => $nama_file ?? null,
                    'id_target' => $request->idtugas,
                    'tanggal' => date('Y-m-d', strtotime($request->awal)),
                    'bulan' => $month,
                    'ket' => $request->keterangan,
                    'kuantitas' => $request->kuantitas,
                    'satuan' => $request->satuan,
                ]);
                return 'success';
            } catch (\Throwable $th) {
                return $th;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\t_log  $t_log
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request)
    {
        try {
            $month = explode('-', request()->input('awal'))[1];
            if (request()->file('gambar')) {
                $gmbr = request()->file('gambar');

                $data = t_log::where('id', request()->input('id'))->first();
                if ($data->gambar) {
                    $path = 'image/log' . $data->gambar;
                    if (file_exists(public_path() . $path)) {
                        unlink(public_path() . $path);
                    }
                }
                $nama_file = str_replace(' ', '_', time() . "_" . $gmbr->getClientOriginalName());
                $tujuan_upload = 'image/log';
                $gmbr->move($tujuan_upload, $nama_file);
                $data =  t_log::where('id', request()->input('id'))->update([
                    'gambar' => $nama_file ?? null,
                    'tanggal' => date('Y-m-d', strtotime($request->awal)),
                    'bulan' => ltrim($month, '0'),
                    'ket' => $request->keterangan,
                    'kuantitas' => $request->kuantitas,
                    'satuan' => $request->satuan,
                    'updated_at' => date("Y-m-d H:s:i"),
                ]);
                return 'success';
            } else {
                $data =  t_log::where('id', request()->input('id'))->update([
                    'tanggal' => date('Y-m-d', strtotime($request->awal)),
                    'bulan' => ltrim($month, '0'),
                    'ket' => $request->keterangan,
                    'kuantitas' => $request->kuantitas,
                    'satuan' => $request->satuan,
                    'updated_at' => date("Y-m-d H:s:i"),

                ]);
                return 'success';
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\t_log  $t_log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, t_log $t_log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\t_log  $t_log
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = t_log::findOrFail($id);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
    public function destroyAll($a)
    {
        $idp = Session::get('period');
        $period  = t_periode::where('id', $idp)->first();
        $dataa = Manajemen_p::where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();
        $res = t_log::where('bulan', $a)->where('id_mn', $dataa->id)->delete();
        if ($res) {
            return redirect()->back()->with(['msg' => 'Berhasil Menghapus Log Bulan ' . $a]);
        }
        return redirect()->back()->with(['msg' => 'Gagal Menghapus ']);
    }
}
