<?php

namespace App\Http\Controllers;

use App\Models\Manajemen_p;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perdtahun;
use App\Models\Pegawai;
use App\Models\target_semester;
use Illuminate\Support\Facades\Session;

class Penilaianstaf extends Controller
{
    public function setuju()
    {
        $id = request()->input('id');
        $data =  Manajemen_p::where('id', $id)->update(['status_target' => 1]);

        if ($data) {
            return 'success';
        }
    }

    public function tolak()
    {
        $id = request()->input('id');
        $ket = request()->input('ket');
        $data =  Manajemen_p::where('id', $id)->update(['status_target' => 2, 'ket' => $ket]);

        if ($data) {
            return 'success';
        }
    }
    public function lihat1()
    {
        $tupoksi = '';
        $id = request()->input('id');

        $datas = target_semester::where('id_ped', $id)->get();
        $no = 1;
        $datat = Manajemen_p::where('id', $id)->first();
        if (Auth::check()) {
            $datap = Pegawai::where('id_peg', $datat->id_peg)->first();

            if (request()->ajax()) {
                return datatables()->of(target_semester::where('id_ped', $id)->where('status_adendum', '!=', '3')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
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
                                $num[] = $value['nilai_capaian'] ?? 0;
                            }
                        }
                        return round(array_sum($num) / count($num), PHP_ROUND_HALF_UP);
                    })->rawColumns(['tugas', 'totalcapai', 'statusbulan', 'totalkuan', 'kualitas', 'waktu', 'indexes', 'totalkuanr'])->make(true);
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
    public function datapegawai()
    {
        $id = request()->input('id');
        $datat = Manajemen_p::where('id', $id)->first();
        $datap = Pegawai::where('id_peg', $datat->id_peg)->first();
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
        return $arr;
    }
    public function data()
    {
        $id = request()->input('id');
        $arr['info'] = '<a href="javascript:void(0);" onclick="pegawai(' . $id . ')" class="btn btn-sm btn-info"> Data Pegawai</a>';
        $arr['btn'] = '<a href="javascript:void(0);" onclick="setuju(' . $id . ',' . "1" . ')" class="btn btn-sm btn-success"> Setuju</a>';
        $arr['btnt'] = '<a href="javascript:void(0);" onclick="tolak(' . $id . ',' . "1" . ')" class="btn btn-sm btn-danger"> Tolak</a>';
        return $arr;
    }

    public function lihat2()
    {
        $tupoksi = '';
        $id = request()->input('id');

        $datas = target_semester::where('id_ped', $id)->where('id_sem', 2)->get();
        $no = 1;
        $datat = Perdtahun::where('id', $id)->first();
        if (Auth::check()) {
            $datap = Pegawai::where('id_peg', $datat->id_peg)->first();
            foreach ($datas as $value) {
                $tupoksi .= '<tr>
                <th scope="row">' . $no++ . '</th>
                <td>' . $value->item . '</td>
                <td>' . $value->tkuantitas . '</td>
                <td>' . $value->tkualitas . '</td>
                <td>' . $value->twaktu . '</td>

                <td>' . $value->tbiaya . '</td>

              </tr>';
            }
            $arr['btn'] = '<a href="javascript:void(0);" onclick="setuju(' . $datat->id_mp . ',' . "2" . ')" class="btn btn-sm btn-success"> Setuju</a>';
            $arr['btnt'] = '<a href="javascript:void(0);" onclick="tolak(' . $datat->id_mp . ',' . "2" . ')" class="btn btn-sm btn-danger"> Tolak</a>';

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
    public function p_tupoksi($id)
    {

        if (Auth::check()) {
            if (request()->ajax()) {
                return datatables()->of(target_semester::where('id_ped', $id)->get())->addIndexColumn()->make(true);
            }
        }
    }
    public function persetujuan()
    {
        if (Session::has('period')) {
            $idp = Session::get('period');

            if (request()->ajax()) {
                return datatables()->of(Manajemen_p::where('pp', Auth::user()->id_peg)->where('id_ped', $idp)->get())->addIndexColumn()->addColumn('nip', function ($data) {
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
                    } elseif ($data->status_target == 1) {
                        return "<b class='badge badge-success text-small'>SKP Disetujui</b>";
                    } elseif ($data->status_target == 2) {
                        return "<b class='badge badge-warning text-small'>SKP Ditolak</b>";
                    } elseif ($data->status_target == 3) {
                        return "<b class='badge badge-danger text-small'>Belum Disetujui</b>";
                    }
                })->rawColumns(['aksi', 'status', 'nip', 'status', 'jabatan', 'period'])->make(true);
            }
        } else {
        }




        return view('user.persetujuan.staf');
    }
}
