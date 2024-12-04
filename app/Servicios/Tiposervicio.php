<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Traits\HasRoles;

class Tiposervicio extends Model
{
    use HasRoles;
    
    protected $guard_name = 'web';

    protected $fillable = [
        'nombre'
    ];


    public function servicios(){
        return $this->hasMany('App\Servicios\Service');
    }

}
