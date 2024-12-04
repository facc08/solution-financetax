<?php

namespace App\Http\Livewire\Reporte;

use App\City;
use App\Exports\ReportUserCiudadExport;
use App\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Reporteuserciudad extends Component
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
    public $filtro_ciudad  ='';
    public $ciudadesall =[];



    public function render()
    {
        $this->ciudadesall = City::select('cities.*')->orderBy('nombre', 'asc')->get();
        $users = User::where('users.id', '!=', 1)
        ->join('cities', 'users.city_id' ,'=','cities.id')
        ->where(function($query){
                $query->where('users.name', 'like','%'. $this->search . '%');
        })

        ->where(function($query){
            if($this->filtro_ciudad !== ''){
             $query->where('users.city_id', $this->filtro_ciudad);
         }
        })
        ->select('users.*','cities.nombre as ciudad')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
              ->paginate($this->perPage); 
        
        return view('livewire.reporte.reporteuserciudad', compact('users'));
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


    public function GenerarExcelCiudadUsuario(){


        $users = User::where('users.id', '!=', 1)
        ->join('cities', 'users.city_id' ,'=','cities.id')
        ->where(function($query){
                $query->where('users.name', 'like','%'. $this->search . '%');
        })

        ->where(function($query){
            if($this->filtro_ciudad !== ''){
             $query->where('users.city_id', $this->filtro_ciudad);
         }
        })
        ->select('users.*','cities.nombre as ciudad')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->get();
            return Excel::download(new ReportUserCiudadExport ($users), 'users_'.now().'.xlsx');
    }

}
