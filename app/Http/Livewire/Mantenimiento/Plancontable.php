<?php

namespace App\Http\Livewire\Mantenimiento;

use App\Servicios\Plancontable as Pcontable;
use App\Servicios\Tipocuenta;
use App\UserEmpresa;
use App\Servicios\Proyeccion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Plancontable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarCuenta'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];

    public $perPage             = 25;
    public $search              = '';
    public $orderBy             = 'plancontables.codigo';
    public $orderAsc            = true;
    public $plancontable_id     = '';
    public $estado              = 'activo';
    public $editMode            = false;
    public $createMode          = false;
    public $filternivel         ='';
    public $uid;
    public $empresas            =[];
    public $tipocuenta          =[];
    public $categorias          =[];
    public $cuentasPadre        =[];
    public $user_empresa_id     ='';
    public $tipocuenta_id       ='';
    public $nivel               ='';
    public $codigo              ='';
    public $cuenta              ='';
    public $cuenta_padre        ='';
    public $proyeccions_id      ='';
    public $user_id;
    public $mensajeCuenta       = "";
    public $idEmpresa;


    public function mount(){
        $this->uid = Auth::user()->id;
    }

    public function render()
    {

        $this->tipocuenta = Tipocuenta::all(['id', 'descripcion']);
        $this->categorias = Proyeccion::where('estado', 'activo')->get(['id', 'descripcion']);
        if(Auth::user()->hasRole('contador')){
            $this->empresas = UserEmpresa::where('id', $this->idEmpresa)->get();
            //$userEmpresas = UserEmpresa::find($this->idEmpresa);
            //$this->empresas = UserEmpresa::where('user_id', $userEmpresas->user_id)->get();
        }else{
            //$this->empresas = UserEmpresa::where('user_id', $this->uid)->get();
            $this->empresas = UserEmpresa::where('id', $this->idEmpresa)->get();
        }
        $empresaUsuario = $this->idEmpresa;


        $data = Pcontable::join('user_empresas','plancontables.user_empresa_id','=','user_empresas.id')
        ->join('tipocuentas','plancontables.tipocuenta_id','=','tipocuentas.id')
        ->leftJoin('proyeccions','plancontables.proyeccions_id','=','proyeccions.id')
        ->where(function($query){
            $query->where('tipocuentas.descripcion', 'like', '%'. $this->search . '%')
            ->orWhere('user_empresas.razon_social', 'like', '%' . $this->search . '%')
            ->orWhere('plancontables.cuenta', 'like', '%'. $this->search . '%');
        })       
         ->select('plancontables.*','user_empresas.razon_social as empresa','tipocuentas.descripcion as tipoc', 'proyeccions.descripcion as categoria')
         ->where(function($query){
            if($this->filternivel !== ''){
                $query->where('plancontables.nivel', $this->filternivel);
            }
        })
         //->whereIn('plancontables.user_empresa_id', $userEmpresas)
         ->where('plancontables.user_empresa_id', $this->idEmpresa)
         ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);

         $this->cuentasPadre = Pcontable::selectRaw('CONCAT(plancontables.codigo, " | ", plancontables.cuenta) as cuentaCodigo, plancontables.id')
         //->whereIn('plancontables.user_empresa_id', $userEmpresas)
         ->where('plancontables.user_empresa_id', $this->idEmpresa)
         ->pluck('plancontables.cuentaCodigo', 'plancontables.id');

        return view('livewire.mantenimiento.plancontable', compact('data', 'empresaUsuario'));
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
        $this->reset(['editMode','cuenta','nivel','codigo','user_empresa_id','tipocuenta_id', 'proyeccions_id']);
        $this->mensajeCuenta = "";
        $this->resetValidation();
    }


    public Function Create(){
        $this->validate([
            'cuenta'          =>'required',
            'nivel'           =>'required',
            'codigo'          =>'required',
            'user_empresa_id' =>'required',
            'tipocuenta_id'   =>'required',
            'cuenta_padre'    =>'required',
            'proyeccions_id'   =>'required',

        ],[
            'cuenta.required'                     => 'No has agregado La Cuenta',
            'nivel.required'                      => 'No has agregado el Nivel',
            'codigo.required'                     => 'No has agregado el Codigo',
            'user_empresa_id.required'            => 'No has Seleccionado la Empresa',
            'tipocuenta_id.required'              => 'No has Seleccionado el Tipo de Cuenta',
            'cuenta_padre.required'               => 'No has agregado La Cuenta Padre',
            'proyeccions_id.required'              => 'No has Seleccionado la Categoria',
        ]);
        $this->createMode= true;

        $c                   = new Pcontable;
        $c->cuenta           = $this->cuenta;
        $c->nivel            = $this->nivel;
        $c->codigo           = $this->codigo;

        $countCuenta = Pcontable::where('codigo', $this->codigo)->count();

        /*if(substr($this->codigo, 0, 1) !== substr($this->cuenta_padre, 0, 1) && $this->nivel > 1 && $this->cuenta_padre !== 0)
        {
            $this->mensajeCuenta = "La cuenta debe pertenecer a la misma familia de la cuenta padre";
            $this->createMode= false;
        }else{*/

            if($countCuenta > 0){
                $this->mensajeCuenta = "Este código de cuenta ya se encuentra registrado";
                $this->createMode= false;
            }else{
                $c->user_empresa_id  = $this->user_empresa_id;
                $c->user_id          = Auth::id();
                $c->tipocuenta_id    = $this->tipocuenta_id;
                $c->cuenta_padre     = $this->cuenta_padre;
                $c->estado           = $this->estado == 'activo' ? 'activo' : 'inactivo';
                $c->proyeccions_id    = $this->proyeccions_id;
                $c->save();
                $this->resetModal();
                $this->emit('success',['mensaje' => ' Cuenta Registrada Correctamente', 'modal' => '#createCuenta']);

                $this->createMode = false;
            }
        //}
    }

    public function Edit($id){

        $c                        = Pcontable::find($id);
        $this->plancontable_id    = $id;
        $this->cuenta             = $c->cuenta;
        $this->nivel              = $c->nivel;
        $this->codigo             = $c->codigo;
        $this->user_empresa_id    = $c->user_empresa_id;
        $this->tipocuenta_id      = $c->tipocuenta_id;
        $this->cuenta_padre       = $c->cuenta_padre;
        $this->estado             = $c->estado;
        $this->proyeccions_id     = $c->proyeccions_id;
        $this->editMode           = true;
   
    }

    public Function Update(){
        $this->validate([
            'cuenta'          =>'required',
            'nivel'           =>'required',
            'codigo'          =>'required',
            'user_empresa_id' =>'required',
            'tipocuenta_id'   =>'required',
            'cuenta_padre'    =>'required',
            'proyeccions_id'  =>'required',

        ],[
            'cuenta.required'                     => 'No has agregado La Cuenta',
            'nivel.required'                      => 'No has agregado el Nivel',
            'codigo.required'                     => 'No has agregado el Codigo',
            'user_empresa_id.required'            => 'No has Seleccionado la Empresa',
            'tipocuenta_id.required'              => 'No has Seleccionado el Tipo de Cuenta',
            'cuenta_padre.required'               => 'No has agregado La Cuenta Padre',
            'proyeccions_id.required'             => 'No has Seleccionado la Categoria',
        ]);
      

        $c                   =  Pcontable::find($this->plancontable_id);
        $c->cuenta           = $this->cuenta;
        $c->nivel            = $this->nivel;
        $c->codigo           = $this->codigo;
        $c->user_empresa_id  = $this->user_empresa_id;
        $c->user_id          =Auth::id();
        $c->tipocuenta_id    = $this->tipocuenta_id;
        $c->cuenta_padre     = $this->cuenta_padre;
        $c->proyeccions_id   = $this->proyeccions_id;
        $c->estado           = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $c->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => ' Cuenta Actualizada Correctamente', 'modal' => '#createCuenta']);

    }

      
   public function estadochange($id)
   {

       $estado = Pcontable::find($id);
       $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }

   
   public function eliminarCuenta($id)
   {
       $c = Pcontable::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => ' Cuenta Eliminada Correctamente']);
   }

    public function updated($name, $value)
    {
        if($name == "cuenta_padre"){
            $cuentaPadre = Pcontable::find($value);

            $cuentasHijos = Pcontable::where("cuenta_padre", $cuentaPadre->codigo)->where("user_empresa_id", $cuentaPadre->user_empresa_id)->get();

            if($cuentasHijos->count() > 0){
                if($cuentasHijos->count() < 10){
                    $nuevoCodigo = sprintf("%02d", ($cuentasHijos->count() + 1));
                }else if($cuentasHijos->count() > 9){
                    $nuevoCodigo = $cuentasHijos->count() + 1;
                }
            }else{
                $nuevoCodigo = 01;
            }

            $this->codigo = $cuentaPadre->codigo.$nuevoCodigo;
            $this->nivel = $cuentaPadre->nivel + 1;
            //return $cuentaCodigo;
        }
    }








}
