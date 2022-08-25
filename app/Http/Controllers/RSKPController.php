<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\t_periode;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Manajemen_p;
use App\Models\t_tupoksi;
use App\Models\t_jabatan;
use App\Models\target_semester;

class RSKPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    }
    public function item()
    {
        try {
            if (Session::has('period')) {
                $id = Session::get('period');
                $id_peg = Auth::user()->id_peg;
                $jab = Manajemen_p::select('id_jab', 'id')->where('id_peg', $id_peg)->where('id_ped', $id)->first();

                if (request()->ajax()) {

                    return datatables()->of(t_tupoksi::where('id_jab', $jab->id_jab)->get())->addColumn('aksii', function ($dataa) {
                        return '<button  onclick="copy(\'' . $dataa->uraian . '\',\'' . $dataa->id . '\')" data-tes="' . $dataa->uraian . '" class="btn why btn-sm btn-bordered-warning waves-effect waves-light">C</button>';
                    })->rawColumns(['aksii'])->make(true);
                }
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function itemu()
    {
        try {
            if (Session::has('period')) {
                $id = Session::get('period');
                $id_peg = Auth::user()->id_peg;
                $jab = Manajemen_p::select('id_jab', 'id')->where('id_peg', $id_peg)->where('id_ped', $id)->first();

                if (request()->ajax()) {

                    return datatables()->of(t_tupoksi::where('id_jab', $jab->id_jab)->get())->addColumn('aksii', function ($dataa) {
                        return '<button  onclick="copyu(\'' . $dataa->uraian . '\',\'' . $dataa->id . '\')" data-tes="' . $dataa->uraian . '" class="btn why btn-sm btn-bordered-warning waves-effect waves-light">C</button>';
                    })->rawColumns(['aksii'])->make(true);
                }
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function index()
    {
        if (Session::has('period')) {
            $id = Session::get('period');
            $id_peg = Auth::user()->id_peg;
            $period  = t_periode::where('id', $id)->first();
            $tes = $period;
            $jab = Manajemen_p::select('id_jab', 'status_target', 'ket', 'id')->where('id_peg', $id_peg)->where('id_ped', $id)->first() ?? "kosong";
            $id_mn = $jab;
            if ($id_mn != "kosong") {
                $ids = $id_mn->id;
                $id_sta = $id_mn->status_target;
                if (request()->ajax()) {
                    return datatables()->of(target_semester::where('id_ped', $ids)->where('status_adendum', '!=', '3')->orderBy('bulan')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
                        return $data[0]->tupoksi->uraian;
                    })->addColumn('totalkuan', function ($data) {
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $num[] = $value['tkuantitas'];
                            }
                        }
                        return array_sum($num) . ' ' . $data[0]->satuan;
                    })->addColumn('totalkuanr', function ($data) {
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $num[] = $value['rkuantitas'];
                            }
                        }
                        return array_sum($num) . ' ' . $data[0]->satuan;
                    })->addColumn('indexes2', function ($data) use ($period) {
                        if ($period->semester == '1') {
                            foreach ($data as $key => $value) {
                                if (is_numeric($key)) {
                                    if ($value->bulan == '1') {
                                        $num[1][] = $key;
                                    } elseif ($value->bulan == '2') {
                                        $num[2][] = $key;
                                    } elseif ($value->bulan == '3') {
                                        $num[3][] = $key;
                                    } elseif ($value->bulan == '4') {
                                        $num[4][] = $key;
                                    } elseif ($value->bulan == '5') {
                                        $num[5][] = $key;
                                    } elseif ($value->bulan == '6') {
                                        $num[6][] = $key;
                                    }
                                }
                            }
                        } else {
                            foreach ($data as $key => $value) {
                                if (is_numeric($key)) {
                                    if ($value->bulan == '7') {
                                        $num[7][] = $key;
                                    } elseif ($value->bulan == '8') {
                                        $num[8][] = $key;
                                    } elseif ($value->bulan == '9') {
                                        $num[9][] = $key;
                                    } elseif ($value->bulan == '10') {
                                        $num[10][] = $key;
                                    } elseif ($value->bulan == '11') {
                                        $num[11][] = $key;
                                    } elseif ($value->bulan == '12') {
                                        $num[12][] = $key;
                                    }
                                }
                            }
                        }

                        return $num;
                    })->addColumn('indexes', function ($data) {
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $num[] = $value->bulan;
                            }
                        }
                        return ($num);
                    })->addColumn('kualitas', function ($data) {
                        return $data[0]->tkualitas;
                    })->addColumn('waktu', function ($data) {
                        $no = 0;
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $no++;
                            }
                        }
                        return $no;
                    })
                        ->addColumn('statusbulan', function ($data) {
                            foreach ($data as $key => $value) {
                                if (is_numeric($key)) {
                                    $num[] = $value['status'] == 1 || $value['status'] == 2 ? 1 : 0;
                                }
                            }
                            return array_sum($num);
                        })->addColumn('totalcapai', function ($data) {
                            foreach ($data as $key => $value) {
                                if (is_numeric($key)) {
                                    $num[] = $value['nilai_capaian'] ?? 0;
                                }
                            }
                            return round(array_sum($num) / count($num), PHP_ROUND_HALF_UP);
                        })->rawColumns(['tugas', 'totalcapai', 'statusbulan', 'totalkuan', 'kualitas', 'waktu', 'indexes', 'totalkuanr', 'indexes2'])->make(true);
                }
            }
        } else {
            $period = "null";
        }


        return view('user.rancangan.skp', compact('period', 'tes', 'jab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        try {
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
                $period  = t_periode::where('id', $id)->first();
                $jab = Manajemen_p::select('id_jab', 'id')->where('id_peg', $id_peg)->where('id_ped', $id)->first();
                $jabatan  = t_jabatan::where('id', $jab->id_jab)->first();
                $smst = '';
                if ($period->semester == 1) {
                    $smst = json_decode(json_encode($smstr1));
                } else {
                    $smst = json_decode(json_encode($smstr2));
                }

                if (request()->ajax()) {
                    return datatables()->of(target_semester::where('id_ped', $jab->id)->where('status_adendum', '!=', '3')->get())->addIndexColumn()->addColumn('aksi', function ($data) {
                        $data['tt'] = $data->tupoksi->uraian;
                        $b = "<button class='btn btn-sm btn-bordered-warning waves-effect waves-light mr-2' onclick='editj(" . json_encode($data)  . ");'> Edit </button>";
                        $b .= "<button type='button' class='btn btn-sm btn-bordered-danger waves-effect waves-light' onclick=delj('" . $data->id . "')> Hapus </button>";
                        return $b;
                    })->addColumn('tkuan', function ($data) {
                        return $data->tkuantitas . ' ' . $data->satuan;
                    })->addColumn('bulan', function ($data) {
                        $monthNum  = $data->bulan;
                        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March

                        return $monthName;
                    })->addColumn('ket', function ($data) {
                        return $data->ket;
                    })->addColumn('tugas', function ($data) {
                        return $data->tupoksi->uraian;
                    })->rawColumns(['aksi', 'tugas', 'bulam', 'tkuan', 'ket'])->make(true);
                }
            } else {
                $period = "null";
                $jab = "null";
            }

            return view('user.rancangan.target', compact('period', 'jab', 'jabatan', 'smst'));
        } catch (\Throwable $th) {
            return $th;
        }
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
            if (Session::has('period')) {
                $id = Session::get('period');
                $id_peg = Auth::user()->id_peg;
                $jab = Manajemen_p::select('id_jab', 'id')->where('id_peg', $id_peg)->where('id_ped', $id)->first();
                $saved = target_semester::create([
                    'kegiatan' => $request->aktivitas,
                    'tkuantitas' => $request->kuantitas,
                    'tkualitas' => '100',
                    'id_ped' => $jab->id,
                    'id_tup' => $request->idtugas,
                    'satuan' => $request->satuan,
                    'bulan' => $request->bulan,
                    'ket' => $request->keterangan,
                    'rkuantitas' => 0,
                    'rkualitas' => 0,
                    'nilai_mutu' => 0,
                    'status' =>  '0',
                    'status_adendum' => '0'

                ]);
                if ($saved) {
                    Manajemen_p::where('id_peg', $id_peg)->where('id_ped', $id)->update(['status_target' => 3]);
                }
            }
            return 'success';
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            if (Session::has('period')) {
                $id = Session::get('period');
                $id_peg = Auth::user()->id_peg;
                $saved = target_semester::where('id', $request->idu)->update([
                    'kegiatan' => $request->aktivitasu,
                    'tkuantitas' => $request->kuantitasu,
                    'id_tup' => $request->idtugasu,
                    'satuan' => $request->satuanu,
                    'bulan' => $request->bulanu,
                    'ket' => $request->keteranganu,
                ]);
                if ($saved) {
                    Manajemen_p::where('id_peg', $id_peg)->where('id_ped', $id)->update(['status_target' => 3]);
                }
            }
            return 'success';
        } catch (\Throwable $th) {
            return $th;
        }


        if ($saved) {

            return response()->json(['success' => 'Data Berhasil Terupload']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = target_semester::findOrFail($id);
        if ($res) {
            if (Session::has('period')) {
                $id = Session::get('period');
                $id_peg = Auth::user()->id_peg;
                Manajemen_p::where('id_peg', $id_peg)->where('id_ped', $id)->update(['status_target' => 3]);
            }
            $res->delete();
            return "success";
        }
        return "fail";
    }
}
