<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interaccion extends Model
{
   protected $table = "interaccions";
        protected $fillable = [
        "tipo",
        "detalle",
        "observacion",
        'fecha',
    ];


    // public function documento()
    // {
    //     return $this->morphOne('App\DocumentosInteraccion', 'documentableinteraccion');
    // }



    public function docs(){
        return $this->hasMany('App\DocumentosInteraccion');
    }

    public function Shop (){
        return $this->hasMany('App\Shop');
    }
}
