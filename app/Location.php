<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "gen_sedes";
    public $timestamps = false;

    protected $fillable =["cod_sede","descripcion", "estado"];

    public function users(){
        return $this->hasMany('ReactivosUPS\User', 'id_sede');
    }

    public function periods(){
        return $this->hasMany('ReactivosUPS\Period', 'id_periodo');
    }

    public function campuses(){
        return $this->hasMany('ReactivosUPS\Campus', 'id_campus');
    }

    public function periodsLocations(){
        return $this->hasMany('ReactivosUPS\PeriodLocation', 'id_periodo_sede');
    }
}
