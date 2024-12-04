<?php

namespace App\Http\Controllers\Servicios;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubservicioRequest;
use App\Servicios\Service;
use App\Servicios\Subservice;
use App\Servicios\Tiposervicio;
use App\Traits\SubservicioTrait;
use Illuminate\Http\Request;

class SubserviceController extends Controller
{
    use SubservicioTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index (){
        return view('cruds.Servicios.Servicios.subserviceindex');
    }
   
    public function Sub_service(Request $request){

        $servicios = Service::join('tiposervicios', 'services.tiposervicio_id', '=', 'tiposervicios.id')
        ->where('services.estado', 'activo')
        ->select('services.*', 'tiposervicios.id as tipoServicio')
        ->get();

        $tipoServicios = Tiposervicio::where('estado', 'activo')->get();

        /*
        $servicios = [];
        foreach ($tipoServicios as $keyTipo => $valueTipo) {
            $serviciosLista = [];
            foreach ($serviciosData as $key => $value) {
                if( $valueTipo->id == $value->tiposervicio_id){
                    array_push($serviciosLista, $value);
                }
            }
            $servicios[$valueTipo->nombre] = $serviciosLista;
        }
        */

        if ($request->has('subservices')) {
            //$subservices = Subservice::with(['servicio','servicio.nombre'])->findOrFail($request->get('subservices'));
            $subservices = Subservice::join('services', 'subservices.service_id', '=', 'services.id')
                ->join('tiposervicios', 'services.tiposervicio_id', '=', 'tiposervicios.id')
                ->where('subservices.id', $request->get('subservices'))
                ->select('subservices.*', 'tiposervicios.id as tiposervicio_id')
                ->first();

            return view('cruds.Servicios.Servicios.subservice', compact('servicios', 'subservices', 'tipoServicios'));
        } else{
            return view('cruds.Servicios.Servicios.subservice', compact('servicios', 'tipoServicios'));
        }
        
    }


    public function store(SubservicioRequest $request){

        $result = $request->edit == 'si' ? $this->UpdateSubservicio($request) : $this->CreateSubservicio($request);
        return response()->json($result, 201);

    }
}
