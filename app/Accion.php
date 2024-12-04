<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    protected $table = 'acciones';

    protected $fillable = [
        'descripcion', 'ruta',
    ];
}
