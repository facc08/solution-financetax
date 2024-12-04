<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // se usa para utilizar los archivos de vendor de spaty


class User extends Authenticatable
{
    
    use Notifiable,HasRoles ;
    // para usar los roles con el spaty 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','genero','city_id','telefono',
        'domicilio','fecha_n','cedula','edad', 'tipo_contribuyente_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function posts (){
        return $this->hasMany('App\Post');
    }

    public function city (){
        return $this->belongsTo('App\City');
    }

    public function tipo_contribuyente (){
        return $this->belongsTo('App\TipoContribuyente');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'roles');
    }
}
