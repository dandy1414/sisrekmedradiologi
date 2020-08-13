<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo(){
        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                return route('admin.dashboard');
                break;
            case 'resepsionis':
                return route('resepsionis.pasien.index-pasien-umum');
                break;
            case 'radiografer':
                return route('radiografer.pasien.index-pemeriksaan');
                break;
            case 'dokterPoli':
                return route('dokterPoli.pasien.index-pasien');
                break;
            case 'dokterRadiologi':
                return route('dokterRadiologi.pasien.index-pemeriksaan');
                break;
            case 'kasir':
                return route('kasir.index-tagihan');
                break;
            default:
            return '/';
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
