<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\target_semester;
use Illuminate\Support\Facades\Auth;
use App\Models\Tupoksi;
use App\Models\Jabatan;
use App\Models\Unit;
use App\Models\Itemtupok;
use Illuminate\Support\Facades\Validator;
use App\Models\Peginfo;
use App\Models\Perdtahun;
use App\Models\Manajemen_p;
use App\Models\t_periode;
use Illuminate\Support\Facades\Session;
use App\Models\t_jabatan;
use App\Models\t_tahunpegawai;
use App\Models\t_tupoksi;

class Skp extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function integrasi()
    {
        return 'mantap';
    }
    public function status_target($no)
    {
        if ($no == '1') {
            return 'Rencana Disetujui';
        } else if ($no == '2') {
            return 'Rencana Ditolak';
        } else if ($no == '3') {
            return 'Menunggu Persetujuan Rencana';
        } else if ($no == '0') {
            return 'Belum Menyusun Rencana';
        }
    }
    public function index()
    {
        $tahun = session::get('tahon');
        $periode = t_periode::where('tahun', $tahun)->get();
        $id_peg = Auth::user()->id_peg;
        $data = t_tahunpegawai::with('bulan')->where('id_peg', $id_peg)->where('tahun', $tahun)->first();
        $bulan = [];
        if ($data == true) {
            $b = $data->bulan;
            //s1
            $s1 = Manajemen_p::where('id', $data->id_semester_1)->first();
            $ts1 = target_semester::where('id_ped', $data->id_semester_1)->count();
            $tss1 = target_semester::where('id_ped', $data->id_semester_1)->where('status', '2')->count();

            $periode['statusps1'] = $this->status_target($s1->status_target);
            $periode['totals1'] = $ts1;
            $periode['totalss1'] = $tss1;



            //s2
            $s2 = Manajemen_p::where('id', $data->id_semester_2)->first();
            $ts2 = target_semester::where('id_ped', $data->id_semester_2)->count();
            $tss2 = target_semester::where('id_ped', $data->id_semester_2)->where('status', '2')->count();

            $periode['statusps2'] = $this->status_target($s2->status_target);
            $periode['totals2'] = $ts2;
            $periode['totalss2'] = $tss2;



            $bulan = [$b->jan ?? 0, $b->feb ?? 0, $b->mar ?? 0, $b->apr ?? 0, $b->mei ?? 0, $b->jun ?? 0, $b->jul ?? 0, $b->agus ?? 0, $b->sep ?? 0, $b->okt ?? 0, $b->nov ?? 0, $b->des ?? 0];
            $bulan = $bulan ?? [0];
        }

        return view('user.ds', compact('bulan', 'periode'));
    }
    public function konversi($nil)
    {
        if ($nil >= 91 && $nil <= 99) {
            $nilai = 110 + (((120 - 110) / (99 - 91)) * ($nil - 91));
            return $nilai;
        } elseif ($nil >= 76 && $nil <= 90) {
            $nilai = 90 + (((109 - 90) / (90 - 76)) * ($nil - 76));
            return $nilai;
        } elseif ($nil >= 61 && $nil <= 75) {
            $nilai = 70 + (((89 - 70) / (75 - 61)) * ($nil - 61));
            return $nilai;
        } elseif ($nil >= 51 && $nil <= 60) {
            $nilai = 50 + (((69 - 50) / (60 - 51)) * ($nil - 51));
            return $nilai;
        } elseif ($nil <= 50) {
            $nilai = ($nil / 50) * 49;
            return $nilai;
        } else {
            return '120';
        }
    }
    public function informasi()
    {
        if (Auth::check()) {
            if (Session::has('period')) {
                $idp = Session::get('period');
                $data = Manajemen_p::with('perilaku')->where('id_peg', Auth::user()->id_peg)->where('id_ped', $idp)->first();
                $integrasi = t_tahunpegawai::where('id_peg', Auth::user()->id_peg)->where('tahun', Session::get('tahon'))->first();
                $jab = $data;
                if ($jab != null) {
                    $jabatan  = t_jabatan::where('id', $jab->id_jab)->first() ?? 'null';

                    if (request()->ajax()) {
                        return datatables()->of(t_tupoksi::where('id_jab', $jab->id_jab)->get())->addIndexColumn()->make(true);
                    }
                    $nk = number_format((float)$this->konversi(($jab->nilai_kerja * 0.4) + ($jab->nilai_skp * 0.6)), 2, '.');
                    $ap = Peginfo::dataPegawai($data->pp);
                    $ppt = Peginfo::dataPegawai($data->ppt);
                    $pa = Peginfo::dataPegawai($data->appt);
                } else {
                    $jab = "null";
                    $jabatan = "null";
                    $ap = 'null';
                    $pa = 'null';
                    $ppt = 'null';
                    $nk = 'null';
                }
            } else {
                $jab = "null";
                $jabatan = "null";
            }
        }
        return view('user.informasi', compact('ap', 'pa', 'ppt',  'jab', 'jabatan', 'nk', 'integrasi'));
    }
    public function r_tahun()
    {
        if (request()->ajax()) {
            return datatables()->of(Perdtahun::where('id_peg', Auth::user()->id_peg)->get())->addIndexColumn()->addColumn('aksi', function ($data) {
                return "<b class=' text-success'>Periode Aktif</b>";
            })->addColumn('period', function ($e) {
                return $e->awal . ' - ' . $e->akhir;
            })->addColumn('skp1', function ($data) {
                $b = "<a type='button' href='" . route("user.r_semester", [$data->id, $data->s_1]) . "' class='btn btn-sm btn-bordered-danger waves-effect waves-light'> Target </a>";
                return $b;
            })->addColumn('skp2', function ($data) {
                $b = "<a type='button' href='" . route("user.r_semester", [$data->id, $data->s_2]) . "' class='btn btn-sm btn-bordered-danger waves-effect waves-light'> Target </a>";
                return $b;
            })->addColumn('status1', function ($data) {
                if ($data->status == 0) {
                    return "<b class='text-danger'> Belum Mengisi</b>";
                } elseif ($data->status == 1) {
                    return "<b class='text-danger'> Menunggu Persetujuan</b>";
                }
            })->addColumn('status2', function ($data) {
                if ($data->status == 0) {
                    return "<b class='text-danger'> Belum Mengisi</b>";
                } elseif ($data->status == 1) {
                    return "<b class='text-danger'> Menunggu Persetujuan</b>";
                }
            })->rawColumns(['aksi', 'status1', 'status2', 'period', 'skp1', 'skp2'])->make(true);
        }
        $tahun = Perdtahun::where('id_peg', Auth::user()->id_peg)->get();
        $period = Periode::orderBy('Aktif', 'desc')->orderBy('tahun_ajar', 'asc')->get();
        return view('user.rancangan.periode', compact('period', 'tahun'));
    }
    public function r_semester($id, $sem)
    {
        if (request()->ajax()) {
            return datatables()->of(target_semester::where('id_ped', $id)->where('id_sem', $sem)->get())->addIndexColumn()->addColumn('aksi', function ($data) {
                $b = "<button class='btn btn-sm btn-bordered-warning waves-effect waves-light mr-2' onclick=editj('" . $data->id . "')> Edit </button>";
                $b .= "<button type='button' class='btn btn-sm btn-bordered-danger waves-effect waves-light' onclick=delj('" . $data->id . "')> Hapus </button>";
                return $b;
            })->addColumn('tkuan', function ($data) {
                return $data->tkuantitas . ' ' . $data->satuan;
            })->addColumn('bulan', function ($data) {
                $monthNum  = $data->bulan;
                $monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March

                return $monthName;
            })->addColumn('status', function ($data) {
                return "<b class='text-danger'>Belum Disetujui</b>";
            })->rawColumns(['aksi', 'status', 'bulam', 'tkuan'])->make(true);
        }
        $tahun = Perdtahun::where('id_peg', Auth::user()->id_peg)->first();

        return view('user.rancangan.semester', compact('tahun'));
    }
    public function item()
    {
        if (request()->ajax()) {
            $id_jab = Jabatan::where('id_jab', Auth::user()->jabatanRemun)->first();
            $id_unit = Unit::where('id_unit', Auth::user()->idUnitRemun)->first();

            $id = Tupoksi::where('jab_id', $id_jab->id)->where('unit_id', $id_unit->id)->first();
            return datatables()->of(Itemtupok::where('jab_id', $id->id)->get())->addColumn('aksii', function ($dataa) {
                return '<button  onclick="copy(\'' . $dataa->item . '\')" data-tes="' . $dataa->item . '" class="btn btn-sm btn-bordered-warning waves-effect waves-light">C</button>';
            })->rawColumns(['aksii'])->make(true);
        }
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required',
            'kuantitas' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            try {
                $saved = target_semester::create([
                    'item' => $request->kegiatan,
                    'tkuantitas' => $request->kuantitas,
                    'tbiaya' => $request->biaya,
                    'twaktu' => $request->waktu,
                    'tkualitas' => '100',
                    'id_ped' => $request->idperiode,
                    'id_sem' =>  $request->idsemester,
                    'satuan' => $request->satuan,
                    'bulan' => $request->bulan,
                    'ket' => $request->keterangan
                ]);
            } catch (\Throwable $th) {
                return $th;
            }


            if ($saved) {

                return response()->json(['success' => 'Data Berhasil Terupload']);
            }
        }
    }
    public function sett($tahun)
    {
        $data = t_periode::select('id', 'status_bulan')->where('tahun', $tahun)->orderBy('semester', 'ASC')->get();
        return $data;
    }
    public function set(Request $request)
    {

        if (request()->input('id') == "null" || request()->input('id') == '') {
            $request->session()->forget('period');
        } else {
            $data = t_periode::where('id', request()->input('id'))->first();

            Session::put('period', request()->input('id'));
            Session::put('tahon', $data->tahun);
            Session::put('semester', $data->semester);
        }

        return redirect()->back();
    }
}
