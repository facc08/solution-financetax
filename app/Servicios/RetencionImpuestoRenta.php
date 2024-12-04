<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class RetencionImpuestoRenta extends Model
{
	protected $table = 'retencion_impuesto_renta';

    protected $fillable =[
        'descripcion',
        'porcentaje',
		'codigo_formulario',
		'codigo_anexo',
		'estado'
    ];
}
