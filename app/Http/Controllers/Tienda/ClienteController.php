<?php

namespace App\Http\Controllers\Tienda;

use App\Document;
use App\DocumentosInteraccion;
use App\Http\Controllers\Controller;
use App\Servicios\Plan;
use App\Tienda\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{

    //funciones para el cliente e interacciones

    public function __construct()
    {
        $this->middleware('auth');
    }

    //funcion para redireccionar a la vista detalle de la lista de cliente
    public function ShowDataCliente($id)
    {

        $compra = Shop::with([
            'tipoplan' => function ($query) {
                $query->select('id', 'nombre');
            },
            'tipoplan.planes',
            'subservicio' => function ($query) {
                $query->select('id', 'nombre', 'descripcion');
            },
            'especialista' => function ($query) {
                $query->select('id', 'name', 'email');
            },
            'plan' => function ($query) {
                $query->select('id', 'descripcion');
            }

        ])->find($id);
        //dd($compra);
        return view('cruds.cliente.showdetalle', compact('compra'));
    }

    //funcion para la interaccion con el especialista
    public function InteraccionCliente($id)
    {
        $compra = Shop::with([
            'tipoplan' => function ($query) {
                $query->select('id', 'nombre');
            },
            'especialista' => function ($query) {
                $query->select('id', 'name', 'email');
            },

        ])->find($id);
        return view('cruds.cliente.cliente-interaccion', compact('compra'));
    }


    /* Guardando los documentos */
    public function store(Request $request)
    {
        $max_size = (int)ini_get('upload_max_filesize') * 10240;
        $files = $request->file('files');
        $user_id = Auth::id();



        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $fileName = Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension() ;

                if (Storage::putFileAs('/public/' . $user_id . '/', $file, $fileName)) {
                    DocumentosInteraccion::create([
                        'user_id'               => $user_id,
                        'nombre'                => $fileName,
                    ]);
                }
            }

            return back();

        } else {
            return 'Error';
        }

    }
}
