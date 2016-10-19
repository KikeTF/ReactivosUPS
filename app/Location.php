<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "gen_sedes";
    public $timestamps = false;

    protected $fillable =["cod_sede","descripcion", "estado"];

    public function periods(){
        return $this->hasMany('ReactivosUPS\Location');
    }

    public function campus(){
        return $this->hasMany('ReactivosUPS\Location');
    }
}
