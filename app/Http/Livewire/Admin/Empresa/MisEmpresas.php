<?php

namespace App\Http\Livewire\Admin\Empresa;

use App\UserEmpresa;
use App\Tienda\Shop;
use App\Servicios\Service;
use App\PeriodoDeclaracion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;

class MisEmpresas extends Component
{
    use WithPagination;

    protected $paginationTheme ='bootstrap';
    protected $listeners       =['EliminarEmpresa'];
    protected $queryString     =['search' => ['except' => ''],
    'page' ];

        public $perPage         = 10;
        public $search          = '';
        public $orderBy         = 'id';
        public $orderAsc        = true;
        public $user_id         ='';
        public $editMode        = false;
        public $createMode      = false;
        public $user_empresa_id ='';
        public $flagShop        = false;
        public $periodos  =[];
        public $tipoRuta;

        public  $ruc,  $razon_social, $clave_acceso, $actividad, $periodo_declaracion_id;

    public function render()
    {
        $this->periodos = PeriodoDeclaracion::get(['id','descripcion']);
        $tipo = $this->tipoRuta;
        $data = UserEmpresa::join('users', 'user_empresas.user_id', '=', 'users.id')
                ->leftJoin('periodos_declaracion', 'user_empresas.periodo_declaracion_id', '=', 'periodos_declaracion.id')
                ->where('user_id', Auth::user()->id)
            ->where(function($query){
                $query->where('razon_social', 'like', '%'. $this->search . '%');
            })

            ->select('user_empresas.*', 'users.name as nombre', 'periodos_declaracion.descripcion as periodo')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.empresa.mis-empresas', compact('data', 'tipo'));
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

    public function resetInput (){

        $this->ruc            = "";
		$this->razon_social   = "";
        $this->clave_acceso   = "";
        $this->actividad   = "";
        $this->periodo_declaracion_id   = "";
		$this->editMode  = false;

    }


    public function CrearEmpresa (){

        $this->validate([
            'ruc' => 'required|max:13|unique:user_empresas',
            'razon_social' => 'required',
            'actividad' => 'required',
            'periodo_declaracion_id' => 'required',
            //'clave_acceso' => 'required',
        ],[
            'ruc.required' => 'No has Agregado el Ruc',
            'razon_social.required' => 'Debe Agregar la Razón Social',
            'actividad' => 'Debe Agregar la Actividad',
            'periodo_declaracion_id' => 'Debe Agregar el Período',
            //'clave_acceso.required' => 'Debe Agregar la Clave de Acceso',

        ]);

        $this->createMode = true;

        $empresa = new UserEmpresa;
        $empresa->ruc  = $this->ruc;
        $empresa->user_id = Auth::id();
        $empresa->razon_social = $this->razon_social;
        $empresa->actividad = $this->actividad;
        $empresa->periodo_declaracion_id = $this->periodo_declaracion_id;
        //$empresa->clave_acceso = $this->clave_acceso;
        $empresa->save();
        $this->resetInput();
        $this->emit('success',['mensaje' => 'Empresa Registrado Correctamente', 'modal' => '#createEmpresa']);
        $this->createMode = false;

        return redirect()->to('/admin/mis-empresas/'.$this->tipoRuta);
    }



    public function editEmpresa ($id)
    {
        $e                       = UserEmpresa::find($id);
        $this->user_empresa_id   = $id;
        $this->ruc               = $e->ruc;
        $this->razon_social      = $e->razon_social;
        $this->clave_acceso      = $e->clave_acceso;
        $this->actividad         = $e->actividad;
        $this->periodo_declaracion_id = $e->periodo_declaracion_id;
        $this->editMode          = true;
        $this->flagShop          = false;

        $shop = Shop::where('user_empresas_id', $id)->get();

        foreach ($shop as $key => $value) {
            $service = Service::where('id', $value->service_id)->first();
            if($value->estado == "aprobada" && $service->tiposervicio_id == 1){
                $this->flagShop = true;
                break;
            }
        }

    }


    public function updateEmpresa (){


        $this->validate([
            'ruc' => 'required',
            'razon_social' => 'required',
            //'clave_acceso' => 'required',
        ],[
            'ruc.required' => 'No has Agregado el Ruc',
            'razon_social.required' => 'Debe Agregar la Razón Social',
            //'clave_acceso.required' => 'Debe Agregar la Clave de Acceso',

        ]);

        $e  = UserEmpresa::find($this->user_empresa_id);
        $e->ruc           = $this->ruc;
        $e->razon_social  =  $this->razon_social;
        $e->clave_acceso  = $this->clave_acceso;
        $e->actividad     = $this->actividad;
        $e->periodo_declaracion_id     = $this->periodo_declaracion_id;
        $e->save();
        $this->resetInput();
        $this->emit('info',['mensaje' => 'Empresa Actualizada Correctamente', 'modal' => '#createEmpresa']);

    }


    public function EliminarEmpresa ($id){
        $tipo = request('tipo');
        $e = UserEmpresa::find($id);
        $e->delete();
        $this->emit('info',['mensaje' => 'Empresa Eliminada Correctamente']);
     }




}
