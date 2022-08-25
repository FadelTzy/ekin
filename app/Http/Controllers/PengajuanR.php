<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\t_periode;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Manajemen_p;
use App\Models\t_log;
use App\Models\t_nilaitambahan;
use App\Models\target_semester;
use App\Models\t_tugastambahan;

class PengajuanR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $id_periode;
    private $id_auth;

    public function __construct()
    {
    }

    public function simpannilai()
    {
        $id_mn = request()->input('id');

        $tambahan = request()->input('tambahan');
        $kreativitas = request()->input('kreativitas');

        if ($tambahan != null) {
            $statust = $tambahan;
        } else {
            $statust = '0';
        }
        if ($kreativitas != null) {
            $statusk = $kreativitas;
        } else {
            $statusk = '0';
        }

        try {
            $data = t_nilaitambahan::where('id_mn', $id_mn)->update([
                'id_mn' => $id_mn,
                'status_t' => $statust,
                'status_k' => $statusk,
            ]);
            if ($data) {
                return 'success';
            }
        } catch (\Throwable $th) {
            return $th;
        }
        return request()->all();
    }
    public function lihatdata()
    {
        $id = request()->input('id');
        $data = t_nilaitambahan::where('id_mn', $id)->get();
        return $data;
    }
    public function lihatnilai()
    {
        if (Session::has('period')) {
            $idp = Session::get('period');
            if (request()->ajax()) {
                return datatables()->of(Manajemen_p::with('tugastambahan')->where('pp', Auth::user()->id_peg)->where('id_ped', $idp)->get())->addIndexColumn()->addColumn('nip', function ($data) {
                    return $data->datapegawai->nip;
                })->addColumn('nama', function ($data) {
                    return $data->datapegawai->nama;
                })->addColumn('aksi', function ($data) {
                    if ($data->status_target == 0) {
                        return "<b class='text-danger text-small'>Belum Diset</b>";
                    } else {
                        $btn = '<ul class="list-inline table-action m-0">';
                        $btn .= '<li class="list-inline-item">
                        <a href="javascript:void(0);" onclick="lihat1(' . $data->id . ')" class="action-icon"> <i class="mdi mdi-clipboard-text-multiple-outline"></i></a>
                    </li>';
                        $btn .= '</ul>';
                        return $btn;
                    }
                })->addColumn('jabatan', function ($data) {
                    return $data->datapegawai->jabatan;
                })->addColumn('period', function ($data) {
                    return $data->periode->status_bulan;
                })->addColumn('status1', function ($data) {
                    if ($data->tugastambahan->status_k == '0') {
                        return "<b class='badge badge-warning text-small'>Belum Mengajukan</b>";
                    } elseif ($data->tugastambahan->status_k == '1') {
                        return "<b class='badge badge-success text-small'>Telah Disetujui</b>";
                    } elseif ($data->tugastambahan->status_k == '2') {
                        return "<b class='badge badge-success text-small'>Usulan Ditolak</b>";
                    } elseif ($data->tugastambahan->status_k == '3') {
                        return "<b class='badge badge-success text-small'>Menunggu Persetujuan</b>";
                    } else {
                        return "<b class='text-danger'>Belum Diset</b>";
                    }
                })->addColumn('status', function ($data) {
                    if ($data->tugastambahan->status_t == '0') {
                        return "<b class='badge badge-warning text-small'>Belum Mengajukan</b>";
                    } elseif ($data->tugastambahan->status_t == '1') {
                        return "<b class='badge badge-success text-small'>Telah Disetujui</b>";
                    } elseif ($data->tugastambahan->status_t == '2') {
                        return "<b class='badge badge-success text-small'>Usulan Ditolak</b>";
                    } elseif ($data->tugastambahan->status_t == '3') {
                        return "<b class='badge badge-success text-small'>Menunggu Persetujuan</b>";
                    } else {
                        return "<b class='text-danger'>Belum Diset</b>";
                    }
                })->rawColumns(['aksi', 'status1',  'status', 'nip', 'status', 'jabatan', 'period'])->make(true);
            }
        } else {
        }




        return view('user.persetujuan.tugastambahan');
    }
    public function nilaitambah()
    {
        $id_mn = request()->input('id');
        $ket_1 = request()->input('ket_1');
        $ket_2 = request()->input('ket_2');
        $nkreativitas = request()->input('nkreativitas');
        $ntambahan = request()->input('ntambahan');

        if ($nkreativitas != null) {
            $statusk = '3';
        } else {
            $statusk = '0';
        }
        if ($ntambahan != null) {
            $statust = '3';
        } else {
            $statust = '0';
        }

        try {
            $data = t_nilaitambahan::create([
                'id_mn' => $id_mn,
                'status_t' => $statust,
                'status_k' => $statusk,

                'nt' => $ntambahan,
                'ket_nt' => $ket_1,
                'nk' => $nkreativitas,
                'ket_nk' => $ket_2
            ]);
            if ($data) {
                return 'success';
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function ajuremun()
    {
        if (Session::has('period')) {
            $idp = Session::get('period');
            $ida = Auth::user()->id_peg;
            $id_mn = Manajemen_p::where('id_ped', $idp)->where('id_peg', $ida)->update([
                'nilai_remun' => request()->input('nilai')
            ]);

            if ($id_mn) {
                return 'success';
            }
        }
        return request()->all();
    }
    public function remunindex()
    {
        if (Session::has('period')) {
            $idp = Session::get('period');
            $ida = Auth::user()->id_peg;
            $ids = '';
            $id_sta = '';
            $id_mn = Manajemen_p::where('id_ped', $idp)->where('id_peg', $ida)->first() ?? "null";
            $datap = t_periode::where('id', $idp)->first();

            if ($id_mn != "null") {
                $ids = $id_mn->id;
                $id_sta = $id_mn->status_target;
                if (request()->ajax()) {
                    return datatables()->of(target_semester::where('id_ped', $ids)->where('status_adendum', '!=', '3')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
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
                    })->addColumn('totalkual', function ($data) {
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $num[] = $value['nilai_atasan'] ?? 0;
                            }
                        }
                        return round(array_sum($num) / count($num), PHP_ROUND_HALF_UP);
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
                                    $numtks[] = $value['tkuantitas'] ?? 0;
                                    $numrkl[] = $value['rkuantitas'] ?? 0;
                                    $numnt[] = $value['nilai_atasan'] ?? 0;
                                }
                            }
                            $numtksa = round(array_sum($numtks), PHP_ROUND_HALF_UP);
                            $numrkla =  round(array_sum($numrkl), PHP_ROUND_HALF_UP);
                            $numnta = round(array_sum($numnt) / count($numnt), PHP_ROUND_HALF_UP);

                            return ($numrkla / $numtksa) * $numnta;
                        })->rawColumns(['tugas', 'totalcapai', 'statusbulan', 'totalkuan', 'kualitas', 'waktu', 'totalkual', 'totalkuanr'])->make(true);
                }
            }
        }
        Session::flash('id_periode', $id_mn);
        Session::flash('id_status', $id_sta);
        return view('user.pengajuan.remun', compact('datap'));
    }
    public function storeukuran()
    {
        if (Session::has('period')) {
            $idp = Session::get('period');
            $ida = Auth::user()->id_peg;
            $no = number_format((float)request()->input('id'), 2, '.', '');
            $id_mn = Manajemen_p::where('id_ped', $idp)->where('id_peg', $ida)->update([
                'nilai_skp' => (string)request()->input('id', $no)
            ]);
        }
        return (float)request()->input('id', $no);
    }
    public function pengukuran()
    {
        if (Session::has('period')) {
            $idp = Session::get('period');
            $ida = Auth::user()->id_peg;
            $ids = '';
            $id_sta = '';
            $id_mn = Manajemen_p::where('id_ped', $idp)->where('id_peg', $ida)->first() ?? "null";
            $datap = t_periode::where('id', $idp)->first();

            if ($id_mn != "null") {
                $ids = $id_mn->id;
                $id_sta = $id_mn->status_target;
                if (request()->ajax()) {
                    return datatables()->of(target_semester::where('id_ped', $ids)->where('status_adendum', '!=', '3')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
                        return $data[0]->tupoksi->uraian;
                    })->addColumn('hbk', function ($data) {
                        $bt = 0;
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $bt++;
                                $num[] = $value['tkuantitas'];
                                $num1[] = $value['rkuantitas'];
                                $cikalmutu[] = $value['nilai_atasan'] ?? 0;
                                $cikalrealbulan[] = $value['status'] == 1 || $value['status'] == 2 ? 1 : 0;
                            }
                        }
                        $rk =  round(array_sum($cikalmutu) / count($cikalmutu),);
                        $kuantitas = array_sum($num1) / array_sum($num) * 100;
                        $kualitas = $rk;
                        $waktu = round((((1.76 * $bt) - array_sum($cikalrealbulan)) / $bt) * 100, PHP_ROUND_HALF_UP);

                        if (array_sum($cikalrealbulan) == 0) {
                            $waktu = 0;
                        }
                        return $waktu + $kualitas + $kuantitas;
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
                    })->addColumn('indexes', function ($data) {
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $num[] = $key;
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
                                    $num[] = $value['nilai_atasan'] ?? 0;
                                }
                            }
                            return round(array_sum($num) / count($num), PHP_ROUND_HALF_UP);
                        })->rawColumns(['tugas', 'hbk', 'totalcapai', 'statusbulan', 'totalkuan', 'kualitas', 'waktu', 'indexes', 'totalkuanr'])->make(true);
                }
            }
        }
        Session::flash('id_periode', $id_mn);
        Session::flash('id_status', $id_sta);
        return view('user.pengajuan.ukur', compact('datap'));
    }
    public function index()
    {
        if (Session::has('period')) {
            $idp = Session::get('period');
            $ida = Auth::user()->id_peg;
            $ids = '';
            $id_sta = '';
            $id_mn = Manajemen_p::where('id_ped', $idp)->where('id_peg', $ida)->first() ?? "null";
            $datap = t_periode::where('id', $idp)->first();

            if ($id_mn != "null") {
                $ids = $id_mn->id;
                $id_sta = $id_mn->status_target;
                if (request()->ajax()) {
                    return datatables()->of(target_semester::where('id_ped', $ids)->where('status_adendum', '!=', '3')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
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
                    })->addColumn('indexes', function ($data) {
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $num[] = $key;
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
                                    $num[] = $value['nilai_atasan'] ?? 0;
                                }
                            }
                            return round(array_sum($num) / count($num), PHP_ROUND_HALF_UP);
                        })->rawColumns(['tugas', 'totalcapai', 'statusbulan', 'totalkuan', 'kualitas', 'waktu', 'indexes', 'totalkuanr'])->make(true);
                }
            }
        }
        Session::flash('id_periode', $id_mn);
        Session::flash('id_status', $id_sta);
        $tambah = t_tugastambahan::where('jenis', 'Tugas Tambahan')->get();
        $kreatif = t_tugastambahan::where('jenis', 'Kreativitas')->get();
        return view('user.pengajuan.index', compact('datap', 'id_mn', 'tambah', 'kreatif'));
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
            $check = target_semester::find($request->idtugas);
            if ($check->status == 2) {
                return '';
            }
            $check = t_log::where('id_target', $request->idtugas)->count();
            if ($check == 0) {
                return 'gagal';
            }

            $data = target_semester::where('id', $request->idtugas)->update([
                'rkuantitas' => $request->realisasikualitas,
                'nilai_mutu' => $request->rkualitas,
                'status' => '1'
            ]);
            if ($data) {
                return $data;
            }
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
        $data = target_semester::where('id', $id)->first();
        $data['tugasjabatan'] = $data->tupoksi->uraian;
        return $data;
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
