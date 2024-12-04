<?php

namespace App\Http\Livewire\Tienda;

use App\Interaccion as AppInteraccion;
use App\DocumentosInteraccion;
use Livewire\Component;
use App\Tienda\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Interaccion extends Component

{
    use WithFileUploads;

    public $compra = '';
    public $cliente;
    public $shop;


    //prueba para la bandeja
    public $mensajes;


    //prueba para el modal
    public $detalle = '';
    public $fecha;
    public $observacion = '';
    public $documentos = []; //es un array
    public $createMode = false;
    public $muestraCarga = 0;

    public function mount(Shop $compra)
    {
        $this->cliente = $compra->cliente->id;
        $this->shop = $compra->id;
        $this->compra = $compra;

    }


    public function render()
    {
        $data = AppInteraccion::where('cliente_id', $this->cliente)
            ->where('shop_id', $this->shop)
            ->with(['docs' => function ($query) {
                $query->select('id', 'documento_interaccion');
            }])
            ->with('docs')->get();

        return view('livewire.tienda.interaccion', compact('data'));
    }



    public function resetModal()
    {
        $this->reset(['createMode', 'detalle', 'observacion', 'fecha', 'documentos']);
        $this->resetValidation();
    }

    public function enviarMensaje()
    {
        $this->validate([
            'detalle'     => 'required',
            'observacion'      => 'required',
            //'fecha'      => 'required',
        ], [
            'detalle.required'        => 'No has agregado un Detalle ',
            'observacion.required'         => 'No has agregado una Observacion',
            //'fecha.required'         => 'No has selecionado una Fecha',
        ]);


        $this->createMode = true;
        $message                       = new AppInteraccion;
        $message->especialista_id      = Auth::user()->id;
        $message->cliente_id           = $this->cliente;
        $message->tipo                 = "E";
        $message->fecha                = Carbon::now();
        $message->detalle              = $this->detalle;
        $message->observacion          = $this->observacion;
        $message->shop_id              = $this->shop;
        $message->save();
        $documentos = $this->StoreMultipleDoc($message);
        $this->resetModal();
        $this->emit('success', ['mensaje' => 'Mensaje Enviado Correctamente', 'modal' => '#modalInteraccionEspecialista']);

        $this->createMode = false;

        return redirect()->to('/tienda/interaccion-compra-especialista/'.$this->shop.'/show');
    }


    public function StoreMultipleDoc($message)
    {

        foreach ($this->documentos as $key => $doc) {
            $name[] =  $doc->getClientOriginalName();
            $archivo = Str::slug($doc->getClientOriginalName()) . '.' . $doc->getClientOriginalExtension() ;

            if (Storage::putFileAs('documentos_interaccion', $doc, $archivo)) {
                DocumentosInteraccion::create([
                    'interaccion_id'            => $message->id,
                    'documento_interaccion'     => $name[$key],
                    'url_archivo'               =>  $archivo,
                    'user_id'                   => Auth::user()->id,
                ]);
            }

            /* $data2 = array(
                'interaccion_id' => $message->id,
                'documento_interaccion' => $name[$key],
                'url_archivo '     => $archivo,
                'user_id'          => Auth::user()->id,
            );

            DocumentosInteraccion::create($data2); */
        }
    }
}
