<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\t_tahunpegawai;
use Illuminate\Support\Facades\DB;

class Monitoring extends Controller
{
    public function skp()
    {
        if (request()->ajax()) {
            return datatables()->of(t_tahunpegawai::with(['skp1', 'skp2'])->rightJoin('pegawais', 'pegawais.id_peg', '=', 't_tahunpegawais.id_peg')->orderBy('t_tahunpegawais.tahun', 'DESC')->get())->addIndexColumn()->addColumn('aksi', function ($data) {
                return '<a title="mana" href="' . route('m_pegawai.show', $data->id_peg) . '"   class="btn btn-success btn-sm waves-effect waves-light"> Posisi </a>';
            })->addIndexColumn()->addColumn('r1', function ($data) {
                if ($data->skp1 != null) {
                    if ($data->skp1->status_target == '3' || $data->skp1->status_target == '1') {
                        $btn = '<div class="badge badge-success" type="button" > Telah Menyusun </div>';
                    } else {
                        $btn = '<div class="badge badge-danger" type="button" > Belum Menyusun </div>';
                    }
                } else {
                    $btn = '<div class="badge badge-danger" type="button" > Belum Menyusun </div>';
                }
                return $btn;
            })->addIndexColumn()->addColumn('r2', function ($data) {
                if ($data->skp2 != null) {
                    if ($data->skp2->status_target == '3' || $data->skp2->status_target == '1') {
                        $btn = '<div class="badge badge-success" type="button" > Telah Menyusun </div>';
                    } else {
                        $btn = '<div class="badge badge-danger" type="button" > Belum Menyusun </div>';
                    }
                } else {
                    $btn = '<div class="badge badge-danger" type="button" > Belum Menyusun </div>';
                }

                return $btn;
            })->addIndexColumn()->addColumn('p1', function ($data) {
                if ($data->skp1 != null) {
                    if ($data->skp1->status_target == '1') {
                        $btn = '<div class="badge badge-success" type="button" > Telah Disetujui </div>';
                    } elseif ($data->skp1->status_target == '2') {
                        $btn = '<div class="badge badge-warning" type="button" > Ditolak </div>';
                    } else {
                        $btn = '<div class="badge badge-danger" type="button" > Belum Disetujui </div>';
                    }
                } else {
                    $btn = '<div class="badge badge-danger" type="button" > Belum Menyusun </div>';
                }

                return $btn;
            })->addIndexColumn()->addColumn('p2', function ($data) {
                if ($data->skp2 != null) {
                    if ($data->skp2->status_target == '1') {
                        $btn = '<div class="badge badge-success" type="button" > Telah Disetujui </div>';
                    } elseif ($data->skp2->status_target == '2') {
                        $btn = '<div class="badge badge-warning" type="button" > Ditolak </div>';
                    } else {
                        $btn = '<div class="badge badge-danger" type="button" > Belum Disetujui </div>';
                    }
                } else {
                    $btn = '<div class="badge badge-danger" type="button" > Belum Menyusun </div>';
                }

                return $btn;
            })->rawColumns(['aksi', 'r1', 'r2', 'p1', 'p2'])->make(true);
        }
        return view('admin.monitoring.skp');
    }
    public function log()
    {
        if (request()->ajax()) {
            return datatables()->of(t_tahunpegawai::with(['skp1', 'skp2', 'log1', 'log2'])->select('t_tahunpegawais.tahun', 't_tahunpegawais.id_semester_1', 't_tahunpegawais.id_peg', 't_tahunpegawais.id_semester_2', 'pegawais.nama', 'pegawais.nip', 'pegawais.id_peg')->rightJoin('pegawais', 'pegawais.id_peg', '=', 't_tahunpegawais.id_peg')->orderBy('t_tahunpegawais.tahun', 'DESC')->get())->addIndexColumn()->addColumn('aksi', function ($data) {
                return '<a title="mana" href="' . route('m_pegawai.show', $data->id_peg) . '"   class="btn btn-success btn-sm waves-effect waves-light"> Posisi </a>';
            })->addIndexColumn()->addColumn('r1', function ($data) {
                if ($data->skp1 != null) {
                    if ($data->skp1->status_target == '1') {
                        $btn = '<div class="badge badge-success" type="button" > Telah Disetujui </div>';
                    } elseif ($data->skp1->status_target == '2') {
                        $btn = '<div class="badge badge-warning" type="button" > Ditolak </div>';
                    } else {
                        $btn = '<div class="badge badge-danger" type="button" > Belum Disetujui </div>';
                    }
                } else {
                    $btn = '<div class="badge badge-danger" type="button" > Belum Menyusun </div>';
                }
                return $btn;
            })->addIndexColumn()->addColumn('r2', function ($data) {
                if ($data->skp2 != null) {
                    if ($data->skp2->status_target == '1') {
                        $btn = '<div class="badge badge-success" type="button" > Telah Disetujui </div>';
                    } elseif ($data->skp2->status_target == '2') {
                        $btn = '<div class="badge badge-warning" type="button" > Ditolak </div>';
                    } else {
                        $btn = '<div class="badge badge-danger" type="button" > Belum Disetujui </div>';
                    }
                } else {
                    $btn = '<div class="badge badge-danger" type="button" > Belum Menyusun </div>';
                }

                return $btn;
            })->addIndexColumn()->addColumn('p1', function ($data) {

                $btn = "<button type='button' class='badge badge-warning' onclick='log(" . json_encode($data->log1)  . ");'>" . $data->log1->count() . " </button>";

                return $btn;
            })->addIndexColumn()->addColumn('p2', function ($data) {
                $btn = "<button type='button' class='badge badge-warning' onclick='log(" . json_encode($data->log2)  . ");'>" . $data->log2->count() . " </button>";

                return $btn;
            })->rawColumns(['aksi', 'r1', 'r2', 'p1', 'p2'])->make(true);
        }
        return view('admin.monitoring.log');
    }
}
