<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guard_name = 'web';

    protected $fillable =[

        'nombre',
        'descripcion',
        'slug',
       ];

       
       public function documento()
    {
        return $this->morphOne('App\Document', 'documentable');
    }


    public function tipo(){
        return $this->belongsTo('App\Servicios\Tiposervicio');
    }

    public function subservicio(){
        return $this->hasMany('App\Servicios\Subservice');
    }
}
