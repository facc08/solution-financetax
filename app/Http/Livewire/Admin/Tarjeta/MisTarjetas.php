<?php

namespace App\Http\Livewire\Admin\Tarjeta;

use App\UserTarjeta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;


class MisTarjetas extends Component
{
    //componente creado para la manipulacion de tarjetas de credito
    use WithPagination;

    protected $paginationTheme ='bootstrap';
    protected $listeners       =['EliminarTarjeta'];
    protected $queryString     =['search' => ['except' => ''],
    'page' ];

    public $perPage         = 10;
    public $search          = '';
    public $orderBy         = 'id';
    public $orderAsc        = true;
    public $n_tarjeta = '';
    public $ano_vencimiento ='';
    public $mes_vencimiento ='';
    public $cvv ='';
    public $tipo        = "";
    public $propietario ='';
    public $user_id     ='';
    public $user_tarjeta_id = '';
    public $editMode        = false;
    public $createMode      = false;


    public function mount ()
    {
        //$this->n_tarjeta = Separador() ;

    }

    public function render()
    { 
              
              $data = UserTarjeta::where(function($query){
                  $query->where('user_id', Auth::user()->id);
              })
              ->select('user_tarjetas.*')
              ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
              ->paginate($this->perPage);
            
        // dd($data);

        return view('livewire.admin.tarjeta.mis-tarjetas', compact('data'));
    }


    public function resetInput (){

        $this->n_tarjeta       = "";
		$this->ano_vencimiento = "";
        $this->mes_vencimiento = "";
        $this->tipo            = "";
		$this->cvv             = "";
        $this->propietario     = "";
		$this->editMode        = false;

    }


    public function CrearTarjeta (){

        $this->validate([
            'n_tarjeta'          => 'required',
            'ano_vencimiento'    => 'required',
            'mes_vencimiento'    => 'required|max:2',
            'tipo'               => 'required',
            'cvv'                => 'required|max:3|min:3',
            'propietario'        => 'required',
        ],[
            'n_tarjeta.required'        => 'No has Agregado el Numero de Tarjeta Credito',
            'ano_vencimiento.required'    => 'Debe Agregar el Año de Vencimiento',
            'mes_vencimiento.required'    => 'Debe Agregar el Mes de Vencimiento',
            'cvv.required'              => 'El Codigo de Seguridad es Obligatorio',
            'tipo.required'              => 'El Tipo de Tarjeta es Obligatorio',
            'propietario.required'      => 'Debe Agregar el Propietario de la Tarjeta',
        ]);

        $this->createMode = true;

        $t = new UserTarjeta;
        $t->n_tarjeta       = $this->n_tarjeta;
        $t->user_id         = Auth::id();
        $t->ano_vencimiento   = $this->ano_vencimiento;
        $t->mes_vencimiento   = $this->mes_vencimiento;
        $t->tipo             = $this->tipo;
        $t->cvv             = $this->cvv;
        $t->propietario     = $this->propietario;
        $t->save();
        $this->resetInput();
        $this->emit('success',['mensaje' => 'Tarjeta  Agregada Correctamente', 'modal' => '#createTarjeta']);
        $this->createMode = false;
    }

    public function editTarjeta($id){
        $t                       = UserTarjeta::find($id);
        $this->user_tarjeta_id   = $id;
        $this->n_tarjeta         = $t->n_tarjeta;
        $this->ano_vencimiento   = $t->ano_vencimiento;
        $this->mes_vencimiento   = $t->mes_vencimiento;
        $this->cvv               = $t->cvv;
        $this->tipo               = $t->tipo;
        $this->propietario       = $t->propietario ;
        $this->editMode          = true;
    }


    public function updateTarjeta(){
        $this->validate([
            'n_tarjeta'          => 'required',
            'ano_vencimiento'    => 'required',
            'mes_vencimiento'    => 'required|max:2',
            'cvv'                => 'required|max:3|min:3',
            'propietario'        => 'required',
        ],[
            'n_tarjeta.required'        => 'No has Agregado el Numero de Tarjeta Credito',
            'ano_vencimiento.required'    => 'Debe Agregar el Año de Vencimiento',
            'mes_vencimiento.required'    => 'Debe Agregar el Mes de Vencimiento',
            'cvv.required'              => 'El Codigo de Seguridad es Obligatorio',
            'propietario.required'      => 'Debe Agregar el Propietario de la Tarjeta',
        ]);


        $t = UserTarjeta::find($this->user_tarjeta_id);
        $t->n_tarjeta  = $this->n_tarjeta;
        $t->ano_vencimiento =$this->ano_vencimiento;
        $t->mes_vencimiento =$this->mes_vencimiento;
        $t->cvv              =$this->cvv;
        $t->tipo              =$this->tipo;
        $t->propietario      =$this->propietario;
        $t->save();
        $this->resetInput();
        $this->emit('info',['mensaje' => 'Tarjeta Actualizada Correctamente', 'modal' => '#createTarjeta']);
    }



    public function EliminarTarjeta($id){

        $e = UserTarjeta::find($id);
        $e->delete();
        $this->emit('info',['mensaje' => 'Tarjeta de Credito Eliminada Correctamente']);
     }

}
