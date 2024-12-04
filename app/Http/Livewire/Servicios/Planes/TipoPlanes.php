<?php

namespace App\Http\Livewire\Servicios\Planes;

use App\Servicios\Tipoplan;
use Livewire\Component;
use Livewire\WithPagination;

class TipoPlanes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarTipoPlan'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


public $perPage         = 10;
public $search          = '';
public $orderBy         = 'id';
public $orderAsc        = true;
public $tipoplan_id     = '';
public $estado          = 'activo';
public $editMode        = false;
public $createMode      = false;

public $nombre;

    public function render()
    {
        $data = Tipoplan::where(function($query){
            $query->where('tipoplans.nombre', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.servicios.planes.tipo-planes', compact('data'));
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
        $this->reset(['nombre','editMode']);;
        $this->resetValidation();
    }

    public function createTipoPlan (){
        $this->validate([
            'nombre' =>'required',

        ],[
            'nombre.required'      => 'No has agregado el nombre del Tipo del Plan',
        ]);

        $this->createMode = true;
        $p  = new Tipoplan;
        $p->nombre  = $this->nombre;
        $p->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';

        $p->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Tipo de Plan Registrada Correctamente', 'modal' => '#createTipoPlan']);

        $this->createMode = false;
    }


    public function editTipoPlan ($id)
    {
        $c                    = Tipoplan::find($id);
        $this->tipoplan_id    =$id;
        $this->nombre         =$c->nombre;
        $this->estado         =$c->estado;
        $this->editMode       =true;
   }


   public function updateTipoPlan()
   {

    $this->validate([
        'nombre' =>'required',
    ],[
        'nombre.required'      => 'No has agregado el nombre del Tipo del Plan',
    ]);

    $m     = Tipoplan::find($this->tipoplan_id);
    $m->nombre         = $this->nombre;
    $m->estado         = $this->estado;
    $m->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Tipo Plan Actualizada Correctamente', 'modal' => '#createTipoPlan']);

   }


   public function estadochange($id)
   {

       $estado = Tipoplan::find($id);
       $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarTipoPlan($id)
   {
       $c = Tipoplan::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'TipoPlan Eliminada Correctamente']);
   }




}
