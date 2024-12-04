<?php

namespace App\Indicador;

use Illuminate\Database\Eloquent\Model;

class Razoncorriente extends Model
{
    
    protected $fillable = [
       
        'activo_corriente',
        'pasivo_corriente',
        'resultado',
        'periodo',
        'user_id',
    ];
}
