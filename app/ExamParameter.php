<?php

/**
 * NOMBRE DEL ARCHIVO   ExamParameter.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      parámetros de exámenes complexivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamParameter extends Model
{
    protected $table = "exc_parametros";
    public $timestamps = false;

    protected $fillable =["id_carrera_campus", "duracion_examen", "id_examen_real", "id_examen_test", "editar_respuestas", "instrucciones", "estado"];

    public function answersHeaders(){
        return $this->hasMany('ReactivosUPS\ExamParameter', 'id_parametro');
    }

    public function careerCampus(){
        return $this->belongsTo('ReactivosUPS\CareerCampus', 'id_carrera_campus');
    }

    public function user(){
        return $this->belongsTo('ReactivosUPS\User', 'creado_por');
    }
}
