<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioPermisos extends Model
{
    protected $table = 'servicio_permisos';

    protected $fillable = [
        'plan_id', 'permission_id',
    ];
}
