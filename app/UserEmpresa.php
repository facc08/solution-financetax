<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmpresa extends Model
{
    protected $table = "user_empresas";

    protected $fillable =[
        'ruc',
        'razon_social',
        'clave_acceso',
        'actividad',
        'user_id',
        'periodo_declaracion_id',
       ];

}
