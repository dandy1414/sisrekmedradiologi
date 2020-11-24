<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Terontetikasi
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
        if(Auth::user()->role == 'radiografer' || Auth::user()->role == 'resepsionis' || Auth::user()->role == 'dokterPoli' || Auth::user()->role == 'dokterRadiologi' || Auth::user()->role == 'kasir'){
            return $next($request);
        }
        return abort(403);
    }
}
