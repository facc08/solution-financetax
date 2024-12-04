<?php

namespace App\Http\Livewire\Reporte;

use App\Tienda\Shop;
use App\Accion;
use App\UserEmpresa;
use App\Servicios\ServicioAccion;
use App\Servicios\Tiposervicio;
use App\Servicios\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use DateTime;

class Indicadores extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public $perPage         = 45;
    public $search          = '';
    public $orderBy         = 'services.nombre';
    public $orderAsc        = true;
    public $uid;
    public $condicional;

    //prueba para el modal
    public $user;
    public $detalle;
    public $observacion;
    public $documento = [];
    public $tipoServicio   = '';
    public $servicio       = '';

    //LISTA DE LOS PLANES DE LOS CLIENTES- SOLICITUD DE COMPRA

    public function mount(){
        $this-> uid = Auth::user()->id;


    }

    public function render()
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

        if($this->tipoServicio == ""){

            $data = Shop::where('shops.'.$campoQuery, $this->uid)
            ->join('users','shops.especialista_id', '=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
            ->where(function($query){
                $query->where('services.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('users.name', 'like', '%' . $this->search . '%');
            })
            ->where('shops.estado','!=','pendiente')
            ->select('shops.*','services.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                    'services.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

            $servicios = [];

        }else if($this->tipoServicio !== "" && $this->servicio == ""){

            $data = Shop::where('shops.'.$campoQuery, $this->uid)
            ->join('users','shops.especialista_id', '=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
            ->where(function($query){
                $query->where('services.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('users.name', 'like', '%' . $this->search . '%');
            })
            ->where('shops.estado','!=','pendiente')
            ->where('services.tiposervicio_id', $this->tipoServicio)
            ->select('shops.*','services.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                    'services.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

            $servicios = Service::where('tiposervicio_id', $this->tipoServicio)->get();

        }else if($this->tipoServicio !== "" && $this->servicio !== ""){

            $data = Shop::where('shops.'.$campoQuery, $this->uid)
            ->join('users','shops.especialista_id', '=','users.id')
            ->join('services','shops.service_id', '=','services.id')
            ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
            ->where(function($query){
                $query->where('services.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('users.name', 'like', '%' . $this->search . '%');
            })
            ->where('shops.estado','!=','pendiente')
            ->where('shops.service_id', $this->servicio)
            ->select('shops.*','services.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                    'services.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

            $servicios = Service::where('tiposervicio_id', $this->tipoServicio)->get();
        }

        $tipoServicios = Tiposervicio::where('estado', 'activo')->get();

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
            $EmpresasNombre = UserEmpresa::where('user_id', $this->uid)->pluck('razon_social', 'id');
        }

        $date1 = new DateTime(Carbon::now());

        foreach ($EmpresasNombre as $keyEn => $valueEn) {

            if(Auth::user()->hasRole('contador'))
                $userId = $EmpresasUsuarios[$keyEn];
            else
                $userId = $this->uid;

            $dataEmpresas[$valueEn] = Shop::where('shops.user_id', $userId)
                    ->join('users','shops.especialista_id', '=','users.id')
                    ->join('services','shops.service_id', '=','services.id')
                    ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
                    ->where(function($query){
                        $query->where('services.nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('users.name', 'like', '%' . $this->search . '%');
                    })
                    ->where('shops.estado','!=','pendiente')
                    ->where('user_empresas_id', $keyEn)
                    ->select('shops.*', 'shops.id as shop_id', 'services.nombre as sub','tipoplans.nombre as tipoplan','users.name as especialista',
                            'services.id as id_subservice', 'tipoplans.id as id_tipoplan', 'tipoplans.id as id_tipoplan', 'shops.user_empresas_id as userEmpresa')
                    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

            foreach ($dataEmpresas[$valueEn] as $key => $value) {
                $date2 = new DateTime($dataEmpresas[$valueEn][$key]->fecha_caducidad);
                $diff = $date2->diff($date1)->format("%a");
                if($date1 > $date2)
                    $dataEmpresas[$valueEn][$key]->diasRestantes = (-1 * intval($diff));
                else
                    $dataEmpresas[$valueEn][$key]->diasRestantes = intval($diff);
            }
        }

        return view('livewire.reporte.indicadores', compact('data', 'acciones', 'rutasNombre', 'EmpresasNombre', 'dataEmpresas', 'tipoServicios', 'servicios'));
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

    public function tipoChange(){

        $this->render();
    }

    //function para la vista de detalle de la compra realizada por el cliente
    public function Show($id){

        return redirect()->route('cliente.detalle.compra', $id);

    }
    //function dedicada para la interaccion entre el cliente y especialista
    public function Interaccion($id){
        return redirect()->route('cliente.interaccion', $id);
    }
}
