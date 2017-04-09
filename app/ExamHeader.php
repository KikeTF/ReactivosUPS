<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamHeader extends Model
{
    protected $table = "exc_examen_cab";
    public $timestamps = false;

    protected $fillable =["id_periodo_sede", "id_mencion", "descripcion", "cantidad_reactivos", "fecha_activacion",
        "es_prueba", "estado", "id_sede", "id_periodo", "id_campus", "id_carrera"];

    public function periodLocation(){
        return $this->belongsTo('ReactivosUPS\PeriodLocation', 'id_periodo_sede');
    }

    public function careerCampus(){
        return $this->belongsTo('ReactivosUPS\CareerCampus', 'id_carrera_campus');
    }

    public function examsDetails(){
        return $this->hasMany('ReactivosUPS\ExamDetail', 'id_examen_cab');
    }

    public function answersHeaders(){
        return $this->hasMany('ReactivosUPS\AnswerHeader');
    }
}
