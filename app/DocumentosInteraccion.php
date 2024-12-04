<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentosInteraccion extends Model
{
    protected $fillable = [
        'nombre',
        'user_id',
        'interaccion_id',
        'url_archivo',
        'documento_interaccion',
    ];

    public function Interaccion()
    {
        return $this->belongsTo('App\Interaccion');
    }


}
