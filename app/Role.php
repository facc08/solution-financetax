<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";

    protected $fillable =[

        'name',
        'guard_name',
       ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
