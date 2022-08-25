<?php

namespace App\Http\Controllers;

use App\Models\t_admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Adminauth extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            if ($user->level == '1') {
                return redirect()->intended('admin');
            } elseif ($user->level == '2') {
                return redirect()->intended('admin');
            }
        }
        return view('auth.admin.login');
    }
    public function login(Request $request)
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $kredensil = $request->only('username', 'password');
        if (Auth::guard('admin')->attempt($kredensil)) {

            $user = Auth::guard('admin')->user();
            if ($user->level == '1') {
                return redirect()->intended('admin');
            } elseif ($user->level == '2') {
                return redirect()->intended('admin');
            }
        }

        return redirect()->route('admin.auth')->with('error', 'Autentikassi Gagal');
    }
    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        return redirect()->route('admin.auth');
    }
    public function admin()
    {
        if (request()->ajax()) {
            return datatables()->of(t_admin::all())->addIndexColumn()->addColumn('aksi', function ($data) {
                $btn = '<div class="d-flex">';
                $btn .= "<a onclick='upd(" . $data . ")' class='pr-2' type='button'> <i class='mdi mdi-square-edit-outline'> </i> </a>";
                $btn .= '<a onclick="del(' . $data->id . ')"  type="button"> <i class="mdi mdi-delete"> </i> </a>';

                $btn .= '</div>';
                return $btn;
            })->addColumn('status', function ($data) {
                if ($data->level == '1') {
                    return 'Super Admim';
                } elseif ($data->level == '2') {
                    return 'Admin';
                }
            })->addColumn('gabung', function ($data) {
                return Carbon::parse($data->created_at)->translatedFormat('d F Y');
            })->rawColumns(['aksi', 'status'])->make(true);
        }
        return view('admin.user.index');
    }
    public function simpan(Request $request)
    {
        $request->validate(
            [
                'name'              =>      'required|string|max:20',
                'username'             =>      'required|string|unique:t_admins',
                'pass'          =>      'required|alpha_num|min:6',
                'repass'  =>      'required|same:pass',
            ]
        );

        $dataArray      =       array(
            "name"          =>          $request->name,
            "username"         =>         $request->username,
            "level"         => $request->adminrole == '1' ? '1' : '2',
            "password"      =>        bcrypt($request->pass)
        );

        $user           =       t_admin::create($dataArray);
        if (!is_null($user)) {
            return 'success';
        } else {
            return 'failed';
        }
    }
    public function edit(Request $request)
    {
        if (!is_null(request()->pass)) {
            $request->validate(
                [
                    'name'              =>      'required|string|max:20',
                    'username'             =>      'required|string|unique:t_admins',
                    'pass'          =>      'required|alpha_num|min:6',
                    'repass'  =>      'required|same:pass',
                ]
            );
            $dataArray      =       array(
                "name"          =>          $request->name,
                "username"         =>         $request->username,
                "level"         => $request->adminrole == '1' ? '1' : '2',
                "password"      =>        bcrypt($request->pass)
            );
            $user           =       t_admin::where('id', $request->id)->update($dataArray);
            if ($user == 1) {
                return 'success';
            } else {
                return 'failed';
            }
        } else {
            $request->validate(
                [
                    'name'              =>      'required|string|max:20',
                    'username'             =>      'required|string|unique:t_admins',
                ]
            );
            $dataArray      =       array(
                "name"          =>          $request->name,
                "username"         =>         $request->username,
                "level"         => $request->adminrole == '1' ? '1' : '2',

            );
            $user           =       t_admin::where('id', $request->id)->update($dataArray);
            if ($user == 1) {
                return 'success';
            } else {
                return 'failed';
            }
        }
    }
    public function hapus($id)
    {
        $res = t_admin::findOrFail($id);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
}
