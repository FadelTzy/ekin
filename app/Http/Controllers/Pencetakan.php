<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\t_periode;
use Illuminate\Support\Facades\Auth;
use App\Models\Peginfo;
use App\Models\Manajemen_p;
use App\Models\t_jabatan;
use App\Models\t_nilaitambahan;
use App\Models\target_semester;
use Illuminate\Support\Carbon;
use App\Models\t_log;

class Pencetakan extends Controller
{
    public function statusb($a)
    {
        switch ($a) {
            case "1":
                $nb = 'januari';
                break;
            case "2":
                $nb = 'februari';
                break;
            case "3":
                $nb = 'maret';
                break;
            case "4":
                $nb = 'april';
                break;
            case "5":
                $nb = 'mei';
                break;
            case "6":
                $nb = 'juni';
                break;
            case "7":
                $nb = 'juli';
                break;
            case "8":
                $nb = 'agustus';
                break;
            case "9":
                $nb = 'september';
                break;
            case "10":
                $nb = 'oktober';
                break;
            case "11":
                $nb = 'november';
                break;
            case "12":
                $nb = 'desember';
                break;
            default:
                return "0";
        }
        return $nb;
    }
    public function logb($a)
    {
        $data['bulan'] = $this->statusb($a);
        if (Auth::check()) {
            if (Session::has('period')) {
                $idp = Session::get('period');
                $period  = t_periode::where('id', $idp)->first();
                $dataa = Manajemen_p::where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();

                $jab = $dataa;
                if ($jab != null) {
                    $data['jabatan']  = t_jabatan::select('jabatan')->where('id', $jab->id_jab)->first() ?? 'null';

                    $data['log'] =     datatables()->of(t_log::where('bulan', $a)->where('id_mn', $dataa->id)->get())->addIndexColumn()->addColumn('inputtgl', function ($data) {
                        return   Carbon::parse(date('Y-m-d ', strtotime($data->tanggal)))->translatedFormat('d F Y ');
                    })->addColumn('tanggal', function ($data) {
                        return   Carbon::parse(date('Y-m-d  H:s', strtotime($data->updated_at)))->translatedFormat('d F Y  H:s');
                    })->addColumn('kegiatan', function ($data) {
                        return $data->target->kegiatan;
                    })->addColumn('output', function ($data) {
                        return $data->kuantitas  . ' ' . $data->satuan;
                    })->rawColumns(['output', 'tanggal', 'kegiatan', 'inputtgl'])->make(true);
                    $data['tanggal'] = Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y');
                } else {
                    $data['jabatan'] = "null";
                }
            } else {
                $jab = "null";
                $jabatan = "null";
            }
        }
        $pdf = \PDF::loadView('pdf.logbulan', $data);
        return $pdf->setPaper('a4', 'landscape')->download('log-harian-' . $data['bulan'] . '.pdf');
    }
    public function log()
    {
        if (Auth::check()) {
            if (Session::has('period')) {
                $idp = Session::get('period');
                $period  = t_periode::where('id', $idp)->first();
                $dataa = Manajemen_p::where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();

                $jab = $dataa;
                if ($jab != null) {
                    $data['jabatan']  = t_jabatan::select('jabatan')->where('id', $jab->id_jab)->first() ?? 'null';

                    $data['log'] =     datatables()->of(t_log::where('id_mn', $dataa->id)->get())->addIndexColumn()->addColumn('inputtgl', function ($data) {
                        return   Carbon::parse(date('Y-m-d ', strtotime($data->tanggal)))->translatedFormat('d F Y ');
                    })->addColumn('tanggal', function ($data) {
                        return   Carbon::parse(date('Y-m-d  H:s', strtotime($data->updated_at)))->translatedFormat('d F Y  H:s');
                    })->addColumn('kegiatan', function ($data) {
                        return $data->target->kegiatan;
                    })->addColumn('output', function ($data) {
                        return $data->kuantitas  . ' ' . $data->satuan;
                    })->rawColumns(['output', 'tanggal', 'kegiatan', 'inputtgl'])->make(true);
                    $data['tanggal'] = Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y');
                } else {
                    $data['jabatan'] = "null";
                }
            } else {
                $jab = "null";
                $jabatan = "null";
            }
        }
        $pdf = \PDF::loadView('pdf.log', $data);
        return $pdf->setPaper('a4', 'landscape')->download('log-harian-lengkap.pdf');
    }
    public function relskp()
    {
        if (Auth::check()) {
            if (Session::has('period')) {
                $idp = Session::get('period');
                $period  = t_periode::where('id', $idp)->first();
                $dataa = Manajemen_p::with('perilaku')->where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();

                $jab = $dataa;
                if ($jab != null) {
                    $data['ap'] = Peginfo::dataPegawai($dataa->pp);
                    $tk = t_nilaitambahan::where('id_mn', $dataa->id)->first();

                    if (!is_null($tk)) {
                        if ($tk->status_t == '1') {
                            $data['tugast'] = $tk->ket_nt ?? '';
                            $data['nilait'] = $tk->nt ?? 0;
                        }
                        if ($tk->status_k == '1') {
                            $data['kreatif'] = $tk->ket_nk ?? '';
                            $data['nilaik'] = $tk->nk ?? 0;
                        }
                    }
                    $data['realisasi'] =  datatables()->of(target_semester::where('id_ped', $dataa->id)->where('status_adendum', '!=', '3')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
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
                    $data['tanggal'] = Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y');
                } else {
                    $data['jabatan'] = "null";
                    $data['ap'] = 'null';
                }
            } else {
                $jab = "null";
                $jabatan = "null";
            }
        }
        $data['periode'] = 'Jangka Waktu Penilaian ' . $period->nama_periode;
        $pdf = \PDF::loadView('pdf.relskp', $data);
        return $pdf->setPaper('a4', 'landscape')->download('realisasi-skp.pdf');
    }
    public function relskpl()
    {
        if (Auth::check()) {
            if (Session::has('period')) {
                $idp = Session::get('period');
                $period  = t_periode::where('id', $idp)->first();
                $dataa = Manajemen_p::with('perilaku')->where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();

                $jab = $dataa;
                if ($jab != null) {
                    $data['ap'] = Peginfo::dataPegawai($dataa->pp);
                    $tk = t_nilaitambahan::where('id_mn', $dataa->id)->first();

                    if (!is_null($tk)) {
                        if ($tk->status_t == '1') {
                            $data['tugast'] = $tk->ket_nt ?? '';
                            $data['nilait'] = $tk->nt ?? 0;
                        }
                        if ($tk->status_k == '1') {
                            $data['kreatif'] = $tk->ket_nk ?? '';
                            $data['nilaik'] = $tk->nk ?? 0;
                        }
                    }
                    $data['realisasi'] =  datatables()->of(target_semester::where('id_ped', $dataa->id)->where('status_adendum', '!=', '3')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
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
                    $data['tanggal'] = Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y');
                } else {
                    $data['jabatan'] = "null";
                    $data['ap'] = 'null';
                }
            } else {
                $jab = "null";
                $jabatan = "null";
            }
        }
        $data['periode'] = 'Jangka Waktu Penilaian ' . $period->nama_periode;
        $pdf = \PDF::loadView('pdf.relskpl', $data);
        return $pdf->setPaper('a4', 'landscape')->download('realisasi-skp-lengkap.pdf');
    }
    public function rskpl()
    {
        if (Auth::check()) {
            if (Session::has('period')) {
                $idp = Session::get('period');
                $period  = t_periode::where('id', $idp)->first();
                $dataa = Manajemen_p::with('perilaku')->where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();

                $jab = $dataa;
                if ($jab != null) {
                    $data['jabatan']  = t_jabatan::select('jabatan')->where('id', $jab->id_jab)->first() ?? 'null';
                    $data['ap'] = Peginfo::dataPegawai($dataa->pp);
                    $data['ppt'] = Peginfo::dataPegawai($dataa->ppt);
                    $data['pa'] = Peginfo::dataPegawai($dataa->appt);
                    $data['target'] =  datatables()->of(target_semester::where('id_ped', $dataa->id)->where('status_adendum', '!=', '3')->orderBy('bulan')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
                        return $data[0]->tupoksi->uraian;
                    })->addColumn('totalkuan', function ($data) {
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $num[] = $value['tkuantitas'];
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
                    })->addColumn('waktu', function ($data) {
                        $no = 0;
                        foreach ($data as $key => $value) {
                            if (is_numeric($key)) {
                                $no++;
                            }
                        }
                        return $no;
                    })
                        ->rawColumns(['tugas', 'indexes2', 'totalkuan',  'waktu'])->make();

                    $data['tanggal'] = Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y');
                    // return ($data['target']->getData()->data[0]->{'0'});
                } else {
                    $data['jabatan'] = "null";
                    $data['ap'] = 'null';
                    $data['pa'] = 'null';
                    $data['ppt'] = 'null';
                }
            } else {
                $jab = "null";
                $jabatan = "null";
            }
        }
        $data['periode'] = 'Jangka Waktu Penilaian ' . $period->nama_periode;
        $pdf = \PDF::loadView('pdf.rskpl', $data);
        return $pdf->setPaper('a4', 'landscape')->download('rencana-skp-lengkap.pdf');
    }
    public function rencanaskp()
    {
        if (Auth::check()) {
            if (Session::has('period')) {
                $idp = Session::get('period');
                $period  = t_periode::where('id', $idp)->first();
                $dataa = Manajemen_p::with('perilaku')->where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();

                $jab = $dataa;
                if ($jab != null) {
                    $data['jabatan']  = t_jabatan::select('jabatan')->where('id', $jab->id_jab)->first() ?? 'null';
                    $data['ap'] = Peginfo::dataPegawai($dataa->pp);
                    $data['ppt'] = Peginfo::dataPegawai($dataa->ppt);
                    $data['pa'] = Peginfo::dataPegawai($dataa->appt);
                    $data['target'] =  datatables()->of(target_semester::where('id_ped', $dataa->id)->where('status_adendum', '!=', '3')->orderBy('bulan')->get()->groupBy('id_tup'))->addIndexColumn()->addColumn('tugas', function ($data) {
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
                        })->rawColumns(['tugas', 'totalcapai', 'statusbulan', 'totalkuan', 'kualitas', 'waktu',  'totalkuanr'])->make();

                    $data['tanggal'] = Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y');
                } else {
                    $data['jabatan'] = "null";
                    $data['ap'] = 'null';
                    $data['pa'] = 'null';
                    $data['ppt'] = 'null';
                }
            } else {
                $jab = "null";
                $jabatan = "null";
            }
        }
        $data['periode'] = 'Jangka Waktu Penilaian ' . $period->nama_periode;
        $pdf = \PDF::loadView('pdf.rskp', $data);
        return $pdf->setPaper('a4', 'landscape')->download('rencana-skp.pdf');
    }
}
