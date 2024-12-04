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
use PDF;

class RatiosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('cruds.reportes.ratios.ratiosIndex');
        /*
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

        return view('cruds.reportes.ratios.consultarRatios', compact('data', 'acciones', 'rutasNombre', 'EmpresasNombre', 'dataEmpresas'));
        */
    }

    public function consultar($shop){

        $user_id = Auth::id();
        $userInfo = User::where('id', $user_id)->first();
        $meses = array('Enero' => "01", 'Febrero' => "02", 'Marzo' => "03",
                        'Abril' => "04", 'Mayo' => "05", 'Junio' => "06",
                        'Julio' => "07", 'Agosto' => "08", 'Septiembre' => "09",
                        'Octubre' => "10", 'Noviembre' => "11", 'Diciembre' => "12");
        $shop_id = $shop;

        return view('cruds.reportes.indicadores.parametrosIndicadores', compact('meses', 'shop_id'));

    }

    public function detalle($shop, $anio, $mes){
        $shopData = Shop::find($shop);
        $userEmpresa = UserEmpresa::find($shopData->user_empresas_id);
        $dateObj   = DateTime::createFromFormat('!m', $mes);
        $nombreMes = $dateObj->format('F');
        /*
        $formulas = Formulas::where('shop_id', $shop)->get();

        $dataDetalle = TransaccionDiaria::join('tipotransaccion', 'tipotransaccion.id', '=', 'transacciondiaria.tipotransaccion_id')
                                    ->leftJoin('plancontables', 'plancontables.id', 'transacciondiaria.plancuenta_id')
                                    ->select('tipotransaccion.nombre',
                                            'transacciondiaria.plancuenta_id',
                                            'plancontables.cuenta as nombre_cuenta',
                                            'plancontables.codigo as codigo_cuenta',
                                            'transacciondiaria.detalle',
                                            'transacciondiaria.created_at')
                                    ->selectRaw('SUM(transacciondiaria.tarifacero) AS totalTarifacero,
                                                SUM(transacciondiaria.tarifadifcero) AS totalTarifadifcero,
                                                SUM(transacciondiaria.iva) AS totalIva,
                                                SUM(transacciondiaria.importe) AS totalImporte
                                                ')
                                    ->where('transacciondiaria.usuarioplan_id', $shop)
                                    ->whereRaw('YEAR(transacciondiaria.fecha_registro) ='.$anio)
                                    ->whereRaw('MONTH(transacciondiaria.fecha_registro) ='.$mes)
                                    ->where('transacciondiaria.estado','=','activo')
                                    ->groupBy('transacciondiaria.plancuenta_id')
                                    ->get();

        $formulario = [];

        $total = 0;
        foreach ($formulas as $keyFor => $valueFor) {
            $arrayCuentas = $this->obtenerCuentasFormula($valueFor->formula);
            foreach ($arrayCuentas as $key => $value) {
                $codigo = $value;
                if(strpos($value, "@") !== false){
                    $codigo = str_replace('@', '', $value);
                }

                foreach ($dataDetalle as $keyDetalle => $valueDetalle) {
                    $valorTotal = 0.0;

                    if("@".$valueDetalle->codigo_cuenta."@" == $value){
                        $valorTotal = ($valueDetalle->totalTarifacero +  $valueDetalle->totalTarifadifcero +  $valueDetalle->totalIva +  $valueDetalle->totalImporte);
                        break;
                    }else if(strpos($value, "#") !== false){
                        $valorTotal = str_replace('#', '', $value);
                        break;
                    }
                }

                $arrayCuentavalor[$valueFor->formula][$value] = sprintf("%.3f", $valorTotal);

            }

        }

        foreach ($formulas as $keyFor => $valueFor) {

            $pttn='+-/*()';
            $pttn=sprintf( '@([%s])@', preg_quote( $pttn ) );
            $formulaDividida=preg_split( $pttn, preg_replace( '@\s@', '', $valueFor->formula ), -1, PREG_SPLIT_DELIM_CAPTURE );
            $formulaValores = '';
            foreach ($formulaDividida as $key => $value) {
                $stringFormula = $value;
                if(strpos($stringFormula, "(") !== false){
                    $stringFormula = str_replace('(', '', $stringFormula);
                }

                if(strpos($stringFormula, ")") !== false){
                    $stringFormula = str_replace(')', '', $stringFormula);
                }

                if($this->validaKey($arrayCuentavalor, $value)) {
                    $stringFormula = $arrayCuentavalor[$valueFor->formula][$value];
                }

                $formulaValores .= $stringFormula;
            }

            if(strpos($formulaValores, "#") !== false){
                $formulaValores = str_replace('#', '', $formulaValores);
            }

            try {
                $resultado = @eval('return '.$formulaValores.';');
            } catch(DivisionByZeroError $e){
                $resultado = 0;
            } catch(ErrorException $e) {
                $resultado = 0;
            }

            $valueFor->formulaValor = $resultado;

            $valueFor->formulaLimpia = str_replace('@', '', str_replace('#', '', $valueFor->formula));
        }
        */

        return view('cruds.reportes.ratios.detalleIndicadores', compact('anio', 'nombreMes', 'mes','userEmpresa', 'shop'));
    }

    public function obtenerCuentasFormula($formula){
        $pttn='+-/*';
        $pttn=sprintf( '@([%s])@', preg_quote( $pttn ) );
        $formula = str_replace(')', '', str_replace('(', '', $formula));
        $arrayPartes=preg_split( $pttn, preg_replace( '@\s@', '', $formula ), -1, PREG_SPLIT_DELIM_CAPTURE );

        foreach ($arrayPartes as $key => $value) {
            if(!is_numeric($value) && strpos($value, "#") === false && strpos($value, "@") === false){
                unset($arrayPartes[$key]);
            }
        }

        return $arrayPartes;
    }

    public function validaKey($array, $keySearch)
    {
        foreach ($array as $key => $item) {
            if ($key == $keySearch) {
                return true;
            } elseif (is_array($item) && $this->validaKey($item, $keySearch)) {
                return true;
            }
        }

        return false;
    }

    public function ratios($shop){

        return view('cruds.reportes.ratios.principal', compact('shop'));
    }

    public function generarPDF($shop, $variables, $formulas){

        $jsonVariables = json_decode($variables);
        $jsonFormulas = json_decode($formulas);

        $shopData = Shop::find($shop);
        $userEmpresa = UserEmpresa::find($shopData->user_empresas_id);
        $user = User::find(Auth::user()->id);

        //############ Permitir ver imagenes si falla ################################
        $contxt = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);

        $pdf = \PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($contxt);
        //#################################################################################

        $pdf->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf->loadView('cruds.reportes.pdfRatios', [
            'titulo' => 'Ratios Financieros',
            'footer' => 'FinanceTax Solutions '.date("Y"),
            'variables' => $jsonVariables,
            'formulas' => $jsonFormulas,
            'userEmpresa' => $userEmpresa,
            'nombreUsuario' => $user->name,
            'fechaGenerado' => Carbon::now(),
        ]);

        return $pdf->download('RatiosFinancieros_'.$userEmpresa->razon_social.'.pdf');
    }
}
