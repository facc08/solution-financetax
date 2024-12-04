<?php

namespace App\Tienda;

use Illuminate\Database\Eloquent\Model;

class DetallePagoPP extends Model
{
    protected $table = 'detalle_pagos_pp';
    public $timestamps = false;

    protected $fillable =[
        'shop_id',
        'user_id',
        'estado',
        'transactionId',
        'clientTransactionId',
        'respuesta_detalle',
    ];

}
