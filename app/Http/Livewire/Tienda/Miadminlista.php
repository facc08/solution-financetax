<?php

namespace App\Http\Livewire\Tienda;

use App\Servicios\Service;
use App\Servicios\Tipoplan;
use App\Tienda\Shop;
use App\User;
use App\ServicioPermisos;
use App\Formulas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Servicios\Plancontable;
use App\Servicios\Plan;
use Carbon\Carbon;

class Miadminlista extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    public $perPage         = 10;
    public $search          = '';
    public $orderBy         = 'shops.id';
    public $orderAsc        = false;
    public $uid;
    public $ShowMode        = false;

    public $clientes  =[];
    public $tipoplans  =[];
    public $services  =[];

    public $shop_id, $costo, $user_id, $tipoplan_id, $subservice_id ;


    //COMPONENTE PARA LA ADMINISTRACION DE PLANES ACEPTADOS POR EL ESPECIALISTA
    public function mount(){
        $this->uid = Auth::user()->id;
     }

    public function render()
    {
        $this->clientes = User::get(['id', 'name']);
        $this->services = Service::get(['id', 'nombre']);
        $this->tipoplans = Tipoplan::get(['id', 'nombre']);

        if(Auth::user()->hasRole('super-admin')){

            $data = Shop::join('users','shops.user_id','=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
            ->where(function($query){
                $query->where('services.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('users.name', 'like', '%' . $this->search . '%');
            })

            ->select('shops.*','services.nombre as serv','tipoplans.nombre as tipoplan','users.name as cliente')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);


        }else{

            $data = Shop::where('especialista_id', $this->uid)
            ->join('users','shops.user_id','=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
            ->where(function($query){
                $query->where('services.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('users.name', 'like', '%' . $this->search . '%');
            })

            ->select('shops.*','services.nombre as serv','tipoplans.nombre as tipoplan','users.name as cliente')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        }


        return view('livewire.tienda.miadminlista',compact('data'));
    }

    public function sortBy($field)
    {
        if ($this->orderBy === $field) {
            $this->orderAsc = !$this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $field;
    }


    public function estadochange($id)
    {
        $estado = Shop::find($id);
        $user = User::find($estado->user_id);
        $permisos = ServicioPermisos::where('plan_id', $estado->plan_id)->get();
        $plan = Plan::find($estado->plan_id);
        $now = Carbon::now()->toDateTimeString();
        $fecha_vigencia = date('Y-m-d', strtotime("+".$plan->cantidad_meses." months", strtotime($now)));

        $service = Service::find($estado->service_id);

        if($user->hasRole('invitado')){
            //if($estado->service_id == 10){
            if($service->tiposervicio_id !== 1){
                $user->assignRole('cliente');
            }else{
                $user->assignRole('cliente-contable');
            }
        }

        foreach ($permisos as $key => $value) {
            //$orders = DB::table('permissions')->where('name', $estado->plan_id) $value
            $user->givePermissionTo($value->permission_id);
        }

        $estado->estado = $estado->estado == 'aprobada' ? 'en proceso' : 'aprobada';
        $estado->fecha_caducidad = $estado->estado == 'aprobada' ? $fecha_vigencia : null;//$fecha_vigencia;
        $estado->save();


        //$subservicio = Service::find($estado->service_id);

        /* Generación plan genérico promedio para el cliente */
        if($service->tiposervicio_id == 1){//if($estado->service_id == 10){
            Plancontable::insert([
                /*
                ['cuenta'=>'ACTIVO', 'codigo'=>'1', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>6, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'ACTIVO CORRIENTE', 'codigo'=>'101', 'cuenta_padre'=>'1', 'nivel'=>'2',  'proyeccions_id'=>7, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'EFECTIVO Y EQUIVALENTES AL EFECTIVO', 'codigo'=>'10101', 'cuenta_padre'=>'101', 'nivel'=>'3',  'proyeccions_id'=>8, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PASIVO', 'codigo'=>'2', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>9, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PASIVO CORRIENTE', 'codigo'=>'201', 'cuenta_padre'=>'2', 'nivel'=>'2',  'proyeccions_id'=>10, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PASIVOS FINANCIEROS A VALOR RAZONABLE CON CAMBIOS EN RESULTADOS ', 'codigo'=>'20101', 'cuenta_padre'=>'201', 'nivel'=>'3',  'proyeccions_id'=>11, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PATRIMONIO NETO', 'codigo'=>'3', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>12, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'CAPITAL', 'codigo'=>'301', 'cuenta_padre'=>'3', 'nivel'=>'2',  'proyeccions_id'=>13, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INGRESOS', 'codigo'=>'4', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>14, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INGRESOS DE ACTIVIDADES ORDINARIAS', 'codigo'=>'401', 'cuenta_padre'=>'4', 'nivel'=>'2',  'proyeccions_id'=>6, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'VENTA DE BIENES', 'codigo'=>'40101', 'cuenta_padre'=>'401', 'nivel'=>'3',  'proyeccions_id'=>7, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COSTOS', 'codigo'=>'5', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>8, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COSTO DE VENTAS Y PRODUCCION', 'codigo'=>'501', 'cuenta_padre'=>'5', 'nivel'=>'2',  'proyeccions_id'=>9, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'MATERIALES UTILIZADOS O PRODUCTOS VENDIDOS', 'codigo'=>'50101', 'cuenta_padre'=>'501', 'nivel'=>'3',  'proyeccions_id'=>10, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GANANCIA ANTES DE PARTICIP. TRABAJ. E IMP. A LA RENTA DE OPERAC. CONTINUADAS', 'codigo'=>'6', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>11, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PARTICIPACION TRABAJADORES', 'codigo'=>'601', 'cuenta_padre'=>'6', 'nivel'=>'2',  'proyeccions_id'=>12, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GANANCIA (PERDIDA) ANTES DE IMPUESTOS', 'codigo'=>'602', 'cuenta_padre'=>'6', 'nivel'=>'2',  'proyeccions_id'=>13, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTROS INGRESOS', 'codigo'=>'7', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>14, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INGRESOS POR OPERACIONES DISCONTINUADAS', 'codigo'=>'701', 'cuenta_padre'=>'7', 'nivel'=>'2',  'proyeccions_id'=>10, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS POR OPERACIONES DISCONTINUADAS', 'codigo'=>'702', 'cuenta_padre'=>'7', 'nivel'=>'2',  'proyeccions_id'=>11, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTRO RESULTADO INTEGRAL', 'codigo'=>'8', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>12, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COMPONENTES DEL OTRO RESULTADO INTEGRAL', 'codigo'=>'801', 'cuenta_padre'=>'8', 'nivel'=>'2',  'proyeccions_id'=>13, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'DIFERENCIA DE CAMBIO POR CONVERSION', 'codigo'=>'80101', 'cuenta_padre'=>'801', 'nivel'=>'3',  'proyeccions_id'=>14, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'TOTAL AJUSTES POR CONVERSION', 'codigo'=>'9', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>6, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GANANCIA POR ACCION', 'codigo'=>'901', 'cuenta_padre'=>'9', 'nivel'=>'2',  'proyeccions_id'=>7, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GANANCIA POR ACCION BASICA', 'codigo'=>'90101', 'cuenta_padre'=>'901', 'nivel'=>'3',  'proyeccions_id'=>8, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                */


                ['cuenta'=>'ACTIVO', 'codigo'=>'1', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'ACTIVO CORRIENTE', 'codigo'=>'101', 'cuenta_padre'=>'1', 'nivel'=>'2',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'EFECTIVO Y EQUIVALENTES DE EFECTIVO', 'codigo'=>'10101', 'cuenta_padre'=>'101', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'CAJA', 'codigo'=>'1010101', 'cuenta_padre'=>'10101', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'CAJA', 'codigo'=>'101010101', 'cuenta_padre'=>'1010101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Caja General', 'codigo'=>'101010101001', 'cuenta_padre'=>'101010101', 'nivel'=>'6',  'proyeccions_id'=>16, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Caja Chica Guayaquil', 'codigo'=>'101010101002', 'cuenta_padre'=>'101010101', 'nivel'=>'6',  'proyeccions_id'=>17, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'BANCOS', 'codigo'=>'101010102', 'cuenta_padre'=>'1010101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'ACTIVOS FINANCIEROS', 'codigo'=>'10102', 'cuenta_padre'=>'101', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'CUENTAS Y DOCUMENTOS POR COBRAR', 'codigo'=>'1010201', 'cuenta_padre'=>'10102', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'CLIENTES NO RELACIONADOS ', 'codigo'=>'101020101', 'cuenta_padre'=>'1010201', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Clientes no  Relacionados ', 'codigo'=>'101020101001', 'cuenta_padre'=>'101020101', 'nivel'=>'6',  'proyeccions_id'=>18, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'CLIENTES  RELACIONADOS ', 'codigo'=>'101020102', 'cuenta_padre'=>'1010201', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Clientes Relacionados ', 'codigo'=>'101020202001', 'cuenta_padre'=>'101020102', 'nivel'=>'6',  'proyeccions_id'=>19, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PRESTAMOS A RELACIONADAS', 'codigo'=>'101020103', 'cuenta_padre'=>'1010201', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Prestamos a Accionistas', 'codigo'=>'101020103001', 'cuenta_padre'=>'101020103', 'nivel'=>'6',  'proyeccions_id'=>20, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PRESTAMOS NO RELACIONADAS', 'codigo'=>'101020104', 'cuenta_padre'=>'1010201', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Prestamos a Clientes', 'codigo'=>'101020104001', 'cuenta_padre'=>'101020104', 'nivel'=>'6',  'proyeccions_id'=>21, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INVENTARIO', 'codigo'=>'10103', 'cuenta_padre'=>'101', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Materiales y repuestos', 'codigo'=>'1010301', 'cuenta_padre'=>'10103', 'nivel'=>'4',  'proyeccions_id'=>22, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'ACTIVO NO CORRIENTE', 'codigo'=>'102', 'cuenta_padre'=>'1', 'nivel'=>'2',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PROPIEDADES, PLANTA Y EQUIPO', 'codigo'=>'10201', 'cuenta_padre'=>'102', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'DEPRECIABLES', 'codigo'=>'1020101', 'cuenta_padre'=>'10201', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INMUEBLES', 'codigo'=>'102010101', 'cuenta_padre'=>'1020101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Edificios', 'codigo'=>'102010201001', 'cuenta_padre'=>'102010101', 'nivel'=>'6',  'proyeccions_id'=>23, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Revaluación Edificio', 'codigo'=>'102010201002', 'cuenta_padre'=>'102010101', 'nivel'=>'6',  'proyeccions_id'=>24, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Muebles y Enseres', 'codigo'=>'102010102', 'cuenta_padre'=>'1020101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Muebles y Enseres', 'codigo'=>'102010102001', 'cuenta_padre'=>'102010102', 'nivel'=>'6',  'proyeccions_id'=>25, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Maquinaria Equipo e Instalacion', 'codigo'=>'102010103', 'cuenta_padre'=>'1020101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Maquinarias y Equipos', 'codigo'=>'102010103001', 'cuenta_padre'=>'102010103', 'nivel'=>'6',  'proyeccions_id'=>26, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Equipos de Computacion y Software', 'codigo'=>'102010104', 'cuenta_padre'=>'1020101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Equipo de Computacion', 'codigo'=>'102010104001', 'cuenta_padre'=>'102010104', 'nivel'=>'6',  'proyeccions_id'=>27, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Licencias', 'codigo'=>'102010104002', 'cuenta_padre'=>'102010104', 'nivel'=>'6',  'proyeccions_id'=>28, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Vehiculos', 'codigo'=>'102010105', 'cuenta_padre'=>'1020101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Vehiculos', 'codigo'=>'102010105001', 'cuenta_padre'=>'102010105', 'nivel'=>'6',  'proyeccions_id'=>29, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PASIVOS', 'codigo'=>'2', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PASIVOS CORRIENTES', 'codigo'=>'201', 'cuenta_padre'=>'2', 'nivel'=>'2',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'CUENTAS Y DOCUMENTOS POR PAGAR', 'codigo'=>'20103', 'cuenta_padre'=>'201', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'CUENTAS Y DOCUMENTOS POR PAGAR', 'codigo'=>'2010301', 'cuenta_padre'=>'20103', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PROVEEDORES POR PAGAR NO RELACIONADOS', 'codigo'=>'201030101', 'cuenta_padre'=>'2010301', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Proveedores por pagar no relacionados', 'codigo'=>'201030101001', 'cuenta_padre'=>'201030101', 'nivel'=>'6',  'proyeccions_id'=>30, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Proveedores Anulacion de Cheques ', 'codigo'=>'201030101002', 'cuenta_padre'=>'201030101', 'nivel'=>'6',  'proyeccions_id'=>31, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PROVEEDORES POR PAGAR RELACIONADOS', 'codigo'=>'201030102', 'cuenta_padre'=>'2010301', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Proveedores por pagar  relacionados', 'codigo'=>'201030102001', 'cuenta_padre'=>'201030102', 'nivel'=>'6',  'proyeccions_id'=>32, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTRAS OBLIGACIONES CORRIENTE', 'codigo'=>'20107', 'cuenta_padre'=>'201', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'APORTES AL I.E.S.S.', 'codigo'=>'2010703', 'cuenta_padre'=>'20107', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'APORTES AL I.E.S.S.', 'codigo'=>'201070301', 'cuenta_padre'=>'2010703', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Aporte Individual 9.45%', 'codigo'=>'201070301001', 'cuenta_padre'=>'201070301', 'nivel'=>'6',  'proyeccions_id'=>33, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Aporte Patronal 12.15%', 'codigo'=>'201070301002', 'cuenta_padre'=>'201070301', 'nivel'=>'6',  'proyeccions_id'=>34, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Fondos de Reserva', 'codigo'=>'201070301003', 'cuenta_padre'=>'201070301', 'nivel'=>'6',  'proyeccions_id'=>35, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Prestamos Quirografarios', 'codigo'=>'201070301004', 'cuenta_padre'=>'201070301', 'nivel'=>'6',  'proyeccions_id'=>36, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'BENEFICIOS SOCIALES', 'codigo'=>'2010704', 'cuenta_padre'=>'20107', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'BENEFICIOS SOCIALES', 'codigo'=>'201070401', 'cuenta_padre'=>'2010704', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Decimo Tercero Sueldo', 'codigo'=>'201070401001', 'cuenta_padre'=>'201070401', 'nivel'=>'6',  'proyeccions_id'=>37, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Decimo Cuarto Sueldo', 'codigo'=>'201070401002', 'cuenta_padre'=>'201070401', 'nivel'=>'6',  'proyeccions_id'=>38, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Vacaciones', 'codigo'=>'201070401003', 'cuenta_padre'=>'201070401', 'nivel'=>'6',  'proyeccions_id'=>39, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Sueldos por Pagar', 'codigo'=>'201070401004', 'cuenta_padre'=>'201070401', 'nivel'=>'6',  'proyeccions_id'=>40, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Varios', 'codigo'=>'201070401006', 'cuenta_padre'=>'201070401', 'nivel'=>'6',  'proyeccions_id'=>41, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PATRIMONIO', 'codigo'=>'3', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PATRIMONIO', 'codigo'=>'300', 'cuenta_padre'=>'3', 'nivel'=>'2',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PATRIMONIO', 'codigo'=>'30001', 'cuenta_padre'=>'300', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PATRIMONIO', 'codigo'=>'3000101', 'cuenta_padre'=>'30001', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PATRIMONIO', 'codigo'=>'300010101', 'cuenta_padre'=>'3000101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Capital Social', 'codigo'=>'300010101001', 'cuenta_padre'=>'300010101', 'nivel'=>'6',  'proyeccions_id'=>42, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'RESERVAS', 'codigo'=>'30004', 'cuenta_padre'=>'300', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'RESERVA LEGAL', 'codigo'=>'3000401', 'cuenta_padre'=>'30004', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'RESERVA LEGAL', 'codigo'=>'300040101', 'cuenta_padre'=>'3000401', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Reserva Legal', 'codigo'=>'300040101001', 'cuenta_padre'=>'300040101', 'nivel'=>'6',  'proyeccions_id'=>43, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTRAS RESERVAS', 'codigo'=>'3000403', 'cuenta_padre'=>'30004', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTRAS RESERVAS', 'codigo'=>'300040301', 'cuenta_padre'=>'3000403', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Otras Reservas', 'codigo'=>'300040301001', 'cuenta_padre'=>'300040301', 'nivel'=>'6',  'proyeccions_id'=>44, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INGRESOS', 'codigo'=>'4', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INGRESOS', 'codigo'=>'401', 'cuenta_padre'=>'4', 'nivel'=>'2',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INGRESOS', 'codigo'=>'40101', 'cuenta_padre'=>'401', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'VENTAS DE SERVICIOS', 'codigo'=>'4010101', 'cuenta_padre'=>'40101', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'VENTAS DE SERVICIOS 12%', 'codigo'=>'401010101', 'cuenta_padre'=>'4010101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Ingresos ', 'codigo'=>'401010101001', 'cuenta_padre'=>'401010101', 'nivel'=>'6',  'proyeccions_id'=>45, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Ventas IVA 0%', 'codigo'=>'401010201', 'cuenta_padre'=>'4010101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Ingresos IVA 0%', 'codigo'=>'401010201001', 'cuenta_padre'=>'401010201', 'nivel'=>'6',  'proyeccions_id'=>46, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTROS INGRESOS', 'codigo'=>'40108', 'cuenta_padre'=>'401', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTROS INGRESOS', 'codigo'=>'4010801', 'cuenta_padre'=>'40108', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTROS INGRESOS 0%', 'codigo'=>'401080101', 'cuenta_padre'=>'4010801', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Otros Ingresos Varios', 'codigo'=>'401020101001', 'cuenta_padre'=>'401080101', 'nivel'=>'6',  'proyeccions_id'=>47, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Intereses Ganados', 'codigo'=>'401080101002', 'cuenta_padre'=>'401080101', 'nivel'=>'6',  'proyeccions_id'=>48, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'EGRESOS', 'codigo'=>'5', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COSTOS', 'codigo'=>'501', 'cuenta_padre'=>'5', 'nivel'=>'2',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'DESCUENTO EN COMPRAS', 'codigo'=>'50101', 'cuenta_padre'=>'501', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'DESCUENTO EN COMPRAS', 'codigo'=>'5010101', 'cuenta_padre'=>'50101', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'DESCUENTO EN COMPRAS', 'codigo'=>'501010101', 'cuenta_padre'=>'5010101', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Descuento en Compras', 'codigo'=>'501010101001', 'cuenta_padre'=>'501010101', 'nivel'=>'6',  'proyeccions_id'=>49, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COSTO DE PERSONAL', 'codigo'=>'50102', 'cuenta_padre'=>'501', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COSTO DE PERSONAL', 'codigo'=>'5010201', 'cuenta_padre'=>'50102', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COSTO SUELDOS Y BENEFICIOS', 'codigo'=>'501020101', 'cuenta_padre'=>'5010201', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Sueldos', 'codigo'=>'501020101001', 'cuenta_padre'=>'501020101', 'nivel'=>'6',  'proyeccions_id'=>50, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Horas Extras', 'codigo'=>'501020101002', 'cuenta_padre'=>'501020101', 'nivel'=>'6',  'proyeccions_id'=>51, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Alimentacion ', 'codigo'=>'501020101003', 'cuenta_padre'=>'501020101', 'nivel'=>'6',  'proyeccions_id'=>52, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'BENEFICIOS SOCIALES', 'codigo'=>'5010203', 'cuenta_padre'=>'50102', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'BENEFICIOS SOCIALES', 'codigo'=>'501020301', 'cuenta_padre'=>'5010203', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Decimo Tercer Sueldo', 'codigo'=>'501020101001', 'cuenta_padre'=>'501020301', 'nivel'=>'6',  'proyeccions_id'=>53, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Decimo Cuarto Sueldo', 'codigo'=>'501020101002', 'cuenta_padre'=>'501020301', 'nivel'=>'6',  'proyeccions_id'=>38, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Vacaciones', 'codigo'=>'501020101003', 'cuenta_padre'=>'501020301', 'nivel'=>'6',  'proyeccions_id'=>39, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Desahucio', 'codigo'=>'501020101004', 'cuenta_padre'=>'501020301', 'nivel'=>'6',  'proyeccions_id'=>54, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS', 'codigo'=>'502', 'cuenta_padre'=>'5', 'nivel'=>'2',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS', 'codigo'=>'50201', 'cuenta_padre'=>'502', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'HONORARIOS', 'codigo'=>'5020105', 'cuenta_padre'=>'50201', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'HONORARIOS', 'codigo'=>'502010501', 'cuenta_padre'=>'5020105', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Honorarios Personas Naturales', 'codigo'=>'502010501001', 'cuenta_padre'=>'502010501', 'nivel'=>'6',  'proyeccions_id'=>55, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Honorarios Sociedades', 'codigo'=>'502010501002', 'cuenta_padre'=>'502010501', 'nivel'=>'6',  'proyeccions_id'=>56, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Honorarios a Notarias', 'codigo'=>'502010501003', 'cuenta_padre'=>'502010501', 'nivel'=>'6',  'proyeccions_id'=>57, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS DE SUMINISTROS Y MATERIALES', 'codigo'=>'5020108', 'cuenta_padre'=>'50201', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS DE SUMINISTROS Y MATERIALES', 'codigo'=>'502010801', 'cuenta_padre'=>'5020108', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Suministros de Oficina', 'codigo'=>'502010801001', 'cuenta_padre'=>'502010801', 'nivel'=>'6',  'proyeccions_id'=>58, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Suministros y Materiales', 'codigo'=>'502010801002', 'cuenta_padre'=>'502010801', 'nivel'=>'6',  'proyeccions_id'=>59, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'IMPUESTOS Y CONTRIBUCIONES', 'codigo'=>'5020120', 'cuenta_padre'=>'50201', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'IMPUESTOS Y CONTRIBUCIONES', 'codigo'=>'502012001', 'cuenta_padre'=>'5020120', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Impuestos, Contribuciones Y Otros', 'codigo'=>'502012001001', 'cuenta_padre'=>'502012001', 'nivel'=>'6',  'proyeccions_id'=>60, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS DE ADMINISTRACION', 'codigo'=>'50202', 'cuenta_padre'=>'502', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS DE PERSONAL', 'codigo'=>'5020201', 'cuenta_padre'=>'50202', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS SUELDOS', 'codigo'=>'502020101', 'cuenta_padre'=>'5020201', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Sueldos y Salarios', 'codigo'=>'502020101001', 'cuenta_padre'=>'502020101', 'nivel'=>'6',  'proyeccions_id'=>61, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Horas Extras', 'codigo'=>'502020101002', 'cuenta_padre'=>'502020101', 'nivel'=>'6',  'proyeccions_id'=>51, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS APORTES AL I.E.S.S.', 'codigo'=>'5020202', 'cuenta_padre'=>'50202', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS APORTES AL I.E.S.S.', 'codigo'=>'502020201', 'cuenta_padre'=>'5020202', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Fondo de Reserva', 'codigo'=>'502020201001', 'cuenta_padre'=>'502020201', 'nivel'=>'6',  'proyeccions_id'=>62, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Aporte Patronal', 'codigo'=>'502020201002', 'cuenta_padre'=>'502020201', 'nivel'=>'6',  'proyeccions_id'=>63, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS POR BENEFICIOS SOCIALES', 'codigo'=>'5020203', 'cuenta_padre'=>'50202', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS POR BENEFICIOS SOCIALES', 'codigo'=>'502020301', 'cuenta_padre'=>'5020203', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Decimo Tercer Sueldo', 'codigo'=>'502020301001', 'cuenta_padre'=>'502020301', 'nivel'=>'6',  'proyeccions_id'=>37, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Decimo Cuarto Sueldo', 'codigo'=>'502020301002', 'cuenta_padre'=>'502020301', 'nivel'=>'6',  'proyeccions_id'=>38, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Vacaciones', 'codigo'=>'502020301003', 'cuenta_padre'=>'502020301', 'nivel'=>'6',  'proyeccions_id'=>39, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Desahucio', 'codigo'=>'502020301004', 'cuenta_padre'=>'502020301', 'nivel'=>'6',  'proyeccions_id'=>54, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'SUMINISTROS Y MATERIALES', 'codigo'=>'5020207', 'cuenta_padre'=>'50202', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'SUMINISTROS Y MATERIALES', 'codigo'=>'502020701', 'cuenta_padre'=>'5020207', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Suministros y Materiales', 'codigo'=>'502020701001', 'cuenta_padre'=>'502020701', 'nivel'=>'6',  'proyeccions_id'=>59, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Combustibles', 'codigo'=>'502020701002', 'cuenta_padre'=>'502020701', 'nivel'=>'6',  'proyeccions_id'=>64, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Suministros Oficina', 'codigo'=>'502020701003', 'cuenta_padre'=>'502020701', 'nivel'=>'6',  'proyeccions_id'=>65, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS POR SERVICIOS BASICOS', 'codigo'=>'5020218', 'cuenta_padre'=>'50202', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS POR SERVICIOS BASICOS', 'codigo'=>'502021801', 'cuenta_padre'=>'5020218', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Agua', 'codigo'=>'502021801001', 'cuenta_padre'=>'502021801', 'nivel'=>'6',  'proyeccions_id'=>66, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Luz', 'codigo'=>'502021801002', 'cuenta_padre'=>'502021801', 'nivel'=>'6',  'proyeccions_id'=>67, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Telefonos', 'codigo'=>'502021801003', 'cuenta_padre'=>'502021801', 'nivel'=>'6',  'proyeccions_id'=>68, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Internet', 'codigo'=>'502021801004', 'cuenta_padre'=>'502021801', 'nivel'=>'6',  'proyeccions_id'=>69, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Telefonia Celular', 'codigo'=>'502021801005', 'cuenta_padre'=>'502021801', 'nivel'=>'6',  'proyeccions_id'=>70, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTROS GASTOS', 'codigo'=>'5020227', 'cuenta_padre'=>'50202', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTROS  GASTOS', 'codigo'=>'502022701', 'cuenta_padre'=>'5020227', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Otros Gastos', 'codigo'=>'502022701001', 'cuenta_padre'=>'502022701', 'nivel'=>'6',  'proyeccions_id'=>71, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTROS GTOS CIERRE BAL', 'codigo'=>'50206', 'cuenta_padre'=>'502', 'nivel'=>'3',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTROS GTOS CIERRE BAL', 'codigo'=>'5020601', 'cuenta_padre'=>'50206', 'nivel'=>'4',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTO IMPUESTO A LA RENTA', 'codigo'=>'502060102', 'cuenta_padre'=>'5020601', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Gasto Impuesto a la Renta', 'codigo'=>'502060102001', 'cuenta_padre'=>'502060102', 'nivel'=>'6',  'proyeccions_id'=>72, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTO RESERVA LEGAL', 'codigo'=>'502060103', 'cuenta_padre'=>'5020601', 'nivel'=>'5',  'proyeccions_id'=>NULL, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'Gasto reserva legal', 'codigo'=>'502060103001', 'cuenta_padre'=>'502060103', 'nivel'=>'6',  'proyeccions_id'=>73, 'user_id'=>$user->id, 'user_empresa_id'=>$estado->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],



            ]);

            Formulas::insert([
                ['shop_id'=>$id, 'nombre'=>'Razon Circulante', 'descripcion'=>'Número de veces que el activo corriente de una empresa puede cubrir su pasivo corriente.', 'formula'=>'Activos Rápidos/Pasivos Circulantes', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'Prueba Acida', 'descripcion'=>'Capacidad de la empresa para generar flujos de efectivo en el corto plazo, excluyendo los inventarios.', 'formula'=>'Activos Circulantes/Pasivos Circulantes', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'Razon de Endeudamiento', 'descripcion'=>'Determina la solvencia de una organización; es decir, por cada dólar que produce tu empresa, qué porcentaje corresponde a una deuda.', 'formula'=>'Deuda Total/Activos Totales', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'Razon de Deuda a Capital', 'descripcion'=>'Mide la proporción de la deuda total sobre el capital empleado por la compañía', 'formula'=>'Deuda Total/Patrimonio Total', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'Rotacion de activos', 'descripcion'=>'Indica la eficiencia de la empresa a la hora de gestionar sus activos para producir nuevas ventas', 'formula'=>'Ventas Netas/Total de Activos', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'Promedio ventas diarias', 'descripcion'=>'Promedio ventas diarias', 'formula'=>'Ventas Netas/365', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'Periodo de cobro', 'descripcion'=>'Otorga información del tiempo en días que transcurre entre el momento en el que se produce la venta de un producto y cuando se realiza el cobro al cliente.', 'formula'=>'Cuentas por cobrar/Promedio de ventas al día', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'Rotacion de Inventario', 'descripcion'=>'Uno de los parámetros utilizados para el control de gestión de la función logística o del departamento comercial de una empresa.', 'formula'=>'Costo Bienes Vendidos/Inventario Promedio', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'ROA', 'descripcion'=>'Nos permite identificar la utilidad obtenida en relación a la inversión de una empresa.', 'formula'=>'Utilidad/Activos', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'ROE', 'descripcion'=>'Mide el rendimiento del capital. Concretamente, mide la rentabilidad obtenida por la empresa sobre sus fondos propios.', 'formula'=>'Utilidad Neta/Patrimonio Accionistas', 'estado'=>NULL, 'created_at'=>$now],
                ['shop_id'=>$id, 'nombre'=>'Retorno sobre la inversion', 'descripcion'=>'Métrica usada para saber cuánto la empresa ganó a través de sus inversiones.', 'formula'=>'Utilidad Neta/Ventas Netas', 'estado'=>NULL, 'created_at'=>$now],
            ]);

        }

        /*else{
            Plancontable::insert([
                ['cuenta'=>'ACTIVO', 'codigo'=>'1', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'ACTIVO CORRIENTE', 'codigo'=>'101', 'cuenta_padre'=>'1', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'EFECTIVO Y EQUIVALENTES AL EFECTIVO', 'codigo'=>'10101', 'cuenta_padre'=>'101', 'nivel'=>'3',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PASIVO', 'codigo'=>'2', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PASIVO CORRIENTE', 'codigo'=>'201', 'cuenta_padre'=>'2', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PASIVOS FINANCIEROS A VALOR RAZONABLE CON CAMBIOS EN RESULTADOS ', 'codigo'=>'20101', 'cuenta_padre'=>'201', 'nivel'=>'3',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PATRIMONIO NETO', 'codigo'=>'3', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'CAPITAL', 'codigo'=>'301', 'cuenta_padre'=>'3', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INGRESOS', 'codigo'=>'4', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INGRESOS DE ACTIVIDADES ORDINARIAS', 'codigo'=>'401', 'cuenta_padre'=>'4', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'VENTA DE BIENES', 'codigo'=>'40101', 'cuenta_padre'=>'401', 'nivel'=>'3',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COSTOS', 'codigo'=>'5', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COSTO DE VENTAS Y PRODUCCION', 'codigo'=>'501', 'cuenta_padre'=>'5', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'MATERIALES UTILIZADOS O PRODUCTOS VENDIDOS', 'codigo'=>'50101', 'cuenta_padre'=>'501', 'nivel'=>'3',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GANANCIA ANTES DE PARTICIP. TRABAJ. E IMP. A LA RENTA DE OPERAC. CONTINUADAS', 'codigo'=>'6', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'PARTICIPACION TRABAJADORES', 'codigo'=>'601', 'cuenta_padre'=>'6', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GANANCIA (PERDIDA) ANTES DE IMPUESTOS', 'codigo'=>'602', 'cuenta_padre'=>'6', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTROS INGRESOS', 'codigo'=>'7', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'INGRESOS POR OPERACIONES DISCONTINUADAS', 'codigo'=>'701', 'cuenta_padre'=>'7', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GASTOS POR OPERACIONES DISCONTINUADAS', 'codigo'=>'702', 'cuenta_padre'=>'7', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'OTRO RESULTADO INTEGRAL', 'codigo'=>'8', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'COMPONENTES DEL OTRO RESULTADO INTEGRAL', 'codigo'=>'801', 'cuenta_padre'=>'8', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'DIFERENCIA DE CAMBIO POR CONVERSION', 'codigo'=>'80101', 'cuenta_padre'=>'801', 'nivel'=>'3',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'TOTAL AJUSTES POR CONVERSION', 'codigo'=>'9', 'cuenta_padre'=>'0', 'nivel'=>'1',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GANANCIA POR ACCION', 'codigo'=>'901', 'cuenta_padre'=>'9', 'nivel'=>'2',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
                ['cuenta'=>'GANANCIA POR ACCION BASICA', 'codigo'=>'90101', 'cuenta_padre'=>'901', 'nivel'=>'3',  'proyeccions_id'=>null, 'user_id'=>$user->id, 'user_empresa_id'=>$user->user_empresas_id, 'tipocuenta_id'=>1, 'estado'=>'activo', 'created_at'=>$now],
            ]);
        }*/


        $this->emit('info',['mensaje' => $estado->estado == 'aprovada' ? 'Compra Aprobada Correctamente' : 'Compra en estado de Proceso']);

    }

    public function ShowData($id){
        return redirect()->route('compra.detalle.individual.show', $id);
    }

    public function resetModal(){
        $this->reset(['ShowMode','costo','user_id','tipoplan_id','subservice_id']);
        $this->resetValidation();
    }

    //function dedicada para la interaccion entre el especialista y el cliente
    public function Interaccion($id){
        return redirect()->route('tienda.interaccion', $id);
    }


}
