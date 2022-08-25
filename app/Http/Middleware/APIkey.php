<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIkey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('y-api-key');
        $key = 'Remun-UNM---';

        if ($token != $key) {
            return response()->json(['message' => 'App Key Tidak Ditemukan'], 401);
        }

        return $next($request);
    }
}
