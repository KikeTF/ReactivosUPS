<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = "gen_carreras";
    public $timestamps = false;

    protected $fillable =["cod_carrera", "descripcion", "estado"];

    public function mentions(){
        return $this->hasMany('ReactivosUPS\Mention');
    }

    public function careersCampuses(){
        return $this->hasMany('ReactivosUPS\CareerCampus', 'id_carrera');
    }

    public function careersProfiles(){
        return $this->hasMany('ReactivosUPS\CareerProfile', 'id_carrera');
    }
}
