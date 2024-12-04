<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContribuyente extends Model
{
    protected $table = 'tipo_contribuyente';

    protected $fillable = [
        'descripcion',
    ];

    public function users (){
        return $this->hasMany('App\User');
    }
}
