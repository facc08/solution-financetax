<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoDeclaracion extends Model
{
    protected $table = 'periodos_declaracion';

    protected $fillable = [
        'descripcion', 'numero_meses',
    ];

}
