<?php

namespace App\Http\Livewire\Mantenimiento;

use App\Servicios\Impuesto;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Impuestosri extends Component
{
    
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['EliminarImpuesto'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


    public $perPage             = 10;
    public $search              = '';
    public $orderBy             = 'impuestos.id';
    public $orderAsc            = true;
    public $impuesto_id         = '';
    public $estado              = 'activo';
    public $editMode            = false;
    public $createMode          = false;


    public $descripcion, $codigosri, $porcentaje, $fechaactualizacion;

    public function mount (){
        $this->fechaactualizacion = Carbon::now()->isoFormat('YYYY-MM-DD');
    }

    public function render()
    {
        $data = Impuesto::where(function($query){
            $query->where('descripcion', 'like','%'.$this->search.'%')
            ->orWhere('codigosri', 'like', '%' . $this->search . '%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.mantenimiento.impuestosri', compact('data'));
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
        $this->reset(['editMode','descripcion','codigosri','porcentaje','fechaactualizacion']);
        $this->resetValidation();
    }


    public function Create(){
        $this->validate([
            'descripcion'          =>'required',
            'codigosri'            =>'required',
            'porcentaje'           => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'fechaactualizacion'   =>'required',
           

        ],[
            'descripcion.required'                     => 'No has agregado la Descripción',
            'codigosri.required'                      => 'No has agregado el Codigo del SRI',
            'porcentaje.required'                     => 'No has agregado el Porcentaje',
            'fechaactualizacion.required'            => 'Debe Agregar la Fecha de Actualización',
            
        ]);

        $this->createMode= true;
        $c    = new Impuesto;
        $c->descripcion           = $this->descripcion;
        $c->codigosri             = $this->codigosri;
        $c->porcentaje            = $this->porcentaje;
        $c->fechaactualizacion    = $this->fechaactualizacion;
        $c->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $c->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Impuesto SRI Creado Correctamente', 'modal' => '#createImpuesto']);

        $this->createMode = false;
    }


    public function Edit($id){

        $c                            = Impuesto::find($id);
        $this->impuesto_id            =$id;
        $this->descripcion            =$c->descripcion;
        $this->codigosri              =$c->codigosri;
        $this->porcentaje             =$c->porcentaje;
        $this->fechaactualizacion     =$c->fechaactualizacion;
        $this->estado                 =$c->estado;
        $this->editMode               =true;
   
    }


    public function Update(){

        $this->validate([
            'descripcion'          =>'required',
            'codigosri'            =>'required',
            'porcentaje'           => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'fechaactualizacion'   =>'required',
           

        ],[
            'descripcion.required'                     => 'No has agregado la Descripción',
            'codigosri.required'                      => 'No has agregado el Codigo del SRI',
            'porcentaje.required'                     => 'No has agregado el Porcentaje',
            'fechaactualizacion.required'            => 'Debe Agregar la Fecha de Actualización',
            
        ]);
        $c                   =  Impuesto::find($this->impuesto_id);
        $c->descripcion        = $this->descripcion;
        $c->codigosri            = $this->codigosri;
        $c->porcentaje           = $this->porcentaje;
        $c->fechaactualizacion  = $this->fechaactualizacion;
        $c->estado           = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $c->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Impuesto SRI Actualizado Correctamente', 'modal' => '#createImpuesto']);


    }




    public function estadochange($id)
   {

       $estado = Impuesto::find($id);
       $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }

   
   public function EliminarImpuesto($id)
   {
       $c = Impuesto::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => ' Registro Eliminada Correctamente']);
   }




}
