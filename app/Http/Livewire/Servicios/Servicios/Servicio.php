<?php

namespace App\Http\Livewire\Servicios\Servicios;

use App\Servicios\Service;
use App\Servicios\Tiposervicio;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Servicio extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarService'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

public $perPage         = 10;
public $search          = '';
public $orderBy        = 'services.id';
public $orderAsc        = true;
public $estado          = 'activo';
public $tipoServicio   = '';



    public function render()
    {
        if($this->tipoServicio == ""){
            $data = Service::join('tiposervicios', 'services.tiposervicio_id','=','tiposervicios.id')
            ->where(function($query){
                $query->where('services.nombre', 'like','%'.$this->search.'%')
                ->orWhere('tiposervicios.nombre', 'like', '%' . $this->search . '%');
            })
            ->select('services.*','tiposervicios.nombre as tipo')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        }else{

            $data = Service::join('tiposervicios', 'services.tiposervicio_id','=','tiposervicios.id')
            ->where(function($query){
                $query->where('services.nombre', 'like','%'.$this->search.'%')
                ->orWhere('tiposervicios.nombre', 'like', '%' . $this->search . '%');
            })
            ->select('services.*','tiposervicios.nombre as tipo')
            ->where('services.tiposervicio_id', $this->tipoServicio)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        }

        $tipoServicios = Tiposervicio::where('estado', 'activo')->get();

        return view('livewire.servicios.servicios.servicio', compact('data', 'tipoServicios'));
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

    public function estadochange($id)
   {

       $estado = Service::find($id);
       $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }

     public function editSer($id){
      
      return redirect()->to("servicios/nuevo-servicio?services={$id}");

    }



    public function eliminarService($id)
   {
       $c = Service::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Servicio Eliminada Correctamente']);
   }


}
