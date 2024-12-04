<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class RetencionFuenteIva extends Model
{
	protected $table = 'retencion_fuente_iva';

    protected $fillable =[
        'descripcion',
        'porcentaje_retencion_iva',
        'estado',
    ];
}
