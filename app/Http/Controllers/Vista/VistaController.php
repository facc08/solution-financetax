<?php

namespace App\Http\Controllers\Vista;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VistaController extends Controller
{
    
    //vista del landing page de ssolutionfinancetax

    public function Nosotros(){
        return view('cruds.landing-page.nosotros');
    }

    public function Nuestro_equipo(){
        return view('cruds.landing-page.nuestro-equipo');
    }

    public function Servicios(){
        return view('cruds.landing-page.servicios');
    }

    public function Contactenos(){
        return view('cruds.landing-page.contactenos');
    }
}
