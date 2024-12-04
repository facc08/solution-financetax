<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Sustento extends Model
{
	protected $table = 'sustentos_tributarios';

    protected $fillable =[
        'descripcion',
        'codigo',
        'estado',
    ];
}
