<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use SoapClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\TipoTransaccion;
use App\TransaccionDiaria;
use App\UserEmpresa;
use App\Role;
use App\UserRole;
use App\User;
use App\Accion;
use App\Formulas;
use App\Servicios\ServicioAccion;
use App\Servicios\Proyeccion;
use App\Servicios\Plancontable;
use App\Servicios\Tiposervicio;
use App\Servicios\Service;
use App\Servicios\Subservice;
use App\Servicios\Plan;
use App\Tienda\Shop;
use Datetime;
use Carbon\Carbon;
use SimpleXMLElement;
use Spatie\Permission\Models\Permission;

class FormulasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $rutas = [];
        $acciones = [];
        $nombres = [];
        $dataEmpresas = [];
        $usuariosEspecialista = [];
        $campoQuery = "user_id";

        if(Auth::user()->hasRole('contador')){
            $campoQuery = "especialista_id";
        }

        $data = Shop::where('shops.'.$campoQuery, Auth::user()->id)
        ->join('users','shops.especialista_id', '=','users.id')
        ->join('services','shops.service_id', '=','services.id')
        ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
        ->where('shops.estado','!=','pendiente')
        ->select('shops.*','services.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                'services.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan')
        ->orderBy('shops.id', 'asc')
        ->paginate(25);

        $rutasNombre    = Accion::pluck('descripcion','ruta');

        foreach ($data as $key => $value) {
            $servicioAccion = ServicioAccion::where('plan_id', $value->plan_id)
                            ->join('acciones','servicio_accion.accion_id', '=','acciones.id')
                            ->select('servicio_accion.*','acciones.ruta as ruta', 'acciones.descripcion as nombreRuta')->get();
            if(!$servicioAccion->isEmpty()){
                foreach ($servicioAccion as $keyserv => $valueserv) {
                    array_push($rutas, $valueserv->ruta);
                }
                $acciones[$value->id] = $rutas;
                $rutas = [];
            }

            if(Auth::user()->hasRole('contador')){
                array_push($usuariosEspecialista, $value->user_id);
            }
        }

        if(Auth::user()->hasRole('contador')){
            $EmpresasNombre = UserEmpresa::whereIn('user_id', $usuariosEspecialista)->pluck('razon_social', 'id');
            $EmpresasUsuarios = UserEmpresa::whereIn('user_id', $usuariosEspecialista)->pluck('user_id', 'id');
        }else{
            $EmpresasNombre = UserEmpresa::where('user_id', Auth::user()->id)->pluck('razon_social', 'id');
        }

        $date1 = new DateTime(Carbon::now());

        foreach ($EmpresasNombre as $keyEn => $valueEn) {

            if(Auth::user()->hasRole('contador'))
                $userId = $EmpresasUsuarios[$keyEn];
            else
                $userId = Auth::user()->id;

            $dataEmpresas[$valueEn] = Shop::where('shops.user_id', $userId)
                    ->join('users','shops.especialista_id', '=','users.id')
                    ->join('services','shops.service_id', '=','services.id')
                    ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
                    ->where('shops.estado','!=','pendiente')
                    ->where('user_empresas_id', $keyEn)
                    ->select('shops.*','services.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                            'services.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan', 'shops.user_empresas_id as userEmpresa',
                            'shops.id as shop_id')
                    ->orderBy('shops.id', 'asc')
                    ->paginate(25);

            foreach ($dataEmpresas[$valueEn] as $key => $value) {
                $date2 = new DateTime($dataEmpresas[$valueEn][$key]->fecha_caducidad);
                $diff = $date2->diff($date1)->format("%a");
                if($date1 > $date2)
                    $dataEmpresas[$valueEn][$key]->diasRestantes = (-1 * intval($diff));
                else
                    $dataEmpresas[$valueEn][$key]->diasRestantes = intval($diff);
            }
        }

        return view('cruds.mantenimientos.formulas.index', compact('data', 'acciones', 'rutasNombre', 'EmpresasNombre', 'dataEmpresas'));
    }

    public function detalle($shop){

        $user_id = Auth::id();
        $userInfo = User::where('id', $user_id)->first();
        $shop_id = $shop;

        return view('cruds.mantenimientos.formulas.detalle', compact('shop_id'));

    }

}
