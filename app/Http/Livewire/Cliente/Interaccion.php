<?php

namespace App\Http\Livewire\Cliente;

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
    public $shop;
    public $especialista;
    public $detalle = '';
    public $fecha;
    public $observacion = '';
    public $documentos = []; //es un array
    public $createMode          = false;
    public $url;



    public function mount(Shop $compra)
    {
        $this->especialista = $compra->especialista->id;
        $this->shop = $compra->id;
        $this->compra = $compra;
    }


    public function render()
    {
        // $data = Shop::where('especialista_id', $this->especialista)
        //     ->where('id', $this->shop)
        //     ->with('interaccion')
        //     ->get();

        $data = AppInteraccion::where('especialista_id', $this->especialista)
            ->where('shop_id', $this->shop)
            ->with(['docs' => function ($query) {
                $query->select('id', 'documento_interaccion');
            }])
            ->with('docs')->get();


        /* dd($data); */
        return view('livewire.cliente.interaccion', compact('data'));
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
            'detalle.required'              => 'No has agregado un Detalle ',
            'observacion.required'          => 'No has agregado una Observacion',
            //'fecha.required'                => 'No has selecionado una Fecha',

        ]);

        $this->createMode = true;


        $message                       = new AppInteraccion;
        $message->cliente_id           = Auth::user()->id;
        $message->especialista_id      = $this->especialista;
        $message->tipo                 = "C";
        $message->fecha                = Carbon::now();
        $message->detalle              = $this->detalle;
        $message->observacion          = $this->observacion;
        $message->shop_id              = $this->shop;
        $message->save();
        $documentos = $this->StoreMultipleDoc($message);
        $this->resetModal();
        $this->emit('success', ['mensaje' => 'Mensaje Enviado Correctamente', 'modal' => '#modalInteraccion']);

        $this->createMode = false;

        return redirect()->to('/tienda/interaccion-compra/'.$this->shop.'/show');
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

                /*  $data2 = array(
                    'interaccion_id' => $message->id,
                    'documento_interaccion' => $name[$key],
                    'url_archivo '     => $archivo,
                    'user_id'          => Auth::user()->id,
                ); */

        }

    }
}
