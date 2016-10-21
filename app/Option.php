<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = "seg_opciones";
    public $timestamps = false;

    protected $fillable =["descripcion", "id_padre", "ruta", "estado"];

    public function optionsUsers(){
        return $this->hasMany('ReactivosUPS\OptionUser');
    }

    public function optionsProfiles(){
        return $this->hasMany('ReactivosUPS\OptionProfile');
    }


}
