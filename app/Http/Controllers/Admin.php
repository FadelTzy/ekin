<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Periode;
use App\Models\Jabatan;
use App\Models\Peginfo;
use App\Models\statusJabDosen;
use App\Models\t_admin;

class Admin extends Controller
{
    public function edit(Request $request)
    {
        $aslisi = t_admin::findOrFail($request->idid);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string',  'max:255'],
        ]);

        if ($request->password) {
            $validator = Validator::make($request->all(), [

                'password' => ['required', 'confirmed', 'min:3', 'max:30'],
            ]);
            $password = $request->passwordu;
        }
        if ($validator->fails()) {
            $data = ['status' => 'error', 'data' => $validator->errors()];
            return $data;
        }
        if ($request->thumbnail) {
            $validator = Validator::make($request->all(), [

                'thumbnail' => 'mimes:jpeg,png,jpg|max:400',

            ]);
            if ($aslisi->gambar != null) {

                $path = '/img/' . $aslisi->gambar;
                if (file_exists(public_path() . $path)) {
                    unlink(public_path() . $path);
                }
            }
            $gmbr = $request->thumbnail;
            $nama_file = str_replace(' ', '_', time() . "_" . $gmbr->getClientOriginalName());
            $tujuan_upload = 'img/';
            $gmbr->move($tujuan_upload, $nama_file);
        }

        $user = t_admin::where('id', $request->idid)->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password != false ?  Hash::make($request->password) : $aslisi->password,

        ]);


        if ($user) {
            # code...
            return 'success';
        }
    }
    public function profil()
    {
        return view('admin.user.profile');
    }
    public function jabatanfungsi()
    {
        $client = new Client();
        $url = "https://remun.unm.ac.id/api-for-status-jab-dosen";

        $headers = [
            'key' => 'remun-apps-87687sa8dkj68sydf87s8dfs7df',
            'app' => 'remun-apps'
        ];

        $resp = $client->request('GET', $url, [
            'headers' => $headers,
            'verify' => false
        ]);

        $responBody = json_decode($resp->getBody());
        try {
            foreach ($responBody->data as $val) {
                if ($val->id == 3 || $val->id == 4) {
                    statusJabDosen::updateOrCreate([
                        'id_sfd' => $val->id
                    ], [
                        'status' => $val->status,

                    ]);
                }
            }
            return "success";
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function jabatan()
    {
        $client = new Client();
        $url = "https://remun.unm.ac.id/api-for-jabatan-remun";

        $headers = [
            'key' => 'remun-apps-87687sa8dkj68sydf87s8dfs7df',
            'app' => 'remun-apps'
        ];

        $resp = $client->request('GET', $url, [
            'headers' => $headers,
            'verify' => false
        ]);

        $responBody = json_decode($resp->getBody());
        try {
            $datar = $this->pegawai();
            foreach ($responBody->data as $val) {
                if ($val->Peruntukan == "dosen") {
                    Jabatan::updateOrCreate([
                        'id_jab' => $val->Kode_Jabatan,

                    ], [
                        'jabatan' => $val->Nama_Jabatan,
                        'status_k' => $val->Peruntukan,
                        'status_r' => 'Tugas Tambahan'
                    ]);
                } else if (in_array($val->Kode_Jabatan, $datar)) {
                    Jabatan::updateOrCreate([
                        'id_jab' => $val->Kode_Jabatan,

                    ], [
                        'jabatan' => $val->Nama_Jabatan,
                        'status_k' => $val->Peruntukan,
                        'status_r' => 'Tendik Struktural'
                    ]);
                } else {
                    Jabatan::updateOrCreate([
                        'id_jab' => $val->Kode_Jabatan,

                    ], [
                        'jabatan' => $val->Nama_Jabatan,
                        'status_k' => $val->Peruntukan,
                        'status_r' => 'Tendik Biasa'
                    ]);
                }
            }
            return 'success';
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function unit()
    {

        $client = new Client();
        $url = "https://remun.unm.ac.id/api-for-unit";

        $headers = [
            'key' => 'remun-apps-87687sa8dkj68sydf87s8dfs7df',
            'app' => 'remun-apps'
        ];

        $resp = $client->request('GET', $url, [
            'headers' => $headers,
            'verify' => false
        ]);

        $responBody = json_decode($resp->getBody());
        try {
            foreach ($responBody->data as $val) {
                Unit::updateOrCreate([
                    'id_unit' => $val->Indeks_Unit_ID
                ], [
                    'unit' => $val->Nama_Unit,
                ]);
            }
            return "success";
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function index()
    {
        $tp = Pegawai::where('jenis_kepegawaian', 'pegawai')->get();
        $tp = $tp->count();
        return view('admin.dashboard', compact('tp'));
    }

    public function pegawai()
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents("https://simpeg.unm.ac.id/api-pegawai", false, stream_context_create($arrContextOptions));
        $arrp = [];
        $data = json_decode($response);

        foreach ($data as $val) {
            if ($val->statusJabFungsionalBKD == "Tendik Struktural") {
                $arrp[] = $val->jabatanRemun;
            }
        }
        return array_unique($arrp);
    }
    public function relasi()
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents("https://simpeg.unm.ac.id/api-pegawai", false, stream_context_create($arrContextOptions));
        $data = json_decode($response, false, 10);
        try {
            foreach ($data as $val) {

                if ($val->ket == 'Aktif') {
                    Peginfo::updateOrCreate([
                        'id_peg' => $val->id_pegawai,
                    ], [
                        'nama' => $val->nama,
                    ]);
                }
            }
            return "success";
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function ps()
    {
        set_time_limit(1200);
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents("https://simpeg.unm.ac.id/api-pegawai", false, stream_context_create($arrContextOptions));
        $data = json_decode($response, false, 10);
        try {
            foreach ($data as $val) {

                if ($val->ket == 'Aktif') {
                    Pegawai::updateOrCreate([
                        'id_peg' => $val->id_pegawai,
                        'nip' => $val->nip
                    ], [
                        'jenis_kepegawaian' => $val->jenis_kepegawaian,
                        'nama' => $val->nama,
                        'id_jenis_pegawai' => $val->jenis_pegawai,
                        'idUnitRemun' => $val->idUnitRemun,
                        'jabatanRemun' => $val->jabatanRemun,
                        'statusJabFungsionalBKD' => $val->statusJabFungsionalBKD,
                        'jabatan' => $val->jabatan,
                        'pangkat' => $val->pangkat,
                        'golongan' => $val->golongan,
                        'foto' => $val->foto,
                        'unit' => $val->unit,
                        'password' => Hash::make($val->password)

                    ]);
                }
            }
            return $data;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function ppss()
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents("https://simpeg.unm.ac.id/api-pegawai", false, stream_context_create($arrContextOptions));
        $data = json_decode($response, false, 10);
        return $data;
    }
}
