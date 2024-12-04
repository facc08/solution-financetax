<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    protected $table = 'tipo_comprobante';

    protected $fillable = [
        'descripcion', 'codigo', 'estado'
    ];
}
