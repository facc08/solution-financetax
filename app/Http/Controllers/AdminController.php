<?php

namespace App\Http\Controllers;

use App\User;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function Inicio()
    {
        return view('admin.index');
    }



    public function index()
    {
        return view('cruds.post.indice');
    }

    public function index2()
    {
        return view('cruds.utilidades.indice');
    }

    public function index3()
    {
        return view('admin.roles.index');
    }

    public function index4()
    {
        return view('admin.usuarios.index');
    }


    public function perfil()
    {
        return view('admin.usuarios.user.perfil');
    }


    public function mis_empresas($tipo)
    {
        $tipoRuta = $tipo;
        return view('admin.usuarios.empresas.mis-empresas', compact("tipoRuta"));
    }

    public function tarjeta_credito()
    {
        return view('admin.usuarios.tarjeta-credito.tarjetacredito');
    }

}
