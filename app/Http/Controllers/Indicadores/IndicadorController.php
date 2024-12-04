<?php

namespace App\Http\Controllers\Indicadores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //REDIRECCION DE VISTA DE INDICADORES DE LIQUIDEZ
    public function Razoncorriente(){
        return view('cruds.Indicadores.indicadores-liquidez.razon-corriente');
    }

    
}
