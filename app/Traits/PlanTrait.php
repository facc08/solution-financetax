<?php
namespace App\Traits;

use App\Document;
use App\Servicios\Plan;


trait PlanTrait
{

    public function CreatePlan ($request){

        $p                   = new Plan();
        $p->descripcion      = $request->descripcion;
        $p->costo            = $request->costo;
        $p->cantidad_meses   = $request->cantidad_meses;
        $p->service_id       = $request->service_id;
        $p->tipoplan_id      = $request->tipoplan_id;
        $p->slug             = $request->costo.$request->tipoplan_id.$request->subservice_id;
        $p->estado           = $request->estado;
        $p->save();

        if ($request->hasFile('documento')) {
            $archivo = $request->documento;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/documentos/' . $nombre;
            $archivo->storeAs('documentos',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $p->documento()->save($documento);
        }

        $response = array('mensaje' => "Registro Realizado Correctamente");
        return $response;
    }




    public function UpdatePlan($request){

        $p                   =  Plan::find($request->plan_id);
        $p->descripcion      = $request->descripcion;
        $p->costo            = $request->costo;
        $p->cantidad_meses   = $request->cantidad_meses;
        $p->service_id       = $request->service_id;
        $p->tipoplan_id      = $request->tipoplan_id;
        $p->estado           = $request->estado;
        $p->save();

        if ($request->hasFile('documento')) {
            if (isset($p->documento)) {
                $image_path = public_path() . $p->documento->archivo;
                unlink($image_path);
            }
            $archivo = $request->documento;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/documentos/' . $nombre;
            $archivo->storeAs('documentos',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $p->documento()->save($documento);
        }

        $response = array('mensaje' => "Registro Actualizado Correctamente");
        return $response;
    }

}
