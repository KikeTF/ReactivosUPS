<?php

/**
 * NOMBRE DEL ARCHIVO   AnswerHeader.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      resultados de exámenes complexivos
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class AnswerHeader extends Model
{
    protected $table = "exc_resultados_cab";
    public $timestamps = false;

    protected $fillable =["id_examen_cab", "id_mencion", "id_parametro", "cedula", "nombres", "apellidos", "correo",
        "fecha_inicio", "fecha_fin", "reactivos_acertados", "reactivos_errados", "estado"];

    public function examHeader(){
        return $this->belongsTo('ReactivosUPS\ExamHeader', 'id_examen_cab');
    }

    public function parameter(){
        return $this->belongsTo('ReactivosUPS\ExamParameter', 'id_parametro');
    }

    public function answersDetails(){
        return $this->hasMany('ReactivosUPS\AnswerDetail', 'id_resultado_cab');
    }

}
