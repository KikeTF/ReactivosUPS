<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    protected $table = "seg_perfiles_usuarios";
    public $timestamps = false;

    protected $fillable =["id_perfil", "id_usuario", "creado_por", "fecha_creacion"];

    public function profile(){
        return $this->belongsTo('ReactivosUPS\Profile', 'id_perfil');
    }

    public function user(){
        return $this->belongsTo('ReactivosUPS\User', 'id_usuario');
    }

    public function optionsUsers(){
        return $this->hasMany('ReactivosUPS\OptionUser', 'id_perfil_usuario');
    }

    public function distributives(){
        return $this->hasMany('ReactivosUPS\Distributive', 'id_perfil_usuario');
    }
}
