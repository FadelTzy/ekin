<?php

namespace App\Http\Controllers;

use App\Models\t_perilaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Manajemen_p;
use App\Models\t_periode;
use Illuminate\Support\Facades\Auth;
use App\Models\t_tahunpegawai;

class TPerilakuController extends Controller
{
    public function kriteria2($nil)
    {
        if ($nil >= 110 && $nil <= 120) {
            return 'Sangat Baik';
        } elseif ($nil >= 90 && $nil <= 109) {
            return 'Baik';
        } elseif ($nil >= 70 && $nil <= 89) {
            return 'Cukup';
        } elseif ($nil >= 50 && $nil <= 69) {
            return 'Kurang';
        } elseif ($nil >= 1 && $nil < 50) {
            return 'Sangat Buruk';
        } else {
            return '-';
        }
    }
    public function kriteria($nil)
    {
        if ($nil >= 91 && $nil <= 100) {
            return 'Sangat Baik';
        } elseif ($nil >= 76 && $nil <= 90) {
            return 'Baik';
        } elseif ($nil >= 61 && $nil <= 75) {
            return 'Cukup';
        } elseif ($nil >= 51 && $nil <= 60) {
            return 'Kurang';
        } elseif ($nil >= 1 && $nil <= 50) {
            return 'Sangat Buruk';
        } else {
            return '-';
        }
    }
    public function konversi($nil)
    {
        if ($nil > 90 && $nil <= 99) {
            $nilai = 110 + (((120 - 110) / (99 - 91)) * ($nil - 91));
            return $nilai;
        } elseif ($nil > 75 && $nil <= 90) {
            $nilai = 90 + (((109 - 90) / (90 - 76)) * ($nil - 76));
            return $nilai;
        } elseif ($nil > 60 && $nil <= 75) {
            $nilai = 70 + (((89 - 70) / (75 - 61)) * ($nil - 61));
            return $nilai;
        } elseif ($nil > 50 && $nil <= 60) {
            $nilai = 50 + (((69 - 50) / (60 - 51)) * ($nil - 51));
            return $nilai;
        } elseif ($nil <= 50) {
            $nilai = ($nil / 50) * 49;
            return $nilai;
        } else {
            return '120';
        }
    }
    public function integrasinilai()
    {
        try {
            $data = request()->input('id');
            $tahun =  Session::get('tahon');
            $data = t_tahunpegawai::where('id_peg', $data['id_peg'])->where('tahun', $tahun)->update([
                'status_1' => $data['nilaip1k'],
                'status_2' => $data['nilaip2k'],
                'nilai' => $data['total'],
                'predikat' => $data['predikat'],
                'tanggalnilai' => date('d M Y')
            ]);
            if ($data) {
                # code...
                return 'success';
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function integrasi()
    {
        $tahun =  Session::get('tahon');
        $ida = request()->input('id');
        $data = t_tahunpegawai::where('id_peg', $ida)->where('tahun', $tahun)->first();
        $m1 = Manajemen_p::select('nilai_skp', 'nilai_kerja')->where('id', $data->id_semester_1)->first();
        $m2 = Manajemen_p::select('nilai_skp', 'nilai_kerja')->where('id', $data->id_semester_2)->first();
        $data['nilaip1'] = number_format($m1->nilai_skp * 0.6 + $m1->nilai_kerja * 0.4, 2, '.');
        $data['nilaip2'] =  number_format($m2->nilai_skp * 0.6 + $m2->nilai_kerja * 0.4, 2, '.') + 2;
        $data['nilaip1k'] = number_format($this->konversi($data['nilaip1']), 2, '.');
        $data['nilaip2k'] = $data['nilaip2'];
        $data['total'] =  $data['nilaip1k'] * 0.5 + $data['nilaip2k'] * 0.5;
        $data['predikat'] = $this->kriteria2($data['total']);
        $btn = '   <table class="table table-bordered table-hover table-striped">
        <tbody>
        <tr>
        <td colspan="1" style="width: 350px;"><b>Tanggal Intergasi Penilaian</b></td>
        <td colspan="2" class="" style="width: 200px;">
            <b>' . $data->tanggalnilai . '</b>
        </td>

    </tr>
            <tr>
                <td colspan="1" style="width: 350px;"><b>Periode</b></td>
                <td colspan="1" class="text-center" style="width: 200px;">
                    <b> Nilai Prestasi</b>
                </td>
                <td colspan="1" class="text-center" style="width: 200px;"> <b> Nilai Konversi</b> </td>

            </tr>
            <tr>
                <td style="width: 350px;">JANUARI - JUNI</td>
                <td style="width: 200px;" class="text-center">
' . $data['nilaip1'] . '
                </td>
                <td>' . $data['nilaip1k'] . '</td>
            </tr>
            <tr>
                <td>JULI - DESEMBER</td>
                <td class="text-center">
' . $data['nilaip2'] . '
                </td>
                <td>' . $data['nilaip2k'] . '</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Nilai Kinerja PNS Tahun ' . Session::get("tahon") . '</strong>
                </td>
                <td><strong> ' .  $data['total'] . '</strong></td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Predikat</strong>
                </td>
                <td><strong>' . $data['predikat'] . '</strong></td>
            </tr>
        </tbody>
    </table>';
        $btn .= "<div class='float-right' id=''>
        <button onclick='integr(" . $data .  ")'  type='button' class='btn btn-sm btn-info waves-effect waves-light' data-toggle='modal' data-target='#dbp'>Integrasi</button>
</div>";

        return $btn;
    }
    public function reset()
    {
        $id = request()->input('id');

        $data = Manajemen_p::where('id', $id)->update(['nilai_kerja' => '0']);
        $perilaku = t_perilaku::where('id_m', $id)->update([
            'orientasi_pelayanan' => '0',
            'komitmen' => '0',
            'disiplin' => '0',
            'kerjasama' => '0',
            'kepemimpinan' => '0',
            'inisiatif_kerja' => '0',
            'integritas' => '0',
            'status' => '0',
            'created_at' => null
        ]);
        return $data;
    }
    public function check()
    {
        $data = request()->input('data');
        $nilaiskp = request()->input('nilai');
        $aspek[] = $data['orientasi_pelayanan'];
        $aspek[] = $data['komitmen'];
        $aspek[] = $data['kerjasama'];
        $aspek[] = $data['kepemimpinan'];

        $nilaiskp = $nilaiskp ?? 0;
        $kali60 = $nilaiskp * 0.6;

        if (Session::get('semester') == '1') {
            $aspek[] = $data['integritas'];
            $aspek[] = $data['disiplin'];
            foreach ($aspek as $key) {
                if ($key != '0') {
                    $jumlah[] = $key;
                }
            }
            $rpk = (array_sum($aspek) / count($jumlah)) * 0.4;

            $tabel = '<table class="table w-100 table-bordered table-hover">
            <tbody>
                <tr style="width: 100%;">
                    <td colspan="4">UNSUR YANG DINILAI</td>
                    <td>JUMLAH</td>
                </tr>
                <tr>
                    <td colspan="2">a. Sasaran Kerja Pegawai (SKP)</td>
                    <td colspan="2" class="text-center">' . number_format((float)$nilaiskp, 2, '.') . ' x 60%</td>
                    <td>' . number_format((float)$kali60, 2, '.') . '</td>
                </tr>
                <tr>
                    <td rowspan="9">b. Perilaku Kerja</td>
                    <td>1. Orientasi Pelayanan</td>
                    <td>' . $data['orientasi_pelayanan'] . '</td>
                    <td>' . $this->kriteria($data['orientasi_pelayanan']) . ' </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>2. Integritas</td>
                    <td>' . $data['integritas'] . '</td>
                    <td>' . $this->kriteria($data['integritas']) . '</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>3. Komitmen</td>
                    <td>' . $data['komitmen'] . '</td>
                    <td>' . $this->kriteria($data['komitmen']) . ' </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>4. Disiplin</td>
                    <td>' . $data['disiplin'] . '</td>
                    <td>' . $this->kriteria($data['disiplin']) . ' </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>5. Kerjasama</td>
                    <td>' . $data['kerjasama'] . '</td>
                    <td>' . $this->kriteria($data['kerjasama']) . ' </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>6. Kepemimpinan</td>
                    <td>' . $data['kepemimpinan'] . '</td>
                    <td>' . $this->kriteria($data['kepemimpinan']) . '</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>' . array_sum($aspek) . '</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Nilai Rata-Rata</td>
                    <td>' . number_format((float)array_sum($aspek) / count($jumlah), 2, '.')   . '</td>
                    <td>' . $this->kriteria(array_sum($aspek) / count($jumlah)) . ' </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                <td>Perilaku Kerja</td>
                <td colspan="2" class="text-center">'  . number_format((float)array_sum($aspek) / count($jumlah), 2, '.')   . ' x 40%</td>
                <td>' . number_format((float)$rpk, 2, '.') . '</td>
            </tr>
                <tr>
                    <td style="vertical-align: middle; text-align: center" colspan="4" >NILAI PRESTASI KERJA</td>
                    <td>' . number_format((float)$rpk + $kali60, 2, '.')  . '</td>
                </tr>
            
       
            <tr>
            <td style="vertical-align: middle; text-align: center" colspan="4" >NILAI KERJA PERIODE JANUARI - JULI</td>
            <td>' . number_format((float)$this->konversi($rpk + $kali60), 2, '.')   . '</td>
        </tr>
            </tbody>
        </table>';
        } elseif (Session::get('semester') == '2') {
            $aspek[] = $data['inisiatif_kerja'];
            foreach ($aspek as $key) {
                if ($key != '0') {
                    $jumlah[] = $key;
                }
            }
            $rpk = (array_sum($aspek) / count($jumlah)) * 0.4;
            $tabel = '<table class="table w-100 table-bordered table-hover">
            <tbody>
                <tr style="width: 100%;">
                    <td colspan="4">UNSUR YANG DINILAI</td>
                    <td>JUMLAH</td>
                </tr>
                <tr>
                    <td colspan="2">a. Sasaran Kerja Pegawai (SKP)</td>
                    <td colspan="2" class="text-center">' . $nilaiskp . ' x 60%</td>
                    <td>' . $kali60 . '</td>
                </tr>
                <tr>
                    <td rowspan="8">b. Perilaku Kerja</td>
                    <td>1. Orientasi Pelayanan</td>
                    <td>' . $data['orientasi_pelayanan'] . '</td>
                    <td>' . $this->kriteria($data['orientasi_pelayanan']) . '  </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>2. Inisiatif Kerja</td>
                    <td>' . $data['inisiatif_kerja'] . '</td>
                    <td>' . $this->kriteria($data['inisiatif_kerja']) . ' </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>3. Komitmen</td>
                    <td>' . $data['komitmen'] . '</td>
                    <td>' . $this->kriteria($data['komitmen']) . ' </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>4. Kerjasama</td>
                    <td>' . $data['kerjasama'] . '</td>
                    <td>' . $this->kriteria($data['kerjasama']) . '  </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>5. Kepemimpinan</td>
                    <td>' . $data['kepemimpinan'] . '</td>
                    <td>' . $this->kriteria($data['kepemimpinan']) . ' </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>' . array_sum($aspek) . '</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Nilai Rata-Rata</td>
                    <td>' . array_sum($aspek) / count($jumlah) . '</td>
                    <td>' . $this->kriteria(array_sum($aspek) / count($jumlah)) . ' </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Perilaku Kerja</td>
                    <td colspan="2" class="text-center">' . array_sum($aspek) / count($jumlah) . ' x 40%</td>
                    <td>' . $rpk . '</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; text-align: center" colspan="4" >IDE BARU</td>
                    <td>' . 2 . '</td>
                </tr>
                <tr>
                <td style="vertical-align: middle; text-align: center" colspan="4" >NILAI PRESTASI KERJA</td>
                <td>' . $rpk + $kali60  + 2 . '</td>
            </tr>
        
            </tbody>
        </table>';
        }


        return ($tabel);
    }
    public function sms1()
    {
        $aspek[] = request()->input('orientasi');
        $aspek[] = request()->input('komitmen');
        $aspek[] = request()->input('kerja');
        $aspek[] = request()->input('kepemimpinan');
        $d_perilaku = t_perilaku::select('id_m')->where('id', request()->input('idp'))->first();
        if (Session::get('semester') == '1') {
            $aspek[] = request()->input('integritas');
            $aspek[] = request()->input('disiplin');
            t_perilaku::where('id', request()->input('idp'))->update([
                'orientasi_pelayanan' => $aspek[0],
                'komitmen' => $aspek[1],
                'kerjasama' => $aspek[2],
                'kepemimpinan' => $aspek[3],
                'integritas' => $aspek[4],
                'disiplin' => $aspek[5],
                'status' => '1',
                'created_at' => date('Y-m-d')
            ]);
        } else if (Session::get('semester') == '2') {
            $aspek[] = request()->input('inisiatif');
            t_perilaku::where('id', request()->input('idp'))->update([
                'orientasi_pelayanan' => $aspek[0],
                'komitmen' => $aspek[1],
                'kerjasama' => $aspek[2],
                'kepemimpinan' => $aspek[3],
                'inisiatif_kerja' => $aspek[4],
                'status' => '1',
                'created_at' => date('Y-m-d')


            ]);
        }
        $sum = array_sum($aspek);

        foreach ($aspek as $key) {
            if ($key != '0') {
                $jumlah[] = $key;
            }
        }
        $total = $sum / count($jumlah);
        Manajemen_p::where('id', $d_perilaku->id_m)->update(['nilai_kerja' => $total]);



        return 'success';
    }
    /**
     * Display a listing of the resource.
     * 0 baru set
     * 1 telah dinilai
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::has('period')) {
            $idp = Session::get('period');
            $semester = t_periode::select('semester')->where('id', $idp)->first();
            if (request()->ajax()) {
                return datatables()->of(Manajemen_p::with('perilaku')->where(function ($query) use ($idp) {
                    $query->where('pp', Auth::user()->id_peg)->where('id_ped', $idp);
                })->get())->addIndexColumn()->addColumn('nip', function ($data) {
                    return $data->datapegawai->nip;
                })->addColumn('nama', function ($data) {
                    return $data->datapegawai->nama;
                })->addColumn('aksi', function ($data) {
                    $id = $data->perilaku ?? '0';
                    if ($data->status_target == 0) {
                        return "<b class='text-danger text-small'>Belum Diset</b>";
                    } else {
                        $btn = '<ul class="list-inline table-action m-0">';
                        $btn .= "<li class='list-inline-item'>
                        <a href='javascript:void(0);' data-toggle='modal' data-target='#con-close-modal' onclick='nilai(" . json_encode($id) . "," . $data->id . ")' class='action-icon'> <i class='fa fas fa-edit'></i></a>
                    </li>";

                        $btn .= '<li class="list-inline-item">
                            <a href="javascript:void(0);" onclick="reset(' . $data->id . ')" class="action-icon"> <i class="fa fas fa-undo"></i></a>
                        </li>';
                        $btn .= "<li class='list-inline-item'>
                        <a href='javascript:void(0);' data-toggle='modal' data-target='#check' onclick='check(" . json_encode($id) .  "," . $data->nilai_skp . ")' class='action-icon'> <i class='fa fas fa-list'></i></a>
                    </li>";
                        if (Session::get('semester') == '2') {
                            $btn .= "<li class='list-inline-item'>
                            <a href='javascript:void(0);' data-toggle='modal' data-target='#integrasi' onclick='integrasi(" . $data->id_peg . ")' class='action-icon'> <i class='far fa-window-restore'></i></a>
                        </li>";
                        }

                        return $btn;
                    }
                })->addColumn('jabatan', function ($data) {
                    return $data->datapegawai->jabatan;
                })->addColumn('period', function ($data) {
                    return $data->periode->status_bulan;
                })->addColumn('status', function ($data) {

                    if ($data->perilaku != null) {
                        if ($data->perilaku->status == '1') {
                            return "<b class='badge badge-info text-small'>Telah Dinilai</b>";
                        } else {
                            return "<b class='badge badge-warning text-small'>Menunggu Penilaian</b>";
                        }
                    }
                    if ($data->status_target == 0) {
                        return "<b class='badge badge-danger text-small'>Belum Diset</b>";
                    } elseif ($data->status_target == 1) {
                        return "<b class='badge badge-warning text-small'>Menunggu Penilaian</b>";
                    }
                })->rawColumns(['aksi', 'status', 'nip', 'status', 'jabatan', 'period'])->make(true);
            }
        }
        if ($semester->semester == '2') {
            $form = '<form action=""  id="sms1"  method="post">
            <input type="hidden" name="idp" id="idp">
            <div class="modal-body p-2">
            <div class="row mb-2">
            <div class="col-6">
                <div class="float-left" id="btnpegawai">
                <button type="button" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" data-target="#bp">Data Pegawai</button>
                </div>

            </div>
            <div class="col-6 d-flex justify-content-end">
         
                <div class="float-right" >
                <button type="button" class="btn btn-sm btn-warning waves-effect waves-light" data-toggle="modal" data-target="#kriteria">Kriteria Penilaian</button>

                </div>
            </div>
        </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Orientasi Pelayanan</label>
                            <input type="number" max="100" min="0" value="0" required class="form-control" name="orientasi" id="orientasi">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Komitmen</label>
                            <input type="number" max="100" min="0" value="0" required class="form-control" name="komitmen" id="komitmen">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Inisiatif Kerja</label>
                            <input type="number" max="100" min="0" value="0" required class="form-control" name="inisiatif" id="inisiatif">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Kerja Sama</label>
                            <input type="number" max="100" min="0" value="0" required class="form-control" name="kerja" id="kerja">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Kepemimpinan</label>
                            <input type="number" max="100" min="0" value="0" required class="form-control" name="kepemimpinan" id="kepemimpinan">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" id="btnsms1" class="btn btn-info waves-effect waves-light">Simpan</button>
            </div>
        </form>';
        } else if ($semester->semester == '1') {
            $form = '<form action="" id="sms1" method="post">
            <input type="hidden" name="idp" id="idp">
            <div class="modal-body p-2">
            <div class="row mb-2">
            <div class="col-6">
                <div class="float-left" id="btnpegawai">
                <button type="button" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" data-target="#bp">Data Pegawai</button>
                </div>

            </div>
            <div class="col-6 d-flex justify-content-end">
                <div class="float-right pr-2" id="btntolak">

                </div>
                <div class="float-right" >
                <button type="button" class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="modal" data-target="#kriteria">Kriteria Penilaian</button>
                </div>
            </div>
        </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Orientasi Pelayanan</label>
                            <input type="number" max="100" required min="0" value="0" class="form-control" name="orientasi" id="orientasi">
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-3" class="control-label">Integritas</label>
                        <input type="number" max="100" required min="0" value="0" class="form-control" name="integritas" id="integritas">
                    </div>
                </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Komitmen</label>
                            <input type="number" max="100" required min="0" value="0" class="form-control" name="komitmen" id="komitmen">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Disiplin</label>
                            <input type="number" max="100" required min="0" value="0" class="form-control" name="disiplin" id="disiplin">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Kerja Sama</label>
                            <input type="number" max="100" required min="0" value="0" class="form-control" name="kerja" id="kerja">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Kepemimpinan</label>
                            <input type="number" max="100" required min="0" value="0" class="form-control" name="kepemimpinan" id="kepemimpinan">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" id="btnsms1" class="btn btn-info waves-effect waves-light">Simpan</button>
            </div>
        </form>';
        }
        return view('user.perilaku.penilaian', compact('form'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\t_perilaku  $t_perilaku
     * @return \Illuminate\Http\Response
     */
    public function show(t_perilaku $t_perilaku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\t_perilaku  $t_perilaku
     * @return \Illuminate\Http\Response
     */
    public function edit(t_perilaku $t_perilaku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\t_perilaku  $t_perilaku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, t_perilaku $t_perilaku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\t_perilaku  $t_perilaku
     * @return \Illuminate\Http\Response
     */
    public function destroy(t_perilaku $t_perilaku)
    {
        //
    }
}
