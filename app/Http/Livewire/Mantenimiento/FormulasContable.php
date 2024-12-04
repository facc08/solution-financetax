<?php

namespace App\Http\Livewire\Mantenimiento;

use App\UserEmpresa;
use App\Servicios\Proyeccion;
use App\Formulas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class FormulasContable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarFormula'];
    protected $queryString     =['search' => ['except' => ''],
        'page',
    ];

    public $perPage             = 25;
    public $search              = '';
    public $orderBy             = 'formulas.descripcion';
    public $orderAsc            = true;
    public $formulas_id         = '';
    public $estado              = 'activo';
    public $editMode            = false;
    public $createMode          = false;
    public $filternivel         ='';
    public $uid;
    //public $empresas            =[];
    //public $tipocuenta          =[];
    //public $categorias          =[];
    //public $cuentasPadre        =[];
    public $user_empresa_id     ='';
    public $tipocuenta_id       ='';
    public $nivel               ='';
    public $codigo              ='';
    public $cuenta              ='';
    public $cuenta_padre        ='';
    public $proyeccions_id      ='';
    public $user_id;
    public $mensajeCuenta       = "";
    public $idEmpresa;
    public $shop_id;
    public $nombre              = "";
    public $descripcion         = "";
    public $formula             = "";
    public $observacion         = "";


    public function mount(){
        $this->uid = Auth::user()->id;
    }

    public function render()
    {

        /*if(Auth::user()->hasRole('contador')){
            $this->empresas = UserEmpresa::where('id', $this->idEmpresa)->get();
        }else{
            $this->empresas = UserEmpresa::where('id', $this->idEmpresa)->get();
        }
        */
        $shop = $this->shop_id;

        //$data = Formulas::where("shop_id", $shop)->get();
        $data = Formulas::where(function($query){
            $query->where('formulas.nombre', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->where("shop_id", $shop)
        ->paginate($this->perPage);

        return view('livewire.mantenimiento.formulascontable', compact('data'));
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

    public function resetModal(){
        $this->reset(['nombre','descripcion','formula']);
        $this->mensajeCuenta = "";
        $this->resetValidation();
    }


    public Function Create(){
        $this->validate([
            'nombre'          =>'required',
            'descripcion'     =>'required',
            'formula'         =>'required',
            'observacion'         =>'required',
        ],[
            'nombre.required'                     => 'No has agregado nombre',
            'descripcion.required'                => 'No has agregado descripcion',
            'formula.required'                    => 'No has agregado formula',
            'observacion.required'                => 'No has agregado observacion',
        ]);

        $this->createMode= true;

        $c                   = new Formulas();
        $c->nombre           = $this->nombre;
        $c->descripcion      = $this->descripcion;
        $c->formula          = $this->formula;
        $c->observacion      = $this->observacion;
        $c->shop_id          = $this->shop_id;
        $c->save();

        $this->resetModal();
        $this->emit('success',['mensaje' => ' Formula Registrada Correctamente', 'modal' => '#createFormula']);

        $this->createMode = false;
    }

    public function Edit($id){
        $c                        = Formulas::find($id);
        $this->nombre             = $c->nombre;
        $this->descripcion        = $c->descripcion;
        $this->formula            = $c->formula;
        $this->observacion        = $c->observacion;
        $this->shop_id            = $c->shop_id;
        $this->formulas_id        = $id;
        $this->editMode           = true;
    }

    public Function Update(){
        $this->validate([
            'nombre'          =>'required',
            'descripcion'          =>'required',
            'formula'           =>'required',
            'observacion'           =>'required',
        ],[
            'nombre.required'                     => 'No has agregado nombre',
            'descripcion.required'                     => 'No has agregado descripcion',
            'formula.required'                      => 'No has agregado formula',
            'observacion.required'                      => 'No has agregado observacion',
        ]);

        $c                   =  Formulas::find($this->formulas_id);
        $c->nombre           = $this->nombre;
        $c->descripcion      = $this->descripcion;
        $c->formula          = $this->formula;
        $c->observacion      = $this->observacion;
        $c->shop_id          = $this->shop_id;
        $c->save();

        $this->resetModal();
        $this->emit('success',['mensaje' => ' Fórmula Actualizada Correctamente', 'modal' => '#createFormula']);

    }

   public function eliminarFormula($id)
   {
       $c = Formulas::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => ' Fórmula Eliminada Correctamente']);
   }

}
