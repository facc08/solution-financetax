<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Tipoplan extends Model
{



    public function planes(){
        return $this->hasMany('App\Servicios\Plan');
    }

}
