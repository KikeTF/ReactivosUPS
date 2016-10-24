<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $table = "gen_campus";
    public $timestamps = false;

    protected $fillable =["cod_campus", "id_sede", "descripcion", "estado"];

    public function location(){
        return $this->belongsTo('ReactivosUPS\Location');
    }

    public function careersCampuses(){
        return $this->hasMany('ReactivosUPS\CareerCampus', 'id_campus');
    }

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent');
    }
}
