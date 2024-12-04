<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
class Usuario extends Component
{
    use WithPagination;
    protected $paginationTheme ='bootstrap';
    protected $listeners       =['EliminarUsuario'];
    protected $queryString     =['search' => ['except' => ''],
    'page','findrole' =>['except'=>''] ];

        public $perPage     = 10;
        public $search      = '';
        public $orderBy     = 'id';
        public $orderAsc    = true;
        public $findrole    = '';
        public $rol         = '';
        public $role        = '';
        public $estado      ='activo';
        public $permissions =[];
        public $roles       =[];
        public $allRoles    =[];
        public $createMode  = false;
        public $editMode    = false;
        public $user_id        ='';

    public $name, $email  ;

    public function mount(){
        $this->estado    ='activo';
       }
       
    public function render()
    {   
        $this->roles = Role::whereNotIn('name',['super-admin'])->get()->pluck('name');
        $data = User::where('users.id', '!=', 1)
               ->where(function($query){
                $query->where('users.name', 'like', '%'.$this->search.'%')
                 ->orWhere('users.email', 'like', '%'.$this->search.'%');
               })
               ->where(function ($query) {
                if ($this->findrole !== '') {
                   $query->role($this->findrole);
                }
                })
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);
        return view('livewire.admin.usuario', compact('data'));
    }


    public function createUser (){
        $this->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'rol'      => 'required',
        ],[
            'name.required'        => 'No has agregado el nombre del usuario',
            'email.required'     => 'No has agregado el correo',
            'email.email'        => 'Agrega un correo valido',
            'email.unique'       => 'Este correo ya se encuentra en uso',
            'rol.required'         => 'No has selecionado un rol',
        ]);
            $this->createMode = true;

            $clave    = 12345678;
            $user     = new User;
            $user->name   = $this->name;
            $user->email  = $this->email; 
            $user->password     = Hash::make($clave);
            $user->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
            $user->save();
            $user->assignRole($this->rol);
            $this->resetInput();
            $this->emit('success',['mensaje' => 'Usuario Registrado Correctamente', 'modal' => '#createUser']);
            $this->createMode = false;


    }


    public function resetInput()
    {
		$this->name = null;
		$this->rol       = "";
		$this->user_id   = "";
		$this->estado    = "";
		$this->email   = null;
		$this->editMode  = false;
    }

     public function EditUser($id){

        $this->user_id     = $id;
        $user              = User::find($id);
        $this->name        = $user->name;
        $this->email        = $user->email;
        $this->estado    = $user->estado;
        $this->editMode  = true;
        if ($user->hasRole('admin')) {
            $this->rol         = "admin";
        }elseif($user->hasRole('contador')){
            $this->rol         = "contador";
        }elseif($user->hasRole('financiero')){
            $this->rol         = "financiero";
        }elseif($user->hasRole('marketing')){
            $this->rol         = "marketing";
        }elseif($user->hasRole('abogado')){
            $this->rol         = "abogado";
        }elseif($user->hasRole('invitado')){
            $this->rol         = "invitado";
        }elseif($user->hasRole('cliente')){
            $this->rol         = "cliente";
        }
     }


     public function updateUser (){

        $this->validate([
            'name'   => 'required',
            'email'     => 'required|email|unique:users,email,'.$this->user_id,
            'rol'         => 'required',
        ],[
            'name.required'        => 'No has agregado el nombre del usuario',
            'email.required'     => 'No has agregado el correo',
            'email.email'        => 'Agrega un correo valido',
            'email.unique'       => 'Este correo ya se encuentra en uso',
            'rol.required'         => 'No has selecionado un rol',
        ]);

        $user    = User::find($this->user_id);
        $user->name  = $this->name;
        $user->email  = $this->email;
        $user->estado   = $this->estado;
        $user->save();
        $user->syncRoles([$this->rol]);
        $this->resetInput();
        $this->emit('info',['mensaje' => 'Usuario Actualizado Correctamente', 'modal' => '#createUser']);  

     }

     public function EliminarUsuario ($id){

        $user = User::find($id);
        $user->delete();
        $this->emit('info',['mensaje' => 'Usuario Eliminado Correctamente']);
     }


     public function estadochange($id)
     {
         $estado =User::find($id);
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
