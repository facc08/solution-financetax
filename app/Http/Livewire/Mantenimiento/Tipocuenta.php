<?php

namespace App\Http\Livewire\Mantenimiento;

use App\Servicios\Tipocuenta as ServiciosTipocuenta;
use Livewire\Component;
use Livewire\WithPagination;

class Tipocuenta extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarTipocuenta'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];

    public $perPage         = 10;
    public $search          = '';
    public $orderBy         = 'id';
    public $orderAsc        = true;
    public $tipocuenta_id     = '';
    public $estado          = 'activo';
    public $editMode        = false;
    public $createMode      = false;
    public $signo           = '';
    public $descripcion     = '';

    public function render()
    {   
        $data = ServiciosTipocuenta::where(function($query){
            $query->where('tipocuentas.descripcion', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

       // dd($data);
        return view('livewire.mantenimiento.tipocuenta', compact('data'));
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
        $this->reset(['descripcion','signo','editMode']);;
        $this->resetValidation();
    }



    public function Create(){

        $this->validate([
            'descripcion' =>'required',
            'signo' =>'required|max:1',

        ],[
            'descripcion.required'      => 'No has agregado el Tipo de  Cuenta',
            'signo.required'            => 'No has agregado el Signo',
        ]);

        $this->createMode= true;

         $c = new ServiciosTipocuenta;
         $c->descripcion  = $this->descripcion; 
         $c->signo        = $this->signo;
         $c->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
         $c->save();
         $this->resetModal();
         $this->emit('success',['mensaje' => 'Tipo Cuenta Registrada Correctamente', 'modal' => '#createTipocuenta']);

         $this->createMode = false;
    }


    public function editTipocuenta ($id)
    {
        $c                      = ServiciosTipocuenta::find($id);
        $this->tipocuenta_id    =$id;
        $this->descripcion      =$c->descripcion;
        $this->signo            =$c->signo;
        $this->estado           =$c->estado;
        $this->editMode         =true;
   }


   public function Update (){


    $this->validate([
        'descripcion' =>'required',
        'signo' =>'required|max:1',

    ],[
        'descripcion.required'      => 'No has agregado La Cuenta',
        'signo.required'            => 'No has agregado el Signo',
    ]);
    $m     = ServiciosTipocuenta::find($this->tipocuenta_id);
    $m->descripcion         = $this->descripcion;
    $m->signo               = $this->signo;
    $m->estado              = $this->estado;
    $m->save();  
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Tipo Cuenta Actualizada Correctamente', 'modal' => '#createTipocuenta']);

   }


   
   public function estadochange($id)
   {

       $estado = ServiciosTipocuenta::find($id);
       $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarTipocuenta($id)
   {
       $c = ServiciosTipocuenta::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Tipo Cuenta Eliminada Correctamente']);
   }


}
