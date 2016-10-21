<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class CareerCampus extends Model
{
    protected $table = "gen_carreras_campus";
    public $timestamps = false;

    protected $fillable =["id_carrera", "id_campus", "id_usr_responsable", "estado"];

    public function career(){
        return $this->belongsTo('ReactivosUPS\Career');
    }

    public function campus(){
        return $this->belongsTo('ReactivosUPS\Campus');
    }

    public function mattersCareers(){
        return $this->hasMany('ReactivosUPS\MatterCareer');
    }
}
