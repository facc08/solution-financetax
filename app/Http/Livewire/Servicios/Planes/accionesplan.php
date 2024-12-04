<?php

namespace App\Http\Livewire\Servicios\Planes;

use App\Servicios\ServicioAccion;
use App\Servicios\Plan;
use App\Accion;
use Livewire\Component;
use Livewire\WithPagination;

class accionesplan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['EliminarAccionPlan'];
    protected $queryString     = ['search' => ['except' => ''],
                                  'page'   => ['except' => 1]
                                ];

    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'acciones.id';
    public $orderAsc       = true;
    public $estado         = 'activo';
    public $editMode       = false;
    public $createMode     = false;
    public $acciones       = [];
    public $planes         = [];
    public $accion_id      = '';
    public $plan_id        = '';
    public $accionPlan_id  = '';

    public function render()
    {
        $this->acciones = Accion::get(['id', 'descripcion']);
        $this->planes = Plan::get(['id', 'descripcion']);

        $data = ServicioAccion::join('plans', 'servicio_accion.plan_id', '=', 'plans.id')
                    ->join('acciones', 'servicio_accion.accion_id', '=', 'acciones.id')
                    ->where(function($query){
                        $query->where('acciones.descripcion', 'like', '%' . $this->search . '%')
                        ->orWhere('plans.descripcion', 'like', '%' . $this->search . '%');
                    })
                    ->select('servicio_accion.*', 'plans.descripcion as plan', 'acciones.descripcion as accion', 'acciones.ruta as ruta')
                    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

        return view('livewire.servicios.planes.acciones', compact('data'));
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
        $this->reset(['accion_id', 'plan_id', 'editMode']);
        //$this->reset(['editMode']);
        $this->resetValidation();
    }

    public function createAccionPlan(){
        $this->validate([
            'accion_id' => 'required',
            'plan_id' => 'required',
        ],[
            'accion_id.required' => 'No has escogido la acción',
            'plan_id.required' => 'No has escogido el plan',
        ]);

        $this->createMode = true;

        $a             = new ServicioAccion();
        $a->accion_id  = $this->accion_id;
        $a->plan_id    = $this->plan_id;
        $a->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Acción / Plan registrado correctamente', 'modal' => '#createAccionPlan']);
        $this->createMode = false;
    }


    public function editAccionPlan($id){
        $this->accionPlan_id    = $id;
        $a                      = ServicioAccion::find($id);
        $this->accion_id        = $a->accion_id;
        $this->plan_id          = $a->plan_id;
        $this->editMode         = true;
    }


    public function updateAccionPlan(){
        $this->validate([
            'accion_id' => 'required',
            'plan_id' => 'required',
        ],[
            'accion_id.required' => 'No has escogido la acción',
            'plan_id.required' => 'No has escogido el plan',
        ]);

        $a                   = ServicioAccion::find($this->accionPlan_id);
        $a->accion_id        = $this->accion_id;
        $a->plan_id          = $this->plan_id;
        $a->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Acción / Plan actualizado correctamente', 'modal' => '#createAccionPlan']);
    }


    public function EliminarAccionPlan($id){

        $a = ServicioAccion::find($id);
        $a->delete();
        $this->emit('info',['mensaje' => 'Acción / Plan eliminado']);
     }


}
