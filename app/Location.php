<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "gen_sedes";
    public $timestamps = false;

    protected $fillable =["cod_sede","descripcion", "estado"];

    public function periods(){
        return $this->hasMany('ReactivosUPS\Period');
    }

    public function campus(){
        return $this->hasMany('ReactivosUPS\Campus');
    }

    public function periodsLocations(){
        return $this->hasMany('ReactivosUPS\PeriodLocation');
    }
}
