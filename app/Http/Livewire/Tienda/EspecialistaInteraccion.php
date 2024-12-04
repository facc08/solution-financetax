<?php

namespace App\Http\Livewire\Tienda;

use App\DocumentosInteraccion;
use App\Interaccion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Tienda\Shop;

class EspecialistaInteraccion extends Component
{
    public $espe;
    public $interaccion;
    public $mensajes;

    public $compra = '';
    public $cliente;
    public $shop;

    public function mount(Shop $compra)
    {
        $this->id = Auth::user()->id;
        $this->actualizarBandeja();

        $this->cliente = $compra->cliente->id;
        $this->shop = $compra->id;
        $this->compra = $compra;
    }

    public function render()
    {
        $data = Interaccion::where('especialista_id', $this->id)
                            ->where('cliente_id', $this->cliente)
                            ->where('shop_id', $this->shop)
                            ->get();
        /* $documentos = DocumentosInteraccion::where('user_id', $this->id)->get(); */

        //dd($documentos);

        return view('livewire.tienda.especialista-interaccion',compact('data'));
    }



    public function actualizarBandeja()
    {
        /* Se traen los datos de la tabla Interacción */
        $mensajes = Interaccion::where('especialista_id', $this->espe)->get();
        $documentos = DocumentosInteraccion::where('user_id', Auth::id())->get();


        /* dd($mensajes); */

       /*  foreach ($mensajes as $mensaje) {

            if ($mensaje->especialista_id == Auth::user()->id) {

                $this->mensajes = [
                    "cliente" => $mensaje->cliente_id,
                    "detalle" => $mensaje->detalle,
                    "observacion" => $mensaje->observacion,
                    "fecha" => $mensaje->fecha
                ];
            }
        } */
    }
}
