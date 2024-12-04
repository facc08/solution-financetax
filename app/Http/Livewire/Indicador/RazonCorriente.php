<?php

namespace App\Http\Livewire\Indicador;

use App\Imports\RazoncorrienteImport;
use App\Indicador\Razoncorriente as IndicadorRazoncorriente;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\Types\This;

class RazonCorriente extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString     =['search' => ['except' => ''],
    'page',
];

    public $perPage             = 10;
    public $search              = '';
    public $orderBy             = 'id';
    public $orderAsc            = true;
    public $year = [];
    public $firstRun = true;
  

  
    public $documento;
    public $uid;

    protected $listeners = [
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
        'EliminarRazon'
    ];

    public function handleOnColumnClick($column)
    {
        dd($column);
    }

    public function handleOnSliceClick($slice)
    {
        dd($slice);
    } 

   

    public function mount(){
        $this->uid = Auth::user()->id;
    }


    public function render()
    {
        $order = null;
        $columnChartModel = null;
        $pieChartModel =  null;

        $datos = IndicadorRazoncorriente::where('user_id', $this->uid)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        $data2 = IndicadorRazoncorriente::orderBy('periodo','asc')->where('user_id', $this->uid)->get();
           
            foreach ($data2 as $key => $value) {
                $array_periodo[] = $value->periodo;
                if ($this->year) {
                         $order = IndicadorRazoncorriente::whereIn('periodo', $this->year)->get();
                 } else {
                         $order = IndicadorRazoncorriente::whereIn('periodo', $array_periodo)->get();
                }
     
             } //end foreach
          
        if(isset($order)){
                $columnChartModel = $order->groupBy('periodo')
            ->reduce(function (ColumnChartModel $columnChartModel, $data) {
                $all_year = $data->first()->periodo;
                $value = $data->sum('resultado');
                $warna[$data->first()->periodo] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                return $columnChartModel->addColumn($all_year, $value, $warna[$all_year]);
            }, (new ColumnChartModel())
                ->setTitle('Razon Corriente')
                ->setAnimated($this->firstRun)
                ->withOnColumnClickEventName('onColumnClick')
            );
                             
       
            $pieChartModel = $order->groupBy('periodo')
            ->reduce(function (PieChartModel $pieChartModel, $data) {
                $all_year = $data->first()->periodo;
                $value = $data->sum('resultado');
                $warna[$data->first()->periodo] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                return $pieChartModel->addSlice($all_year, $value, $warna[$all_year]);
            }, (new PieChartModel())
                ->setTitle('Razon Corriente')
                ->setAnimated($this->firstRun)
                ->withOnSliceClickEvent('onSliceClick')
            );
        }
    
        return view('livewire.indicador.razon-corriente', compact('datos'))->with([
            'columnChartModel' => $columnChartModel,
            'pieChartModel' =>$pieChartModel,
            'data'  => $data2
        ]); 
    }


    
    public function ImportarRazonCorriente(){

        $this->validate([
            'documento'          =>'max:154000|mimes:xlx,xls,xlsx'
        ],[
            'documento.required'                     => 'Seleccione un Archivo Excel ',
        ]);

        Excel::import(new RazoncorrienteImport, $this->documento);       
        $this->emit('info',['mensaje' => ' Datos Importado Correctamente']);
    }


        public function CalcularResultado ($id){

           
            $dato = IndicadorRazoncorriente::find($id);
            $total = $dato->activo_corriente / $dato->pasivo_corriente;
         
            $dato->update([
                'resultado' => $total,
            ]);

         
            $this->emit('info',['mensaje' => ' Calculo Realizado con Exito']);
        }


        public function EliminarRazon($id)
        {
            $c = IndicadorRazoncorriente::find($id);
            $c->delete();
            $this->emit('info',['mensaje' => ' Registro Eliminada Correctamente']);
        }


}
