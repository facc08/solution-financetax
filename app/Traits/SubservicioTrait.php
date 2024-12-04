<?php
namespace App\Traits;

use App\Document;
use App\Servicios\Subservice;



trait SubservicioTrait
{


    public function CreateSubservicio($request){

      

     $s                  = new Subservice();
     $s->nombre          = $request->nombre;
     $s->service_id      = $request->service_id;
     $s->descripcion     = $request->descripcion;
     $s->slug            = strtolower(str_replace(" ","-",$request->nombre));
     $s->estado          = $request->estado;
     $s->save();

        if ($request->hasFile('documento')) {
            $archivo = $request->documento;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/documentos/' . $nombre;
            $archivo->storeAs('documentos',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $s->documento()->save($documento);
        }
  
        $response = array('mensaje' => "Registro Realizado Correctamente");
        return $response;

    }


    public function UpdateSubservicio($request){

        $s                  = Subservice::find($request->subservice_id);
        $s->nombre          = $request->nombre;
        $s->service_id      = $request->service_id;
        $s->descripcion     = $request->descripcion;
        $s->estado          = $request->estado;
        $s->save();

        if ($request->hasFile('documento')) {
            if (isset($s->documento)) {
                $image_path = public_path() . $s->documento->archivo;
                unlink($image_path);
            }
            $archivo = $request->documento;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/documentos/' . $nombre;
            $archivo->storeAs('documentos',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $s->documento()->save($documento);
        }

        $response = array('mensaje' => "Registro Actualizado Correctamente");
        return $response;



    }


}