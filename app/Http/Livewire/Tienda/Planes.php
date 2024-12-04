<?php

namespace App\Http\Livewire\Tienda;

use Livewire\Component;
use App\Servicios\Service;
use Livewire\WithPagination;
use App\Document;
use App\Servicios\Subservice;
use App\Servicios\Tiposervicio;
use App\Tienda\Shop;
use Illuminate\Support\Facades\Auth;

class Planes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public $perPage         = 10;
    public $search          = '';
    public $orderBy        = 'shops.id';
    public $orderAsc        = false;
    public $estado          = 'activo';
    public $tiposervicio ;
    public $pendiente ;
    public $especialista_id ='';
    public $role_id ;

    //COMPONENTE PARA LA ADMINISTRACION DE PLANES GENERALES

    public function mount(){
       $this-> role_id = Auth::user()->roles[0]->id;
    }

    public function render()
    {

        if(Auth::user()->hasRole('super-admin')){

            $data = Shop::join('users','shops.user_id','=','users.id')
                    ->join('services','shops.service_id','=','services.id')
                    //->join('services','subservices.service_id','=','services.id')
                    ->join('tiposervicios','services.tiposervicio_id','=','tiposervicios.id')
                    ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
                    ->where('shops.estado', 'pendiente')
                    ->where(function($query){
                    $query->where('services.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('tipoplans.nombre', 'like', '%' . $this->search . '%');
                })
                    ->select('shops.*','users.name as cliente','services.nombre as sub', 'tipoplans.nombre as ti')
                    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

        }else{

            $data = Shop::join('users','shops.user_id','=','users.id')
                    ->join('services','shops.service_id','=','services.id')
                    //->join('services','subservices.service_id','=','services.id')
                    ->join('tiposervicios','services.tiposervicio_id','=','tiposervicios.id')
                    ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')

                    ->where('tiposervicios.role_id', $this->role_id)
                    ->where('shops.estado', 'pendiente')
                    ->where(function($query){
                    $query->where('services.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('tipoplans.nombre', 'like', '%' . $this->search . '%');
                })
                    ->select('shops.*','users.name as cliente','services.nombre as sub', 'tipoplans.nombre as ti')
                    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
        }

        return view('livewire.tienda.planes', compact('data'));
    }

    public function estadochange($id)
    {

        $estado = Shop::whereNull('especialista_id')->find($id);

        if (isset($estado)) {
            $estado->estado = 'en proceso';
            $estado->especialista_id = Auth::user()->id;
            $estado->save();
            $this->emit('info',['mensaje' => $estado->estado == 'en proceso' ? 'Compra en Proceso' : 'Aprobada']);
        } else {
            $this->emit('info',['mensaje' =>'Esta Compra ya fue Asignada']);
        }
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
   

    public function ShowPlan($id){

        return redirect()->route('compra.detalle.show', $id);
    }
   

}
