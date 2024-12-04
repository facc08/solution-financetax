<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class ServicioAccion extends Model
{
    protected $table = 'servicio_accion';
    public $timestamps = false;

    protected $fillable =[
        'plan_id',
        'accion_id',
       ];
}
