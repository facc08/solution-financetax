<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Servicios\Service;
use App\Servicios\Tiposervicio;
use App\Servicios\Plancontable;
use App\Tienda\Shop;
use App\UserEmpresa;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;
use Excel;
use App\Exports\PlanContableExport;
use Auth;

class ServicioController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function TipoPlanes(){
        return view('cruds.Servicios.TipoPlanes.index');
    }
  
        // redireccion de servicios vista
    public function Servicio(){
        return view('cruds.Servicios.Servicios.servicio');
    }
        // redireccion de tipo de servicios vista
    public function TipoServicio(){
        return view('cruds.Servicios.Servicios.tiposervicio');
    }
  

  //redireccion a la vista de crear servicio y edicion 
    public function CreateServicio (Request $request){
        $tiposervicios = Tiposervicio::where('estado', 'activo')->get();
              
        if ($request->has('services')) {
            $services = Service::with(['tipo','tipo.nombre'])->findOrFail($request->get('services')); 
            return view('cruds.Servicios.Servicios.createservicio', compact('tiposervicios','services'));
        } else{
            return view('cruds.Servicios.Servicios.createservicio', compact('tiposervicios'));
        }     
    }

    //ruta de almacenamiento del servicio modificado
  
    public function Store(ServiceRequest $request){

    
         $result = $request->edit == 'si' ? $this->Update($request) : $this->Create($request);
          //return $result;
         return response()->json($result, 201);

    }

    public function Tipocuenta(){

        return view('cruds.mantenimientos.tipocuenta.index');
    }

    
    public function Plancontable(){
        $user_id = Auth::id();

        if(Auth::user()->hasRole('contador')){
            $empresas = Shop::where('shops.especialista_id', $user_id)
            ->where('shops.estado', 'aprobada')
            ->join('users','shops.especialista_id', '=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('user_empresas','shops.user_empresas_id', '=','user_empresas.id')
            ->where('shops.estado','!=','pendiente')
            ->where('shops.service_id','=', 10)
            ->select('shops.*','services.nombre as sub','users.name as usuario', 'services.id as id_subservice', 'user_empresas.razon_social as nombreEmpresa', 'user_empresas.id as idEmpresa')
            ->get();
        }else{
            $empresas = Shop::where('shops.user_id', $user_id)
            ->where('shops.estado', 'aprobada')
            ->join('users','shops.especialista_id', '=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('user_empresas','shops.user_empresas_id', '=','user_empresas.id')
            ->where('shops.estado','!=','pendiente')
            ->where('shops.service_id','=', 10)
            ->select('shops.*','services.nombre as sub','users.name as usuario', 'services.id as id_subservice', 'user_empresas.razon_social as nombreEmpresa', 'user_empresas.id as idEmpresa')
            ->get();
        }

        return view('cruds.mantenimientos.plancontable.index', compact('empresas'));
    }

    public function ShowPlancontable($idEmpresa){

        return view('cruds.mantenimientos.plancontable.show', compact('idEmpresa'));
    }

    public function Impuestosri(){

        return view('cruds.mantenimientos.ImpuestosSRI.index');
    }

    public function ProyeccionGasto(){

        $user_id = Auth::id();

        if(Auth::user()->hasRole('contador')){
            $empresas = Shop::where('shops.especialista_id', $user_id)
            ->where('shops.estado', 'aprobada')
            ->join('users','shops.especialista_id', '=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('user_empresas','shops.user_empresas_id', '=','user_empresas.id')
            ->where('shops.estado','!=','pendiente')
            ->where('shops.service_id','=', 10)
            ->select('shops.*','services.nombre as sub','users.name as usuario', 'services.id as id_subservice', 'user_empresas.razon_social as nombreEmpresa', 'user_empresas.id as idEmpresa')
            ->get();
        }else{
            $empresas = Shop::where('shops.user_id', $user_id)
            ->where('shops.estado', 'aprobada')
            ->join('users','shops.especialista_id', '=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('user_empresas','shops.user_empresas_id', '=','user_empresas.id')
            ->where('shops.estado','!=','pendiente')
            ->where('shops.service_id','=', 10)
            ->select('shops.*','services.nombre as sub','users.name as usuario', 'services.id as id_subservice', 'user_empresas.razon_social as nombreEmpresa', 'user_empresas.id as idEmpresa')
            ->get();
        }

        return view('cruds.mantenimientos.proyecciongastos.show');
        //return view('cruds.mantenimientos.proyecciongastos.index', compact('empresas'));
        //return view('cruds.mantenimientos.proyecciongastos.index');
    }

    public function ShowProyeccionGasto($idEmpresa){

        return view('cruds.mantenimientos.proyecciongastos.show', compact('idEmpresa'));
    }

    public function consultaCodigoCuenta($id){
        $cuentaPadre = Plancontable::find($id);

        $cuentasHijos = Plancontable::where("cuenta_padre", $cuentaPadre->codigo)->where("user_empresa_id", $cuentaPadre->user_empresa_id)->get();

        if($cuentasHijos->count() > 0){
            if($cuentasHijos->count() < 10){
                $nuevoCodigo = sprintf("%02d", ($cuentasHijos->count() + 1));
            }else if($cuentasHijos->count() > 9){
                $nuevoCodigo = $cuentasHijos->count() + 1;
            }
        }else{
            $nuevoCodigo = 01;
        }

        $cuentaCodigo = $cuentaPadre->codigo.$nuevoCodigo;
        return $cuentaCodigo;
    }

    public function exportarPlanContable($id){
        $userEmpresa = UserEmpresa::find($id);

        $name = 'plan_contable_'.str_replace(" ", "_", $userEmpresa->razon_social);

        return (new PlanContableExport($id))->download($name.'.xlsx');
    }

}
