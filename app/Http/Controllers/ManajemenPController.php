<?php

namespace App\Http\Controllers;

use App\Models\Manajemen_p;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Unit;
use App\Models\t_jabatan;
use App\Models\t_perilaku;
use App\Models\t_periode;
use App\Models\t_periodetahunan;
use App\Models\t_tahunpegawai;
use App\Models\t_rbulan;

class ManajemenPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
    {
        if (request()->ajax()) {
            return datatables()->of(t_periodetahunan::all())->addIndexColumn()->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return "<div class='badge badge-primary'>Tahun Periode Telah Diset </div>";
                } else {
                    return "<div class='badge badge-danger'>Belum Diset</div>";
                }
            })->addColumn('aksi', function ($data) {
                $btn = '<div class="d-flex">';
                $btn .= "<a class='btn btn-danger btn-sm waves-effect waves-light mb-2 mr-2' onclick='del(" . $data->tahun . ")' class='pr-2' type='button'> <i class='fa fa-trash'> </i> </a>";
                $btn .= '<a onclick="set(' . $data->tahun . ')" class="btn btn-success btn-sm waves-effect waves-light mb-2" >Set</a>';
                $btn .= '</div>';
                return $btn;
            })->addColumn('set', function ($data) {
            })->rawColumns(['status', 'aksi', 'set'])->make(true);
        }
        return view('admin.manajemen.tahunan');
    }
    public function delete()
    {
        $tahun = request()->input('id');
        $data = t_tahunpegawai::where('tahun', $tahun)->get();
        foreach ($data as $k) {
            Manajemen_p::findOrFail($k->id_semester_1)->delete();
            Manajemen_p::findOrFail($k->id_semester_2)->delete();
            t_tahunpegawai::findOrFail($k->id)->delete();
            t_perilaku::where('id_m', $k->id_semester_1)->delete();
            t_perilaku::where('id_m', $k->id_semester_2)->delete();
            t_rbulan::where('id_mn', $k->id)->delete();
        }
        t_periodetahunan::where('tahun', $tahun)->update([
            'status' => 0,
            'total' =>  0
        ]);
        return $data;
    }
    public function set()
    {
        $tahun = request()->input('tahun');
        $tahunlalu = $tahun - 1;
        $data = t_tahunpegawai::where('tahun', $tahunlalu)->get();
        $period = t_periode::where('tahun', $tahun)->get();

        foreach ($data as $d) {

            $sms1 = Manajemen_p::where('id', $d->id_semester_1)->get();
            $datas[] = $sms1;
            foreach ($sms1 as $s) {
                $total[] = $s;
                $mn1 = Manajemen_p::updateOrCreate([
                    'id_peg' => $s->id_peg,
                    'id_ped' => $period[0]->id,
                ], [
                    'id_peg' => $s->id_peg,
                    'pp' => $s->pp,
                    'ppt' => $s->ppt,
                    'appt' => $s->appt,
                    'id_jab' => $s->id_jab,
                    'id_ped' => $period[0]->id,
                    'jabatan' => $s->jabatan,
                    'status' => 'off',
                    'status_target' => '0',
                ]);
                $tp = t_tahunpegawai::updateOrCreate([
                    'id_peg' => $s->id_peg,
                    'tahun' =>  $tahun,
                ], [
                    'id_semester_1' => $mn1->id,
                    'status_1' => 0,
                    'status_2' => 0,
                    'nilai' => 0
                ]);
                t_rbulan::updateOrCreate(['id_mn' => $tp->id]);

                t_perilaku::updateOrCreate([
                    'id_m' => $mn1->id,
                ], [
                    'status' => '0'
                ]);
            }

            $sms2 = Manajemen_p::where('id', $d->id_semester_2)->get();
            foreach ($sms2 as $s) {
                $mn2 = Manajemen_p::updateOrCreate([
                    'id_peg' => $s->id_peg,
                    'id_ped' => $period[1]->id,

                ], [
                    'id_peg' => $s->id_peg,
                    'id_jab' => $s->id_jab,
                    'pp' => $s->pp,
                    'ppt' => $s->ppt,
                    'appt' => $s->appt,
                    'id_ped' => $period[1]->id,
                    'jabatan' => $s->jabatan,
                    'status' => 'off',
                    'status_target' => '0',
                ]);
                t_tahunpegawai::updateOrCreate([
                    'id_peg' => $s->id_peg,
                    'tahun' =>  $tahun,
                ], [
                    'id_semester_2' => $mn2->id,
                    'status_1' => 0,
                    'status_2' => 0,
                    'nilai' => 0
                ]);
                t_perilaku::updateOrCreate([
                    'id_m' => $mn2->id,
                ], [
                    'status' => '0'
                ]);
            }
        }
        t_periodetahunan::where('tahun', $tahun)->update([
            'status' => 1,
            'total' => count($datas) ?? 0
        ]);
        return 'success';
    }
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Pegawai::where('jenis_kepegawaian', 'pegawai')->get())->addIndexColumn()->addColumn('aksi', function ($data) {
                return '<a href="' . route('m_pegawai.show', $data->id_peg) . '"   class="btn btn-success btn-sm waves-effect waves-light"> Posisi </a>';
            })->rawColumns(['aksi'])->make(true);
        }
        return view('admin.manajemen.index');
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
            $data = t_periode::select('id')->where('tahun', request()->input('periode'))->get();
            foreach ($data as $key) {
                $datas[] =  Manajemen_p::create([
                    'id_peg' => request()->input('id'),
                    'id_jab' => request()->input('jab'),
                    'id_ped' => $key->id,
                    'jabatan' => request()->input('jab'),
                    'status' => $stat ?? 'off',
                    'status_target' => '0',
                ]);
            }

            $d = t_tahunpegawai::create([
                'id_peg' => request()->input('id'),
                'id_semester_1' => $datas[0]->id,
                'id_semester_2' => $datas[1]->id,
                'tahun' => request()->input('periode'),
                'status_1' => 0,
                'status_2' => 0,
                'nilai' => 0
            ]);



            t_perilaku::insert(['id_m' => $datas[0]->id, 'status' => '0']);
            t_perilaku::insert(['id_m' => $datas[1]->id, 'status' => '0']);
            t_rbulan::insert(['id_mn' => $d->id]);

            return "Success";
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manajemen_p  $manajemen_p
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(Manajemen_p::where('id_peg', $id)->get())->addIndexColumn()
                    ->addColumn('periode', function ($data) {
                        return $data->periode->status_bulan;
                    })->addColumn('status', function ($data) {
                        return $data->periode->status_aktif;
                    })->addColumn('tugas_j', function ($data) {
                        return $data->tugasjabatan->jabatan;
                    })
                    ->addColumn('tahun', function ($data) {
                        return $data->periode->tahun;
                    })
                    ->addColumn('pejabat', function ($data) {
                        $peg = Pegawai::select('nama')->where('id_peg', $data->pp)->first();
                        return $peg->nama ?? "<b class='text-danger'>Belum Di Set</b>";
                    })->addColumn('ppt', function ($data) {
                        $peg = Pegawai::select('nama')->where('id_peg', $data->ppt)->first();
                        return $peg->nama ?? "<b class='text-danger'>Belum Di Set</b>";
                    })->addColumn('appt', function ($data) {
                        $peg = Pegawai::select('nama')->where('id_peg', $data->appt)->first();
                        return $peg->nama ?? "<b class='text-danger'>Belum Di Set</b>";
                    })->addColumn('durasi', function ($data) {
                        return $data->awal . ' s/d ' . $data->akhir;
                    })->addColumn('Aksi', function ($data) {
                        return '  <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Aksi <i class="mdi mdi-menu"> </i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right border border-success" aria-labelledby="dropdownMenu2">
                        <button onclick="pp(' . $data->id . ')" class="dropdown-item" type="button"> <i class="mdi mdi-account"> </i> Set Pejabat Penilai</button>
                        <button onclick="ppt(' . $data->id . ')" class="dropdown-item" type="button"> <i class="mdi mdi-account"> </i> Set Pejabat Penanda Tangan</button>
                        <button onclick="appt(' . $data->id . ')" class="dropdown-item" type="button"> <i class="mdi mdi-account"> </i> Set Atasan Pejabat Penanda Tangan</button>
    
                        <button onclick="reset(' . $data->id . ')" class="dropdown-item" type="button"> <i class="mdi mdi-reload"> </i> Reset SKP</button>
                          <div class="dropdown-divider"></div>
                          <button onclick="upd(' . $data->id . ')" class="dropdown-item" type="button"> <i class="mdi mdi-square-edit-outline"> </i> Update</button>
                          <button onclick="del(' . $data->id . ')" class="dropdown-item" type="button"> <i class="mdi mdi-delete"> </i> Hapus Posisi</button>
                        </div>
                      </div>
    ';
                    })->rawColumns(['status', 'tahun', 'tugas_j', 'periode', 'Aksi', 'durasi', 'appt', 'ppt', 'pejabat'])->make(true);
            }
            $jab = t_jabatan::orderBy('id')->get();
            $tugas = t_jabatan::all();
            $unit = Unit::orderBy('unit')->get();
            $datap  = Pegawai::where('id_peg', $id)->first();
            $period = t_periode::select('tahun')->groupBy('tahun')->get();
            return view('admin.manajemen.posisi', compact('datap', 'tugas', 'unit', 'period'));
        } catch (\Throwable $th) {
            return $th;
            //throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manajemen_p  $manajemen_p
     * @return \Illuminate\Http\Response
     */
    public function edit(Manajemen_p $manajemen_p)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manajemen_p  $manajemen_p
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manajemen_p $manajemen_p)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manajemen_p  $manajemen_p
     * @return \Illuminate\Http\Response
     */
    public function getpegawai()
    {
        if (request()->ajax()) {
            return datatables()->of(Pegawai::where('jenis_kepegawaian', 'pegawai')->get())->addColumn('aksi', function ($data) {
                $id = request()->input('id');
                $kon = request()->input('kon');
                $idp = $data->id_peg;

                return '<a  onclick="simpanpp(' . $id . ',' . $idp . ',' . $kon . ')" class="btn btn-success btn-sm waves-effect waves-light"><i class="fa fa-plus" aria-hidden="true"></i>
                </a>';
            })->rawColumns(['aksi'])->make(true);
        }
    }
    public function postpegawai()
    {
        try {
            $idm = request()->input('idm');
            $idp = request()->input('idp');
            $idk = request()->input('idk');

            if ($idk == 1) {
                # code...
                $ok =  Manajemen_p::where('id', $idm)->update(['pp' => $idp, 'ppt' => $idp]);
            } elseif ($idk == 2) {
                $ok =  Manajemen_p::where('id', $idm)->update(['ppt' => $idp]);
            } elseif ($idk == 3) {
                $ok =  Manajemen_p::where('id', $idm)->update(['appt' => $idp]);
            }

            return 'success';
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function destroy($id)
    {
        $res = Manajemen_p::findOrFail($id);

        if ($res) {
            $res->delete();
            t_perilaku::where('id_m', $id)->delete();
            return "success";
        }
        return "fail";
    }
}
