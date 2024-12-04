<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Subservice extends Model
{
    protected $fillable =[

        'nombre',
        'descripcion',
        'slug',
       ];

       public function documento()
    {
        return $this->morphOne('App\Document', 'documentable');
    }


    public function servicio(){
        return $this->belongsTo('App\Servicios\Service');
    }
    

    //public function planes(){
    //    return $this->hasMany('App\Servicios\Plan');
    //}



}
