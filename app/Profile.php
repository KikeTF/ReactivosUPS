<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "seg_perfiles";
    public $timestamps = false;

    protected $fillable =["id", "cod_perfil", "nombre", "descripcion", "estado"];

    public function profilesUsers(){
        return $this->hasMany('ReactivosUPS\ProfileUser', 'id_perfil');
    }

    public function optionsProfiles(){
        return $this->hasMany('ReactivosUPS\OptionProfile');
    }
}
