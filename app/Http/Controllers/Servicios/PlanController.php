<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Servicios\Plan;
use App\Servicios\Subservice;
use App\Servicios\Service;
use App\Servicios\Tipoplan;
use App\Servicios\ServicioAccion;
use App\Traits\PlanTrait;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use PlanTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }



    // crud de redicreccion de ruta del mantenimiento de planes
    public function Planes(){
        return view('cruds.Servicios.TipoPlanes.Planes');
    }

    //crud de creacion de plan y edicion
    public function Plan(Request $request){

        $servicios = Service::where('estado', 'activo')->get();
        $tipoplan  = Tipoplan::where('estado', 'activo')->get();

        if ($request->has('plans')) {
            $plans = Plan::with(['servicio','servicio.nombre'],['tipoplan','tipoplan.nombre'])->findOrFail($request->get('plans'));

            return view('cruds.Servicios.TipoPlanes.createplan', compact('servicios', 'tipoplan','plans'));
        }else{
            return view('cruds.Servicios.TipoPlanes.createplan', compact('servicios', 'tipoplan'));

        }





    }

    public function Store(PlanRequest $request){

        $result = $request->edit == 'si' ? $this->UpdatePlan($request) : $this->CreatePlan($request);
        return response()->json($result, 201);
    }

    public function AccionesPlan(){
        return view('cruds.Servicios.TipoPlanes.AccionesPlan');
        /*return ServicioAccion::join('plans', 'servicio_accion.plan_id', '=', 'plans.id')
            ->join('acciones', 'servicio_accion.accion_id', '=', 'acciones.id')
            ->select('servicio_accion.*', 'plans.descripcion as nombre_plan', 'acciones.descripcion as nombre_accion')
            ->get();*/
    }


}
