<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaccionDiaria extends Model
{
    protected $table = 'transacciondiaria';

    protected $guarded = [];

    protected $fillable = [
        'usuarioempresa_id',
        'usuarioplan_id',
        'tipotransaccion_id',
        'plancuenta_id',
        'proyeccions_id',
        'fecha_registro',
        'detalle',
        'sustentos_tributarios_id',
        'tipo_comprobante_id',
        'formas_cobro_id',
        'retencion_fuente_iva_id',
        'retencion_impuesto_renta_id',
        'porcentaje_retencion_impuesto_renta',
        'tarifacero',
        'tarifadifcero',
        'iva',
        'importe',
        'archivo',
        'estado'
    ];
}
