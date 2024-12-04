<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'nombre', 'extension', 'archivo' ,
    ];
    public function documentable()
    {
        return $this->morphTo();
    }
}
