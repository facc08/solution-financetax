<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Proyeccion extends Model
{
    protected $table = 'proyeccions';

    protected $fillable = [
        'descripcion', 'codigossri', 'porcentaje','estado','fechaactualizacion'
    ];
}
