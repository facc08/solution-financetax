<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\User;
use Illuminate\Support\Facades\Hash;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }else{
            if($request->email == "")
            {}else{
                $usuario = User::where('email', $request->email)->first();

                if($usuario !== null){
                    if(!Hash::check($request->password, $usuario->password))
                        return redirect('/login')->withInput()->with('message', 'Contraseña incorrecta.');
                }
            }
        }

        return $next($request);
    }
}
