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
use App\Models\KinerjaUtama;

class KinerjaUtamaController extends Controller
{
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
                    return datatables()->of(KinerjaUtama::with('target')->where('manajemen_ps', $jab->id)->get())->addIndexColumn()->addColumn('aksi', function ($data) {
                        $b = "<button class='btn btn-sm btn-bordered-warning waves-effect waves-light mr-2' onclick='editj(" . json_encode($data)  . ");'> Edit </button>";
                        $b .= "<button type='button' class='btn btn-sm btn-bordered-danger waves-effect waves-light' onclick=delj('" . $data->id . "')> Hapus </button>";
                        return $b;
                    })->addColumn('total', function ($data) {
                        return $data->target->count();
                    })->addColumn('bulan', function ($data) {
                        $monthNum  = $data->bulan;
                        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March

                        return $monthName;
                    })->addColumn('ket', function ($data) {
                        return $data->ket;
                    })->rawColumns(['aksi', 'bulam', 'total', 'ket'])->make(true);
                }
            } else {
                $period = "null";
                $jab = "null";
            }

            return view('user.rancangan.kinerja', compact('period', 'jab', 'jabatan', 'smst'));
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function store(Request $request)
    {
        try {
            if (Session::has('period')) {
                $id = Session::get('period');
                $id_peg = Auth::user()->id_peg;
                $jab = Manajemen_p::select('id_jab', 'id')->where('id_peg', $id_peg)->where('id_ped', $id)->first();
                $saved = KinerjaUtama::create([
                    'rencana' => $request->kinerja,
                    'id_pegawai' => $id_peg,
                    'id_periode' => $id,
                    'manajemen_ps' => $jab->id,
                    'status' =>  '0',
                    'ket' => '0'
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
}
