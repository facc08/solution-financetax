<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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

   

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //validar el estado del Usuario activo o inactivo
    public function ValidateState($user){
        $data = User::selectRaw('timestapdiff(DAY, activated_at, curdate()) as dato')->where('id', $user->id)->first();

        if ($data-> dato >= 12) {
            $user->estado ='inactivo';
            $user->save();
        }

    }

    public function authenticated($request, $user){

        if ($user->estado =='inactivo') {
            Auth::guard()->logout();
          $request->session()->invalidate();
          return redirect('/login')->withInput()->with('message', 'Tu cuenta esta desactivada, por favor comunicate con el administrador.');
        }

        $user->access_at = Carbon::now();
        $user->save();


        return redirect()->route('home');
    }



}
