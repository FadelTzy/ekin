<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\t_periode;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToArray;

class Statuspeg
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check()) {
            # code...
            if ($request->user()->hasRole($role)) {
                if (!Session::has('period')) {
                    # code...
                    $check = t_periode::where('status_aktif', 1)->first();
                    Session::put('period', $check->id);
                    Session::put('tahon', $check->tahun);
                    Session::put('semester', $check->semester);
                }
                $data = t_periode::where('tahun', Session::get('tahon'))->get();
                View::share('period', $data);


                $tahund = t_periode::select('tahun')->orderBy('tahun', 'ASC')->distinct()->get();
                View::share('tahund', $tahund);

                return $next($request);
            }
            // if ($request->user()->statusJabFungsionalBKD == 'Tendik Struktural') {
            //     # code...
            // }
            return redirect()->to('/login')->with('warning', 'Akun Anda Tidak Memiliki Izin Untuk Mengakses Sistem EKINERJA');
        }
        return redirect()->to('/login')->with('warning', 'ccount is deactivated.');
    }
}
