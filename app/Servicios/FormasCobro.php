<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class FormasCobro extends Model
{
    protected $table = 'formas_cobro';

    protected $fillable = [
        'descripcion', 'estado'
    ];
}
