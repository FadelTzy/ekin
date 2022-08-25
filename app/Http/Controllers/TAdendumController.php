<?php

namespace App\Http\Controllers;

use App\Models\t_adendum;
use Illuminate\Http\Request;
use App\Models\Manajemen_p;
use Illuminate\Support\Facades\Session;
use App\Models\t_tupoksi;
use Illuminate\Support\Facades\Auth;
use App\Models\t_periode;
use App\Models\target_semester;
use App\Models\Pegawai;

class TAdendumController extends Controller
{
    // 0 tidak apa
    // 1 pengajuan
    // 2 Ditolak
    // 3 diterima
    public function setuju()
    {
        $id = request()->input('id');
        $data =  Manajemen_p::where('id', $id)->update(['adendum' => 3]);

        if ($data) {
            $tg = target_semester::with('adendum')->where('id_ped', $id)->where('status_adendum', '!=', '0')->get();
            foreach ($tg as $key => $value) {
                if ($value['status_adendum'] == '1') {
                    target_semester::findOrFail($value['id'])->delete();
                } else if ($value['status_adendum'] == '3') {
                    target_semester::where('id', $value['id'])->update(['status_adendum' => '0']);
                } else if ($value['status_adendum'] == '2') {
                    $sip =  target_semester::where('id', $value['id'])->update(
                        [
                            'status_adendum' => '0',
                            'bulan' => $value['adendum']['bulan'],
                            'satuan' => $value['adendum']['satuan'],
                            'kegiatan' => $value['adendum']['kegiatan'],
                            'tkuantitas' => $value['adendum']['kuantitas'],
                            'ket' => $value['adendum']['keterangan'],
                        ]
                    );
                    if ($sip) {
                        t_adendum::findOrFail($value['adendum']['id'])->delete();
                    }
                }
            }
            return 'success';
        }
    }


    public function tolak()
    {
        $id = request()->input('id');
        $ket = request()->input('ket');
        $data =  Manajemen_p::where('id', $id)->update(['adendum' => 2, 'ket_adendum' => $ket]);

        if ($data) {
            return 'success';
        }
    }
    /**
     * Display a listing of the resource.
     *adendum
     *0 tidak aden
     *1 hapus
     *2 ubah
     *3 tambah
     * @return \Illuminate\Http\Response
     */
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

            $idp = Session::get('period');
            $data = Manajemen_p::select(['id_jab', 'status_target', 'id', 'adendum', 'ket_adendum'])->where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();
            $ids = '';
            $id_sta = 'd';
            $datap = t_periode::where('id', $idp)->first();
            if ($datap->semester == 1) {
                $smst = json_decode(json_encode($smstr1));
            } else {
                $smst = json_decode(json_encode($smstr2));
            }
            $jab = $data;
            if ($jab != "kosong") {
                $id_sta = $jab->status_target;
                $id_tup =  $jab->id;
                if (request()->ajax()) {
                    return datatables()->of(t_tupoksi::with(['targets' => function ($q) use ($id_tup) {
                        $q->with('adendum')->select('*')->where('id_ped', $id_tup)->get()->groupBy('bulan');
                    }])->where('id_jab', $jab->id_jab)->get())->addIndexColumn()->addColumn('kuantitas', function ($data) {
                        if (empty($data->targets[0])) {
                            return '-';
                        }
                        $d = 0;
                        foreach ($data->targets as $key) {
                            if ($key->status_adendum == '2') {
                                $d += $key->adendum->kuantitas;
                            } else if ($key->status_adendum == '1') {
                                $d += 0;
                            } else {
                                $d += $key->tkuantitas;
                            }
                        }
                        return $d . ' ' . $data->targets[0]->satuan;
                    })->addColumn('bulan', function ($data) {
                        if (empty($data->targets[0])) {
                            return '-';
                        }
                        $d = 0;
                        foreach ($data->targets as $key) {
                            if ($key->status_adendum == '1') {
                                $d += 0;
                            } else {
                                $d += 1;
                            }
                        }
                        return $d;
                    })->addColumn('aksi', function ($data) {
                        $btn = "<button data-toggle='modal' data-target='#modal-pr' onclick='tambah(" . json_encode($data) . ")' href='javascript:void(0);' class='btn btn-sm btn-primary mb-2'><i class='fa fa-plus'></i></button>";
                        return $btn;
                    })->rawColumns(['kuantitas', 'bulan', 'aksi'])->make(true);
                }
            }
            $alert = '';

            if ($data->adendum == '1') {
                $alert = '<div class="row">
                <div class="col-12">
                    <div class="alert alert-warning d-flex justify-content-between" role="alert">
                        <div>
                            <h4 class="page-title">Adendum Telah Diajukan</h4>
                            <h6 class="page-body">Silahkan Menghubungi Atasan Untuk Melakukan Persetujuan Rancangan Target Baru</h6>
                        </div>
                        <div>
                            <i class="fa fa-4x fa-exclamation-triangle  mr-2"></i>
                        </div>
                    </div>
                </div>
            </div>';
            } elseif ($data->adendum == '3') {
                $alert = '<div class="row">
                <div class="col-12">
                    <div class="alert alert-info d-flex justify-content-between" role="alert">
                        <div>
                            <h4 class="page-title">Adendum Telah Disetujui</h4>
                           
                        </div>
                 
                    </div>
                </div>
            </div>';
            } elseif ($data->adendum == '2') {
                $alert = '<div class="alert alert-warning d-flex justify-content-between">
                <h4 class="page-title">Adendum Di Tolak, Silahkan Menyusun Ulang </h4>
                <div>

                    <button class="btn btn-soft-warning" type="button" data-toggle="modal" data-target="#pa"><i class="mdi mdi-alert"></i></button>
                </div>
            </div>';
            }
            Session::flash('id_periode', $data);
            Session::flash('id_status', $id_sta);
            return view('user.adendum.pengajuan', compact('datap', 'smst', 'data', 'alert'));
        }
    }
    public function data()
    {
        $id = request()->input('id');
        $arr['info'] = '<a href="javascript:void(0);" onclick="pegawai(' . $id . ')" class="btn btn-sm btn-info"> Data Pegawai</a>';
        $arr['btn'] = '<a href="javascript:void(0);" onclick="setuju(' . $id . ',' . "1" . ')" class="btn btn-sm btn-success"> Setuju</a>';
        $arr['btnt'] = '<a href="javascript:void(0);" onclick="tolak(' . $id . ',' . "1" . ')" class="btn btn-sm btn-danger"> Tolak</a>';
        return $arr;
    }
    public function lihat()
    {
        $tupoksi = '';
        $id = request()->input('id');

        $datas = target_semester::where('id_ped', $id)->get();
        $no = 1;
        $datat = Manajemen_p::where('id', $id)->first();
        if (Auth::check()) {
            $datap = Pegawai::where('id_peg', $datat->id_peg)->first();

            if (request()->ajax()) {
                return datatables()->of(target_semester::with('adendum')->where('id_ped', $id)->where('status_adendum', '!=', '0')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
                    return $data[0]->tupoksi->uraian;
                })->addColumn('totalkuan', function ($data) {
                    foreach ($data as $key => $value) {
                        if ($value['status_adendum'] == 3) {
                            $num[] = 0;
                        } else {
                            $num[] = $value['tkuantitas'];
                        }
                    }
                    return array_sum($num) . ' ' . $data[0]->satuan;
                })->addColumn('totalkuana', function ($data) {
                    foreach ($data as $key => $value) {
                        if ($value['status_adendum'] == 1) {
                            $num[] = 0;
                        } else {
                            if ($value['status_adendum'] == 2) {
                                $num[] = $value['adendum']['kuantitas'];
                            } else {
                                $num[] = $value['tkuantitas'];
                            }
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
                        if ($value['status_adendum'] == 3) {
                            $no += 0;
                        } else {
                            $no += 1;
                        }
                    }
                    return $no;
                })->addColumn('waktua', function ($data) {
                    $no = 0;
                    foreach ($data as $key => $value) {
                        if ($value['status_adendum'] == 1) {
                            $no += 0;
                        } else {
                            $no += 1;
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
                    })->rawColumns(['tugas', 'totalcapai', 'statusbulan', 'totalkuan', 'totalkuana', 'waktua', 'waktu', 'indexes', 'totalkuanr'])->make(true);
            }


            $arr['btn'] = '<a href="javascript:void(0);" onclick="setuju(' . $id . ',' . "1" . ')" class="btn btn-sm btn-success"> Setuju</a>';
            $arr['btnt'] = '<a href="javascript:void(0);" onclick="tolak(' . $id . ',' . "1" . ')" class="btn btn-sm btn-danger"> Tolak</a>';

            $arr['skp'] = $tupoksi;
            $arr['pp'] =  '
            <div class="col-lg-3 ">
                <img src="' . $datap->foto . '" alt="image" class="mx-auto img-fluid rounded" width="180" />
                <p class="mb-0">
            </div>
            <div class="col-lg-9">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td style="width: 25%;"><b>Nama</b></td>
                            <td>' . $datap->nama . '</td>
                        </tr>
                        <tr>
                            <td><b>NIP</b></td>
                            <td>' . $datap->nip . '</td>
                        </tr>
                        <tr>
                            <td><b>Pangkat, Gol</b></td>
                            <td>' . $datap->pangkat . ', ' . $datap->golongan . '</td>
                        </tr>
                        <tr>
                            <td><b>Jabatan</b></td>
                            <td>' . $datap->jabatan . '</td>
                        </tr>
                        <tr>
                            <td><b>Unit Kerja</b></td>
                            <td> ' . $datap->unit . ' / Universitas Negeri Makassar</td>
                        </tr>
                    </tbody>
                </table>
            </div>';
        }
        return $arr;
    }
    public function persetujuan()
    {
        if (Session::has('period')) {
            $idp = Session::get('period');

            if (request()->ajax()) {
                return datatables()->of(Manajemen_p::where('pp', Auth::user()->id_peg)->where('id_ped', $idp)->where('adendum', '!=', '0')->get())->addIndexColumn()->addColumn('nip', function ($data) {
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

                        $btn .= '<li class="list-inline-item">
                            <a href="javascript:void(0);" onclick="tolak(' . $data->id . ')" class="action-icon"> <i class="mdi mdi-close-box-outline"></i></a>
                        </li>';
                        $btn .= '<li class="list-inline-item">
                            <a href="javascript:void(0);" onclick="setuju(' . $data->id . ')" class="action-icon"> <i class="mdi mdi-checkbox-multiple-marked-outline"></i></a>
                        </li>
                    </ul>';
                        return $btn;
                    }
                })->addColumn('jabatan', function ($data) {
                    return $data->datapegawai->jabatan;
                })->addColumn('period', function ($data) {
                    return $data->periode->status_bulan;
                })->addColumn('status', function ($data) {
                    if ($data->status_target == 0) {
                        # code...
                        return "-";
                    } elseif ($data->adendum == 3) {
                        return "<b class='badge badge-success text-small'>Adendum Disetujui</b>";
                    } elseif ($data->adendum == 2) {
                        return "<b class='badge badge-warning text-small'>Adendum Ditolak</b>";
                    } elseif ($data->adendum == 1) {
                        return "<b class='badge badge-danger text-small'>Adendum Belum Disetujui</b>";
                    }
                })->rawColumns(['aksi', 'status', 'nip', 'status', 'jabatan', 'period'])->make(true);
            }
        } else {
        }




        return view('user.adendum.persetujuan');
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
                    'status_adendum' => '3'

                ]);
                if ($saved) {
                    $data = Manajemen_p::where('id_peg', Auth::user()->id_peg)->where('id_ped', $id)->update(['adendum' => 1]);
                }
            }
            return $saved;
        } catch (\Throwable $th) {
            return $th;
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\t_adendum  $t_adendum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, t_adendum $t_adendum)
    {
        if (Session::has('period')) {

            $idp = Session::get('period');
            $datam = Manajemen_p::where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();
        }
        $upd = target_semester::where('id', request()->input('idtugas'))->update(['status_adendum' => '2']);
        $getid = target_semester::where('id', request()->input('idtugas'))->first();
        if ($upd) {
            $data = t_adendum::updateOrCreate(
                ['id_m' => $datam->id, 'id_t' => $getid->id],
                [
                    'keterangan' => request()->input('keterangan'),
                    'kegiatan' => request()->input('aktivitas'),
                    'bulan' => request()->input('bulan'),
                    'satuan' => request()->input('satuan'),
                    'kuantitas' => request()->input('kuantitas')
                ]
            );

            if ($data) {
                Manajemen_p::where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->update(['adendum' => 1]);
                return $data;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\t_adendum  $t_adendum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = target_semester::where('id', $id)->update([
            'status_adendum' => '1'
        ]);
        if ($res) {
            if (Session::has('period')) {

                $idp = Session::get('period');
                $data = Manajemen_p::where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->update(['adendum' => 1]);
                return "success";
            }
        }
        return "fail";
    }
}
