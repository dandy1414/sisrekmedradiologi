<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventLogin
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
        if(Auth::check()){
            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                    break;
                case 'resepsionis':
                    return redirect()->route('resepsionis.pasien.index-pasien-umum');
                    break;
                case 'radiografer':
                    return redirect()->route('radiografer.pasien.index-pasien-umum');
                    break;
                case 'dokterPoli':
                    return redirect()->route('dokterPoli.pasien.index-pasien');
                    break;
                case 'dokterRadiologi':
                    return redirect()->route('dokterRadiologi.pasien.index-pemeriksaan');
                    break;
                case 'kasir':
                    return redirect()->route('kasir.index-tagihan');
                    break;
                default:
                    return redirect('/');
                break;
            }
        }
        return $next($request);
    }
}
