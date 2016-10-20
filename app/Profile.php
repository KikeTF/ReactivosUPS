<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "seg_perfiles";
    public $timestamps = false;

    protected $fillable =["cod_perfil", "descripcion", "estado"];

    public function profilesusers(){
        return $this->hasMany('ReactivosUPS\Profileuser');
    }

    public function optionsprofiles(){
        return $this->hasMany('ReactivosUPS\Optionprofile');
    }
}
