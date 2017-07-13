<?php

/**
 * NOMBRE DEL ARCHIVO   ExamHeader.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      exámenes complexivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamHeader extends Model
{
    protected $table = "exc_examen_cab";
    public $timestamps = false;

    protected $fillable =["id_periodo_sede", "id_carrera_campus", "id_mencion", "descripcion", "cantidad_reactivos", "fecha_activacion",
        "es_prueba", "resolucion", "id_estado", "id_sede", "id_periodo", "id_campus", "id_carrera"];

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
        return $this->hasMany('ReactivosUPS\AnswerHeader', 'id_examen_cab');
    }

    public function examPeriods(){
        return $this->hasMany('ReactivosUPS\ExamPeriod', 'id_examen_cab');
    }

    public function comments(){
        return $this->hasMany('ReactivosUPS\ExamComment', 'id_examen_cab');
    }

    public function state(){
        return $this->belongsTo('ReactivosUPS\ExamState', 'id_estado');
    }
}
