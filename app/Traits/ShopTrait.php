<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Tienda\Shop;
use App\UserEmpresa;
use App\Interaccion;
use App\DocumentosInteraccion;
use App\Role;
use App\UserRole;
use App\Servicios\Plancontable;
use App\Servicios\Service;
use App\Servicios\Subservice;
use App\Servicios\Tiposervicio;
use App\Tienda\DetallePagoPP;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Carbon\Carbon;

trait ShopTrait
{


    public function CreateData($request){

        $user_id = Auth::id();
        $empresa_id = $request->empresa;

        if($request->empresa == 0){
            $userEmpresa = UserEmpresa::where('user_id',$user_id)->first();
            $empresa_id = $userEmpresa->id;
        }

        $shop                    = new Shop();
        $shop->user_id           = $user_id;
        $shop->service_id        = $request->service_id;
        $shop->tipoplan_id       = $request->tipoplan_id;
        $shop->plan_id           = $request->plan_id;
        $shop->costo             = $request->costo;
        $shop->estado            = $request->estado;
        $shop->user_empresas_id  = $empresa_id;
        $shop->save();

        $subservicio = Service::find($request->service_id);

        $tipoServicio = Tiposervicio::find($subservicio->tiposervicio_id);
        $role = Role::where('name', $tipoServicio->nombre)->first();
        $roleUsuario = UserRole::where('role_id', $role->id)->first();

        if($request->tipoPago == "B"){
            $detallePP = DetallePagoPP::where('transactionId', $request->transactionId)->where('clientTransactionId', $request->clientTransactionId)->first()->id;

            $detalle = DetallePagoPP::find($detallePP);
            $detalle->shop_id = $shop->id;
            $detalle->save();

        }else if($request->tipoPago == "T"){

            if($request->comprobante){
                $message                       = new Interaccion;
                $message->especialista_id      = $roleUsuario->model_id;
                $message->cliente_id           = $user_id;
                $message->tipo                 = "C";
                $message->fecha                = Carbon::now();
                $message->detalle              = "Comprobante de pago";
                $message->observacion          = "Comprobante de pago adjunto";
                $message->shop_id              = $shop->id;
                $message->save();

                $name[] =  $request->comprobante->getClientOriginalName();
                $archivo = Str::slug($request->comprobante->getClientOriginalName()) . '.' . $request->comprobante->getClientOriginalExtension() ;

                if (Storage::putFileAs('documentos_interaccion', $request->comprobante, $archivo)) {
                    DocumentosInteraccion::create([
                        'interaccion_id'            => $message->id,
                        'documento_interaccion'     => $name[0],
                        'url_archivo'               => $archivo,
                        'user_id'                   => Auth::user()->id,
                    ]);
                }
            }
        }

        $response = array('mensaje' => "Compra en Estado Revisión");
        return $response;

    }



}