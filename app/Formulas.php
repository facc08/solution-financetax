<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formulas extends Model
{
   protected $table = "formulas";
        protected $fillable = [
        "shop_id",
        "descripcion",
        "formula",
        "observacion",
        "estado",
    ];
}
