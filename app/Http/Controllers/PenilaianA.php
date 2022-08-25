<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Manajemen_p;
use App\Models\t_periode;
use App\Models\target_semester;
use Illuminate\Support\Facades\Auth;
use App\Models\t_log;
use App\Models\t_rbulan;
use App\Models\t_tahunpegawai;

class PenilaianA extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check($id)
    {
        if ($id == 1) {
            return 'table-info';
        } elseif ($id == 2) {
            return 'table-success w-100';
        }
    }
    public function reset()
    {
        $bulan = request()->input('bul');
        $id = request()->input('id');
        $data = target_semester::where(function ($query) use ($id, $bulan) {
            $query->where('id_ped', $id)->where('bulan', $bulan);
        })->update([
            'status' => '1',
            'nilai_atasan' => NULL,
            'nilai_capaian' => null,
            'feedback' => null
        ]);
        return 'success';
    }
    public function isi()
    {

        $id = request()->input('id');
        $bul = request()->input('bul');
        $tbl = '';
        $data = target_semester::where('id_ped', $id)->where('bulan', $bul)->where(function ($q) {
            $q->where('status', '1')->orWhere('status', '2');
        })->get();
        $no = 1;
        foreach ($data as $value) {
            $totallog = t_log::where('id_target', $value->id)->get();
            $tbl .= '<tbody class="' . $this->check($value->status) . '">
            <tr>
                <th style="width:3%;" scope="row">' . $no++ . '</th>
                <th style="width:5%;">Kegiatan</th>
                <td class=" text-left" colspan="3">' . $value->tupoksi->uraian . '</td>
            </tr>
            <tr>
                <th scope="row"></th>
                <th>Aktivitas</th>
                <td class="text-left" colspan="3">' . $value->kegiatan . '</td>
            </tr>
            <tr>
                <th scope="row"></th>
                <th>Keterangan</th>
                <td class="text-left" colspan="3">' . $value->ket . '</td>
            </tr>
            <tr>
                <th colspan="2"><b>Log Harian</b> : <div class="badge badge-success" type="button" onclick="loghariani(' . $value->id . ')"> ' . $totallog->count() . '</div></th>

                <td><b>Target Output</b> :' . $value->tkuantitas . ' ' . $value->satuan . '</td>
                <td><b>Realisasi Output</b> :' . $value->rkuantitas . ' ' . $value->satuan . '</td>
                <td><b>Permohonan Nilai </b>: ' . $value->nilai_mutu . '%</td>
            </tr>
            <tr>
                <td class="text-left" colspan="4">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"><b>Feedback</b></label>
                        <textarea name="kr[]" placeholder="Keterangan Penilaian" class="form-control" id="exampleFormControlTextarea1" rows="1">' . $value->feedback . '</textarea>
                    </div>
                </td>
                <td class="text-left">
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>Input Penilaian</b></label>
                        <input name="nr[]" type="number" max="100" min="50" value="' . $value->nilai_atasan . '" class="form-control" id="formGroupExampleInput" placeholder="Nilai Kualitas">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="" colspan="5"></td>
            </tr>
            <input name="id[]" type="hidden" value="' . $value->id . '">

        </tbody><tbody>
        <tr><td></td></tr></tbody>';
        }

        return $tbl;
    }
    public function bulan()
    {

        if (Session::has('period')) {
            $idp = Session::get('period');
            $ida = Auth::user()->id_peg;

            $id_mn = Manajemen_p::where('id_ped', $idp)->where('pp', $ida)->first() ?? "null";
            $datap = t_periode::where('id', $idp)->first();
            if ($id_mn != "null") {

                if (request()->ajax()) {

                    return datatables()->of(Manajemen_p::where('id_ped', $idp)->where('pp', $ida)->get())->addIndexColumn()->addColumn('nip', function ($data) {
                        return $data->datapegawai->nip;
                    })->addColumn('nama', function ($data) {
                        return $data->datapegawai->nama;
                    })->addColumn('jabatan', function ($data) {
                        return $data->datapegawai->jabatan;
                    })->addColumn('status_real', function ($data) {
                        $total2 = target_semester::where('status', '2')->where('id_ped', $data->id)->where('bulan', request()->input('id'))->get();
                        return $total2->count();
                    })->addColumn('status_target', function ($data) {
                        $total = target_semester::where('id_ped', $data->id)->where('bulan', request()->input('id'))->get();
                        $total2 = target_semester::whereIn('status', ['1', '2'])->where('id_ped', $data->id)->where('bulan', request()->input('id'))->get();
                        return $total2->count() . '/' . $total->count();
                    })->addColumn('nilait', function ($data) {
                        $total = target_semester::where('id_ped', $data->id)->where('bulan', request()->input('id'))->get() ?? null;
                        $nilai = [0];
                        if ($total != null) {
                            # code...
                            foreach ($total as $value) {
                                if ($value['status'] == '2') {
                                    $target = (($value['rkuantitas'] / $value['tkuantitas']) * 100) + $value['nilai_atasan'] ?? 0;
                                    $nilai[] =  $target / 2;
                                }
                            }
                        } else {
                            $nilai = [0];
                        }
                        if (array_sum($nilai) > 0) {
                            # code...
                            return array_sum($nilai) / (count($nilai) - 1);
                        } else {
                            return array_sum($nilai) / count($nilai);
                        }
                    })->addColumn('aksi', function ($data) {
                        $btn = '<div class="float-right">';
                        $btn .= ' <button type="button" onclick="nilai(\'' . $data->id . '\',\'' . request()->input('id') . '\')" class="btn btn-warning btn-xs waves-effect waves-light"> Isi Nilai </button>';
                        $btn .= ' <button type="button" onclick="reset(\'' . $data->id . '\',\'' . request()->input('id') . '\')" class="btn btn-primary btn-xs waves-effect waves-light"> Reset Nilai</button>';
                        $btn .= ' <button type="button" onclick="lihatlogs(\'' . $data->id . '\',\'' . request()->input('id') . '\')" class="btn btn-primary btn-xs waves-effect waves-light"> Log Harian</button>';
                        $btn .= '</div>';
                        return $btn;
                    })->rawColumns(['nip', 'aksi', 'nilait', 'status_real'])->make(true);
                }
            }
        }
    }
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
            if (request()->input('id')) {
                # code...
            }
            $idp = Session::get('period');
            $ida = Auth::user()->id_peg;
            $ids = '';
            $smst = '';
            $datap = t_periode::where('id', $idp)->first();
            if ($datap->semester == 1) {
                $smst = json_decode(json_encode($smstr1));
            }
            if ($datap->semester == 2) {
                $smst = json_decode(json_encode($smstr2));
            }
            if (request()->ajax()) {
                return datatables()->of(Manajemen_p::where('id_ped', $idp)->where('pp', $ida)->get())->addIndexColumn()->addColumn('nip', function ($data) {
                    return $data->datapegawai->nip;
                })->addColumn('nama', function ($data) {
                    return $data->datapegawai->nama;
                })->addColumn('jabatan', function ($data) {
                    return $data->datapegawai->jabatan;
                })->addColumn('aksi', function ($data) {
                    $btn = '<div class="d-flex justify-content-around">';
                    $btn .= ' <button type="button" class="btn btn-warning btn-xs waves-effect waves-light"><i class="fa fa-bars"></i> Isi Nilai </button>';
                    $btn .= ' <button type="button" class="btn btn-primary btn-xs waves-effect waves-light"><i class="fa fa-bars"></i> Reset Nilai</button>';
                    $btn .= ' <button type="button" class="btn btn-primary btn-xs waves-effect waves-light"><i class="fa fa-bars"></i> Log Harian</button>';
                    $btn .= '</div>';
                    return $btn;
                })->rawColumns(['nip', 'aksi'])->make(true);
            }
        }


        return view('user.penilaian.index', compact('datap', 'smst'));
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
        $ket = request()->input('kr');
        $nilai = request()->input('nr');
        $id = request()->input('id');
        $id_peg = Auth::user()->id_peg;

        foreach ($id as $key => $value) {
            $d = target_semester::where('id', $id)->first();
            $nilaic[] = ((($d->rkuantitas / $d->tkuantitas) * 100) +  (($nilai[$key] / 100) * 100)) / 2;
        }
        $bulan = $d->bulan;
        switch ($bulan) {
            case "1":
                $nb = 'jan';
                break;
            case "2":
                $nb = 'feb';
                break;
            case "3":
                $nb = 'mar';
                break;
            case "4":
                $nb = 'apr';
                break;
            case "5":
                $nb = 'mei';
                break;
            case "6":
                $nb = 'jun';
                break;
            case "7":
                $nb = 'jul';
                break;
            case "8":
                $nb = 'agus';
                break;
            case "9":
                $nb = 'sep';
                break;
            case "10":
                $nb = 'okt';
                break;
            case "11":
                $nb = 'nov';
                break;
            case "12":
                $nb = 'des';
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }

        try {
            target_semester::upsert(collect($ket)->map(function ($v, $k) use ($id, $nilai, $nilaic, $ket) {
                echo $id[$k];
                return [
                    'id' => $id[$k],
                    'nilai_atasan' => $nilai[$k],
                    'status' => "2",
                    'nilai_capaian' => $nilaic[$k],
                    'feedback' => $ket[$k]
                ];
            })->toArray(), ['id'], ['status', 'nilai_atasan', 'nilai_capaian', 'feedback']);

            $id_ped = $d->id_ped;
            $nilai = array_sum($nilaic) / count($id);

            if (Session::get('semester') == '1') {
                $dt = t_tahunpegawai::with('bulan')->where('id_semester_1', $id_ped)->first();
            } else {
                $dt = t_tahunpegawai::with('bulan')->where('id_semester_2', $id_ped)->first();
            }
            t_rbulan::where('id_mn', $dt->id)->update([$nb => $nilai]);
            return "success";
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
