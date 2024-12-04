<?php

namespace App\Http\Livewire\Servicios\Servicios;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use App\Servicios\Tiposervicio as Tiposer;

class Tiposervicio extends Component
{

    use WithPagination;
    protected $paginationTheme ='bootstrap';
    protected $listeners       =['EliminarTipoServicio'];
    protected $queryString     =['search' => ['except' => ''],
    'page','findrole' =>['except'=>''] ];

    public $perPage                = 10;
    public $search                 = '';
    public $orderBy                = 'id';
    public $orderAsc               = true;
    public $findrole               = '';
    public $rol                    = '';
    public $role                   = '';
    public $estado                 ='activo';
    public $nombre                 = '';
    public $icon                 = '';
    public $roles                  =[];
    public $createMode             = false;
    public $editMode               = false;
    public $tiposervicio_id        ='';
    public $role_id                ='';


    public function mount(){
        $this->estado    ='activo';
       }


    public function render()
    {
        $this->roles = Role::whereNotIn('name',['super-admin'])->get(['id', 'name']);
        $data = Tiposer::join('roles','tiposervicios.role_id','roles.id')
         ->where(function($query){
            $query->where('tiposervicios.nombre', 'like', '%'.$this->search.'%');
           
           })
           ->select('tiposervicios.*','roles.name as rol')
           ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
           ->paginate($this->perPage);
        //dd($data);
        return view('livewire.servicios.servicios.tiposervicio', compact('data'));

    }

    public function resetModal(){ 
        $this->reset(['nombre','editMode','icon']);
        $this->resetValidation();
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


    public function create(){
        $this->validate([
            'nombre'     => 'required|unique:tiposervicios',
            'role_id'      => 'required',
        ],[
            'nombre.required'        => 'No has agregado el nombre del usuario',
            'nombre.unique'        => 'Nombre duplicado',
            'role_id.required'         => 'No has selecionado un Rol',
        ]);

        $this->createMode = true;

        $a               = new Tiposer;
        $a->nombre       = $this->nombre;
        $a->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $a->role_id       = $this->role_id;
        $a->icon          = $this->icon;
        $a->save();

        $this->resetModal();
        $this->emit('success',['mensaje' => 'Tipo Servicio Registrado Correctamente', 'modal' => '#createTservicio']);
        $this->createMode = false;


    }


    public function editTservicio($id){
        $this->tiposervicio_id  = $id;
        $a                      = Tiposer::find($id);
        $this->nombre           = $a->nombre;
        $this->estado           = $a->estado;
        $this->role_id          = $a->role_id;
        $this->icon             = $a->icon;
        $this->editMode  = true;
        // if ($a->hasRole('admin')) {
        //     $this->rol         = "admin";
        // }elseif($a->hasRole('contador')){
        //     $this->rol         = "contador";
        // }elseif($a->hasRole('financiero')){
        //     $this->rol         = "financiero";
        // }elseif($a->hasRole('marketing')){
        //     $this->rol         = "marketing";
        // }elseif($a->hasRole('abogado')){
        //     $this->rol         = "abogado";
        // }elseif($a->hasRole('invitado')){
        //     $this->rol         = "invitado";
        // }elseif($a->hasRole('cliente')){
        //     $this->rol         = "cliente";
        // }

    }


    public function updateTservicio(){

        $this->validate([
            'nombre'     => 'required',
            'role_id'      => 'required',
        ],[
            'nombre.required'        => 'No has agregado el nombre del usuario',
            'role_id.required'         => 'No has selecionado un Rol',
        ]);
        $a    = Tiposer::find($this->tiposervicio_id);
        $a->nombre   = $this->nombre;
        $a->estado   = $this->estado;
        $a->role_id       = $this->role_id;
        $a->icon       = $this->icon;
        $a->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Tipo Servicio Actualizado Correctamente', 'modal' => '#createTservicio']);
       

    }


    public function EliminarTipoServicio ($id){

        $a = Tiposer::find($id);
        $a->delete();
        $this->emit('info',['mensaje' => 'Tipo de Servicio Eliminado Correctamente']);
     }


    public function estadochange($id)
    {
        $estado =Tiposer::find($id);
        if ($estado->estado == 'activo') {
            $estado->estado ='inactivo';
            $estado->save();
         $this->emit('info',['mensaje' => 'Estado Desactivado Actualizado']);
         } else {
            $estado->estado = 'activo';
         $estado->save();
        $this->emit('info',['mensaje' => 'Estado Activado Actualizado']);
         }
    }



}
