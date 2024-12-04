<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Tienda\Shop;
use App\UserEmpresa;
use App\Servicios\Service;
use Carbon\Carbon;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $usuario = User::where('id', Auth::id())->first();
        $clienteFlag = false;
        $contratados = [];

        if($usuario->hasRole('contable') || $usuario->hasRole('financiero') || $usuario->hasRole('marketing') || $usuario->hasRole('legal')){

            $panel1 = Shop::join('users','shops.user_id','=','users.id')
            ->join('services','shops.service_id','=','services.id')
            //->join('services','services.service_id','=','services.id')
            ->join('tiposervicios','services.tiposervicio_id','=','tiposervicios.id')
            ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
            ->where('tiposervicios.role_id', $usuario->roles[0]->id)
            ->where('shops.estado', 'pendiente')
            ->count();

            $panel1Text = "Planes pendientes";
            $panel1Url = "/tienda/admin-planes";

            $panel2 = Shop::where('especialista_id', $usuario->id)
            ->join('users','shops.user_id','=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
            ->select('shops.*','services.nombre as sub','tipoplans.nombre as tipoplan','users.name as cliente')
            ->count();

            $panel2Text = "Planes asignados";
            $panel2Url = "/tienda/mi-administracion-plan";

        }else if($usuario->hasRole('invitado') || ($usuario->hasRole('cliente') && !$usuario->hasRole('super-admin'))){

            $panel1 = Shop::where('user_id', Auth::id())->get()->count();
            $panel1Text = "Planes Contratados";
            $panel1Url = "/tienda/lista-compra";

            $panel2 = UserEmpresa::where('user_id', Auth::id())->get()->count();
            $panel2Text = "Empresas Configuradas";
            $panel2Url = "/admin/mis-empresas/none";

            $contratados = Shop::join('services','shops.service_id','=','services.id')
            ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
            ->select('shops.*','services.nombre as servicio','tipoplans.nombre as tipoplan')
            ->where('shops.user_id', Auth::id())->where('shops.estado', "aprobada")->get();

            $date1 = new DateTime(Carbon::now());

            foreach ($contratados as $key => $value) {
                $date2 = new DateTime($contratados[$key]->fecha_caducidad);
                $diff = $date2->diff($date1)->format("%a");
                if($date1 > $date2)
                    $contratados[$key]->diasRestantes = (-1 * intval($diff));
                else
                    $contratados[$key]->diasRestantes = intval($diff);
            }

            $clienteFlag = true;
        }else if($usuario->hasRole('super-admin') || $usuario->hasRole('admin')){
            $panel1 = User::where('estado', 'activo')->count();
            $panel1Text = "Usuarios Activos";
            $panel1Url = "/admin/lista-usuarios";

            $panel2 = Service::where('estado', 'activo')->count();
            $panel2Text = "Servicios Configurados";
            $panel2Url = "/servicios/servicios";

        }

        return view('home',  compact('usuario', 'panel1', 'panel1Text', 'panel1Url', 'panel2', 'panel2Text', 'panel2Url', 'clienteFlag', 'contratados'));
    }


    //vistas del landing-page TAX Solution Finance

  

}
