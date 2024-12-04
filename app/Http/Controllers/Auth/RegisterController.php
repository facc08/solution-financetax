<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\City;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register', ["ciudades" => City::orderBy('nombre', 'asc')->get()]);
    }
    

    protected function validator($data)
    {
        //$validator = Validator::make($data, [
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:App\User,email',//'required|unique:users,email|email',
            'password' => 'required|string|min:8|confirmed',
            'genero' => 'required',
            'ciudad' => 'required',
        ]);
        /*dd($validator->validated());
        if ($validator->fails()) {
            dd("--FAIL--");
        }*/
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // Se asigna el rol de Invitado ya que solo cuenta con el permiso de sus configuraciones y adquirir servicios
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'genero' => $data['genero'],
            'city_id' => $data['ciudad'],
            'password' => Hash::make($data['password']),
        ])->assignRole('invitado');

    }

    public function validaEmail($email){
        $emailLimpio = trim(str_replace('"@"',"@", $email));

        $usuario = User::where('email', $emailLimpio)->get();

        if($usuario->count())
            return true;
        else
            return false;

        //return "ok";
    }
}
