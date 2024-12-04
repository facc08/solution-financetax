<?php

namespace App\Http\Livewire\Reporte;

use App\Exports\ReportUserTelefonoExport;
use App\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;


class Reportetelefono extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $queryString     = [
        'search' => ['except' => ''],
        'page'   => ['except' => 1]
    ];

    public $perPage        = 10;
    public $search         ='';
    public $orderBy        =  'users.id';
    public $orderAsc       = true;
    public $findrole       ='';
    public $roles          =[];

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
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
              ->paginate($this->perPage); 

        return view('livewire.reporte.reportetelefono', compact('users'));
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


    public function GenerarExcelUsuarioTelefono(){
        $users = User::where('users.id', '!=', 1)
        ->where(function($query){
                $query->where('users.name', 'like','%'. $this->search . '%');
        })
        ->where(function ($query) {
            if ($this->findrole !== '') {
                $query->role($this->findrole);
            }
        })
       ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
              ->get();
              return Excel::download(new ReportUserTelefonoExport ($users), 'users_'.now().'.xlsx');
    }
}
