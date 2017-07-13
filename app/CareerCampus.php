<?php

/**
 * NOMBRE DEL ARCHIVO   CareerCampus.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      carreras por campus.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class CareerCampus extends Model
{
    protected $table = "gen_carreras_campus";
    public $timestamps = false;

    protected $fillable =["id_carrera", "id_campus", "id_usr_responsable", "estado"];

    public function career(){
        return $this->belongsTo('ReactivosUPS\Career', 'id_carrera');
    }

    public function campus(){
        return $this->belongsTo('ReactivosUPS\Campus', 'id_campus');
    }

    public function mattersCareers(){
        return $this->hasMany('ReactivosUPS\MatterCareer', 'id_carrera_campus');
    }

    public function ExamsHeaders(){
        return $this->hasMany('ReactivosUPS\ExamHeader', 'id_carrera_campus');
    }

    public function examsParameters(){
        return $this->hasMany('ReactivosUPS\ExamParameter', 'id_carrera_campus');
    }
}
