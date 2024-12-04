<?php

namespace App\Http\Controllers\Sri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Servicios\Proyeccion;
use App\Servicios\Plancontable;
use App\Servicios\Tiposervicio;
use App\Servicios\Service;
use App\Servicios\Subservice;
use App\Servicios\Plan;
use App\Tienda\Shop;
use DateTime;

class SriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id, $tipoplan, $usuarioEmpresa)
    {
        $userEmpresa = UserEmpresa::where('id', $usuarioEmpresa)->first();
        $user_id = $userEmpresa->user_id;
        $userInfo = User::where('id', $user_id)->first();
        $ruc = $userEmpresa->ruc;
        $razonSocial = $userEmpresa->razon_social;
        $flagClave = true;
        $flagTipo = true;
        $flagPeriodo = true;
        $slug = "none";

        if($userEmpresa->clave_acceso == '')
            $flagClave = false;

        if($userEmpresa->periodo_declaracion_id == '' || $userEmpresa->periodo_declaracion_id == 0 || empty($userEmpresa->periodo_declaracion_id))
            $flagPeriodo = false;

        if($userInfo->tipo_contribuyente_id == '' || empty($userInfo->tipo_contribuyente_id))
            $flagTipo = false;

        return view('admin.ingreso_facturas.sri.index', compact('ruc', 'razonSocial', 'flagClave', 'flagPeriodo', 'flagTipo', 'slug'));
    }

    public function procesarComprobanteSRI(Request $request)
    {
        $archivo =  file_get_contents($request->file);
        $array = explode("\t", $archivo); 

        try {
            $arrayErrores = [];
            $arrayFacturas = [];
            $arrayNotasCredito = [];
            $arrayNotasDebito = [];
            $arrayRetenciones = [];
            $arrayLiquidaciones = [];
            $key = 0;
            $cont = 0;

            foreach($array as $item){
                $respOk = false;

                if(strlen($item) == 49 && is_numeric($item)){
                    $respuestaSRI = $this->autorizarComprobanteSRI($item);
                    if(!is_array($respuestaSRI)){
                        $respOk = true;
                    }else{
                        /*
                        $respuestaSRI = $this->autorizarComprobanteSRI($item);
                        if(!is_array($respuestaSRI)){
                            $respOk = true;
                        }else{
                        */
                            $error = [
                                'ClaveAcceso'   =>  $item,
                                'mensaje'       =>  'Sin Respuesta'
                            ];
                            array_push($arrayErrores,$error);
                        //}
                    }

                    if($respOk && $array[$cont] !== $array[$cont-1]){
                        //dd($respuestaSRI->RespuestaAutorizacionComprobante); 

                        //var_dump($respuestaSRI->RespuestaAutorizacionComprobante);
                        if($respuestaSRI->RespuestaAutorizacionComprobante->numeroComprobantes != 0){
                            //var_dump("**SI**");
                            $xmlRespuesta = $respuestaSRI->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante;
                            $xml = new \SimpleXMLElement($xmlRespuesta);
                            $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

                            if($tipoComprobante == 'FACTURA'){
                                $factura = $this->procesarFacturas($xml,$key);
                                array_push($arrayFacturas,$factura);
                                $key++;
                            }elseif($tipoComprobante == 'NOTA DE CRÉDITO'){
                                $nota_credito = $this->procesarNotaCredito($xml,$key);
                                array_push($arrayNotasCredito,$nota_credito);
                                $key++;
                            }elseif($tipoComprobante == 'NOTA DE DÉBITO'){
                                $nota_debito = $this->procesarNotaDebito($xml,$key);
                                array_push($arrayNotasDebito,$nota_debito);
                                $key++;
                            }elseif($tipoComprobante == 'LIQUIDACION DE COMPRA DE BIENES Y PRESTACIÓN DE SERVICIOS'){
                                $liquidacion = $this->procesarLiquidacion($xml,$key);
                                array_push($arrayLiquidaciones,$liquidacion);
                                $key++;
                            }elseif($tipoComprobante == 'COMPROBANTE DE RETENCIÓN'){
                                $retenciones = $this->procesarRetencion($xml,$key);
                                foreach($retenciones as $ret){
                                    array_push($arrayRetenciones,$ret);
                                    $key++;
                                }
                            }
                        }else{
                            $error = [
                                'claveAcceso'   =>  $item,
                                'mensaje'       =>  'El archivo no tiene autorizaciones relacionadas'
                            ];
                            array_push($arrayErrores,$error);
                        }
                    }
                }
                $cont++;
            }
            $respuestas = [
                'facturas'      =>  $arrayFacturas,
                'notas_credito' =>  $arrayNotasCredito,
                'notas_debito'  =>  $arrayNotasDebito,
                'retenciones'   =>  $arrayRetenciones,
                'liquidaciones' =>  $arrayLiquidaciones,
                'errores'       =>  $arrayErrores
            ];
            //echo("AAAAAAAAAAAAAAAAAAA");
            //dd($respuestas);
            return $respuestas;

        }catch(Exception $e){
            dd($e);
            return $e;
        }
    }

    public function procesarFacturas($xml,$key)
    {
        $tarifaDifCero = 0;
        $iva = 0;
        $tarifaCero = 0;
        $totalConImpuestos = $xml->infoFactura->totalConImpuestos->totalImpuesto;

        foreach($totalConImpuestos as $item){
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 2){
                $tarifaDifCero += (string)$item->baseImponible;
                $iva += (string)$item->valor;
            }
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 0){
                $tarifaCero += (string)$item->baseImponible;
            }
        }

        $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

        $factura = [
            'key'               =>  $key,
            'nroComprobante'    =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
            'ruc'               =>  (string) $xml->infoTributaria->ruc,
            'razonSocial'       =>  (string) $xml->infoTributaria->razonSocial,
            'tipoComprobante'   =>  $tipoComprobante,
            'fechaEmision'      =>  (string) $xml->infoFactura->fechaEmision,
            'claveAcceso'       =>  (string) $xml->infoTributaria->claveAcceso,
            'subTotal'          =>  (string) $xml->infoFactura->totalSinImpuestos,
            'descuento'         =>  (string) $xml->infoFactura->totalDescuento,
            'tarifaDifCero'     =>  $tarifaDifCero,
            'tarifaCero'        =>  $tarifaCero,
            'iva'               =>  $iva,
            'importeTotal'      =>  (string) $xml->infoFactura->importeTotal,
        ];

        return $factura;
    }

    public function procesarNotaCredito($xml,$key)
    {
        $tarifaDifCero = 0;
        $iva = 0;
        $tarifaCero = 0;
        $totalConImpuestos = $xml->infoNotaCredito->totalConImpuestos->totalImpuesto;

        foreach($totalConImpuestos as $item){
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 2){
                $tarifaDifCero += (string)$item->baseImponible;
                $iva += (string)$item->valor;
            }
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 0){
                $tarifaCero += (string)$item->baseImponible;
            }
        }

        $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

        $notaCredito = [
            'key'               =>  $key,
            'nroComprobante'    =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
            'ruc'               =>  (string) $xml->infoTributaria->ruc,
            'razonSocial'       =>  (string) $xml->infoTributaria->razonSocial,
            'tipoComprobante'   =>  $tipoComprobante,
            'fechaEmision'      =>  (string) $xml->infoNotaCredito->fechaEmision,
            'claveAcceso'       =>  (string) $xml->infoTributaria->claveAcceso,
            'subTotal'          =>  (string) $xml->infoNotaCredito->totalSinImpuestos,
            'tarifaDifCero'     =>  $tarifaDifCero,
            'tarifaCero'        =>  $tarifaCero,
            'iva'               =>  $iva,
            'importeTotal'      =>  (string) $xml->infoNotaCredito->valorModificacion,
        ];

        return $notaCredito;
    }

    public function procesarNotaDebito($xml,$key)
    {
        $tarifaDifCero = 0;
        $iva = 0;
        $tarifaCero = 0;
        $totalConImpuestos = $xml->infoNotaDebito->totalConImpuestos->totalImpuesto;

        foreach($totalConImpuestos as $item){
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 2){
                $tarifaDifCero += (string)$item->baseImponible;
                $iva += (string)$item->valor;
            }
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 0){
                $tarifaCero += (string)$item->baseImponible;
            }
        }

        $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

        $notaDebito = [
            'key'               =>  $key,
            'nroComprobante'    =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
            'ruc'               =>  (string) $xml->infoTributaria->ruc,
            'razonSocial'       =>  (string) $xml->infoTributaria->razonSocial,
            'tipoComprobante'   =>  $tipoComprobante,
            'fechaEmision'      =>  (string) $xml->infoNotaDebito->fechaEmision,
            'claveAcceso'       =>  (string) $xml->infoTributaria->claveAcceso,
            'subTotal'          =>  (string) $xml->infoNotaDebito->totalSinImpuestos,
            'tarifaDifCero'     =>  $tarifaDifCero,
            'tarifaCero'        =>  $tarifaCero,
            'iva'               =>  $iva,
            'importeTotal'      =>  (string) $xml->infoNotaDebito->valorModificacion,
        ];

        return $notaDebito;
    }

    public function procesarRetencion($xml,$key)
    {
        $compRetencion = [];
        $impuestos = $xml->impuestos->impuesto;

        foreach($impuestos as $item){
            $tipoImp = 'RENTA';
            if($item->porcentajeRetener == '30.00' || $item->porcentajeRetener == '70.00' || $item->porcentajeRetener == '100.00'){
                $tipoImp = 'IVA';
            }
            $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);
            $retencion = [
                'key'               =>  $key,
                'nroComprobante'    =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
                'ruc'               =>  (string) $xml->infoTributaria->ruc,
                'razonSocial'       =>  (string) $xml->infoTributaria->razonSocial,
                'tipoComprobante'   =>  (string) $tipoComprobante,
                'fechaEmision'      =>  (string) $xml->infoCompRetencion->fechaEmision,
                'claveAcceso'       =>  (string) $xml->infoTributaria->claveAcceso,
                'periodoFiscal'     =>  (string) $xml->infoCompRetencion->periodoFiscal,
                'codigo'            =>  (string) $item->codigo,
                'codigoRet'         =>  (string) $item->codigoRetencion,
                'tipoImp'           =>  (string) $tipoImp,
                'porcRet'           =>  (string) $item->porcentajeRetener,
                'baseImponible'     =>  (string) $item->baseImponible,
                'valorRet'          =>  (string) $item->valorRetenido,
            ];
            array_push($compRetencion,$retencion);
            $key++;
        }

        return $compRetencion;
    }

    public function procesarLiquidacion($xml,$key)
    {
        $tarifaDifCero = 0;
        $iva = 0;
        $tarifaCero = 0;
        $totalConImpuestos = $xml->infoLiquidacionCompra->totalConImpuestos->totalImpuesto;

        foreach($totalConImpuestos as $item){
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 2){
                $tarifaDifCero += (string)$item->baseImponible;
                $iva += (string)$item->valor;
            }
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 0){
                $tarifaCero += (string)$item->baseImponible;
            }
        }

        $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

        $factura = [
            'key'                           =>  $key,
            'nroComprobante'                =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
            'ruc'                           =>  (string) $xml->infoTributaria->ruc,
            'razonSocial'                   =>  (string) $xml->infoTributaria->razonSocial,
            'tipoComprobante'               =>  $tipoComprobante,
            'fechaEmision'                  =>  (string) $xml->infoLiquidacionCompra->fechaEmision,
            'claveAcceso'                   =>  (string) $xml->infoTributaria->claveAcceso,
            'subTotal'                      =>  (string) $xml->infoLiquidacionCompra->totalSinImpuestos,
            'descuento'                     =>  (string) $xml->infoLiquidacionCompra->totalDescuento,
            'tarifaDifCero'                 =>  $tarifaDifCero,
            'tarifaCero'                    =>  $tarifaCero,
            'iva'                           =>  $iva,
            'importeTotal'                  =>  (string) $xml->infoLiquidacionCompra->importeTotal,
            'totalComprobanteReembolso'     =>  (string) $xml->infoLiquidacionCompra->totalComprobantesReembolso,
            'totalBaseImponibleReembolso'   =>  (string) $xml->infoLiquidacionCompra->totalBaseImponibleReembolso,
            'totalImpuestoReembolso'        =>  (string) $xml->infoLiquidacionCompra->totalImpuestoReembolso,
        ];

        return $factura;
    }

    public function autorizarComprobanteSRI($clave)
    {
        $webAutoriza = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
        $parametrosAutoriza = array("claveAccesoComprobante" => $clave);
        try{
            $webServiceAutorizacion = new \SoapClient($webAutoriza);
            $result = $webServiceAutorizacion->autorizacionComprobante($parametrosAutoriza);
        }catch(Exception $e){
            //var_dump($e->getMessage());
            //$result =  $e->getMessage();
            $result =  [];
        }

        return $result;
    }

    public function devolverTipoComprobante($codDoc)
    {
        $respuesta = '';
        switch ($codDoc) {
            case '01':
                $respuesta = 'FACTURA';
                break;
            case '03':
                $respuesta = 'LIQUIDACION DE COMPRA DE BIENES Y PRESTACIÓN DE SERVICIOS';
                break;
            case '04':
                $respuesta = 'NOTA DE CRÉDITO';
                break;
            case '05':
                $respuesta = 'NOTA DE DÉBITO';
                break;
            case '06':
                $respuesta = 'GUIA DE REMISIÓN';
                break;
            case '07':
                $respuesta = 'COMPROBANTE DE RETENCIÓN';
                break;
        }
        return $respuesta;
    }

    public function comprobarComprobanteSRI($claveAcceso)
    {
        $servicio = "https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl"; //url del servicio
        $parametros = array(); //parametros de la llamada
        $parametros['claveAccesoComprobante'] = $claveAcceso;

        $client = new \nusoap_client($servicio);
        $error = $client->getError();
        $client->soap_defencoding = 'utf-8';
        $result = $client->call("autorizacionComprobante", $parametros, "http://ec.gob.sri.ws.autorizacion");
        $response = array();

        return $result;
    }

    public function guardarResgistrosAutomaticos(Request $request)
    {
        $facturas = json_decode($request->get('facturas'), true);
        $empresa = UserEmpresa::where('id', $request->get('usuarioEmpresa'))->first();
        $user_id = $empresa->user_id;

        /*
            key: arrayCells["key"],
                                fechaEmision: arrayCells["fechaEmision"],
                                tipo: arrayCells["tipo"],
                                categoria: arrayCells["categoria"],
                                tipoTransaccion: arrayCells["tipoTransaccion"],
                                tarifaDifCero: arrayCells["tarifaDifCero"],
                                tarifaCero: arrayCells["tarifaCero"],
                                iva: arrayCells["iva"],
                                total: arrayCells["total"],
        */

        $plan = Plan::where('tipoplan_id', $request->get('tipoPlan'))->where('service_id', $request->get('subservicio'))->first();

        $shop = Shop::where('tipoplan_id', $request->get('tipoPlan'))->where('service_id', $request->get('subservicio'))->where('plan_id', $plan->id)
                        ->where('user_id', $user_id)->first();

        $empresa = UserEmpresa::where('id', $request->get('usuarioEmpresa'))->first();

        foreach ($facturas as $key => $value) {
            $transaccion = new TransaccionDiaria();
            $transaccion->usuarioempresa_id = $request->get('usuarioEmpresa');
            $transaccion->usuarioplan_id = $shop->id;
            $transaccion->tipotransaccion_id = $value["tipoTransaccion"];
            //$transaccion->plancuenta_id = $request->get('cuenta');
            $transaccion->proyeccions_id = $value["categoria"];
            //$fecha = strtotime($value["fechaEmision"]);

            $date = DateTime::createFromFormat('d/m/Y', $value["fechaEmision"]);
            $formattedDate = $date->format('Y-m-d');

            $transaccion->fecha_registro = $formattedDate;//date('Y-m-d',$fecha);
            $transaccion->detalle = "FACTURA #".$value["tipoTransaccion"]." - ".$empresa->razon_social;
            $transaccion->tarifacero = $value["tarifaCero"];
            $transaccion->tarifadifcero = $value["tarifaDifCero"];
            $transaccion->iva = $value["iva"];
            $transaccion->importe = $value["total"];
            $transaccion->estado = "activo";//$request->get('estado');
            //$transaccion->archivo = $request->get('nombreFactura');

            /*$image =  $request->get('imagenBase64');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = $request->get('nombreFactura') . '.png';
            file_put_contents(public_path().'/documentos/'.$imageName, base64_decode($image));*/

            $result = $transaccion->save();
        }

        return response()->json($result, 201);
    }

    public function getInfoEmpresa(Request $request)
    {

        //$empresa = UserEmpresa::where('id', $request->get('usuarioEmpresa'))->first();
        return UserEmpresa::where('id', $request->get('usuarioEmpresa'))->first();

    }
}
