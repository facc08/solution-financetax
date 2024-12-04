<?php

namespace App\Http\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $queryString     =['search' => ['except' => ''],
    'page',
    ];

    public $perPage         = 10;
    public $search          = '';
    public $orderBy         = 'id';
    public $orderAsc        = true;
    public $role            ='';
    public $estado          ='activo';
    public $permisos        =[];
    public $libres          =[];
    public $allRoles        =[];
    public $editMode        = false;
    public $createMode      = false;


    public function render()
    {
        $this->libres = Permission::where(function($query){
            if (count($this->permisos) > 0) {
                $query->whereNotIn('name', $this->permisos);

            }
        })->get();
        $this->allRoles = Role::whereNotIn('name',['super-admin'])->get()->pluck('name');
        $roles = Role::whereNotIn('name',['super-admin'])
        ->with(['permissions'])
        // dd($roles);
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->where('name', 'like', '%'.$this->search.'%')
        ->paginate($this->perPage);
        return view('livewire.admin.roles.roles', compact('roles'));
    }


    public function sortBy($field)
    {
        if ($this->orderBy === $field) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $field;
    }


    public function editPermisos($name){
        $this->role = $name;
        $this->obtenerPermisos();
    }


    public function quitarPermiso($permiso){
        $role = Role::where('name', $this->role)->first();
        $role->revokePermissionTo($permiso);
        $this->obtenerPermisos();
    }

    public function asignarPermiso($permiso){
        $role= Role::where('name', $this->role)->first();
        $role->givePermissionTo($permiso);
        $this->obtenerPermisos();
    }


    public function obtenerPermisos(){
        $role = Role::where('name', $this->role)->with(['permissions'])->first();
        $this->permisos = $role->permissions->pluck('name');
    }

    public function resetModal(){
        $this->reset(['role','permisos']);
    }



}
