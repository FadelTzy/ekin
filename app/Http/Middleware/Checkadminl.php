<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Checkadminl
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
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.auth');
        }

        $admin = Auth::guard('admin')->user();

        if ($admin->level == $role) {
            return $next($request);
        }
        return redirect()->route('admin.auth')->with('error', 'Autentikasi Gagal');
    }
}
