<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = "seg_opciones";
    public $timestamps = false;

    protected $fillable =["descripcion", "id_padre", "ruta", "estado"];

    public function optionsusers(){
        return $this->hasMany('ReactivosUPS\Optionuser');
    }

    public function optionsprofiles(){
        return $this->hasMany('ReactivosUPS\Optionprofile');
    }


}
