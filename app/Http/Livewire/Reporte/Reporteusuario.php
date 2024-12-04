<?php

namespace App\Http\Livewire\Reporte;

use App\Exports\ReportUserExport;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;


class Reporteusuario extends Component
{
    use WithPagination;
    use WithFileUploads;


        protected $paginationTheme = 'bootstrap';
        protected $queryString     = [
            'search' => ['except' => ''],
            'page'   => ['except' => 1]
        ];

        public $perPage      = 10;
        public $search       ='';
        public $orderBy      =  'users.id';
        public $orderAsc     = true;
        public $filtro_edad  ='';
        public $findrole     ='';
        public $roles        =[];
        public $edades       =[];
    



    public function render()
    {
        $this->roles = Role::whereNotIn('name',['super-admin'])->get()->pluck('name');
        $this->edades = User::where('estado', 'activo')->whereNotNull('edad')->get()->pluck('edad');
        $users = User::where('users.id', '!=', 1)
        ->where(function($query){
                $query->where('users.name', 'like','%'. $this->search . '%');
        })

        ->where(function ($query) {
            if ($this->findrole !== '') {
                $query->role($this->findrole);
            }
        })
        ->where(function($query){
            if($this->filtro_edad !== ''){
             $query->where('users.edad', $this->filtro_edad);
         }
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
              ->paginate($this->perPage); 
        return view('livewire.reporte.reporteusuario', compact('users'));
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


    public function GenerarExcelEdadUsuario(){
        $users = User::where('users.id', '!=', 1)
        ->where(function($query){
                $query->where('users.name', 'like','%'. $this->search . '%');
        })
        ->where(function ($query) {
            if ($this->findrole !== '') {
                $query->role($this->findrole);
            }
        })
        ->where(function($query){
            if($this->filtro_edad !== ''){
             $query->where('users.edad', $this->filtro_edad);
         }
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
              ->get();
              return Excel::download(new ReportUserExport ($users), 'users_'.now().'.xlsx');
    }
}
