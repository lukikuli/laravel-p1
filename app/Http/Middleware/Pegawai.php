<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Pegawai
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik'))
            return $next($request);
        elseif (Auth::check() && Auth::user()->role == 'manager')
            return redirect('/dashboard');
    }
}
