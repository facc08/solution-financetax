<?php

namespace App\Http\Livewire\Reporte;

use App\Exports\ReportGeneroExport;
use App\Exports\ReportUserExport;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;


class Reportegenero extends Component
{
    use WithPagination;
    use WithFileUploads;


        protected $paginationTheme = 'bootstrap';
        protected $listeners       = ['EliminarImpuesto'];
        protected $queryString     =['search' => ['except' => ''],
        'page',
        ];

        public $perPage  = 10;
        public $search   ='';
        public $orderBy =  'users.id';
        public $orderAsc = true;
        public $filtro_edad ;
        public $filtro_ciudad;
        public $findrole='';
        public $filtro_genero ='';
        public $roles       =[];
        public $to;
        public $from   ;



    public function mount($rol='cliente'){
        $this->rol= $rol;
        $this->from = starMonth();
        $this->to   =  finalMes();

    }


    public function render()
    {
        $this->roles = Role::whereNotIn('name',['super-admin'])->get()->pluck('name');
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
            if($this->filtro_genero !== ''){
             $query->where('users.genero', $this->filtro_genero);
         }
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
              ->paginate($this->perPage);

    //   ->get();
    //   dd($users);

        return view('livewire.reporte.reportegenero', compact('users'));
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


    public function GenerarExcelGeneroUsuario(){


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
            if($this->filtro_genero !== ''){
             $query->where('users.genero', $this->filtro_genero);
         }
        })

            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
              ->get();
              return Excel::download(new ReportGeneroExport ($users), 'users_'.now().'.xlsx');
    }
}
