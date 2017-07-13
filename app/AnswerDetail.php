<?php

/**
 * NOMBRE DEL ARCHIVO   AnswerDetail.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información del
 *                      detalle de resultados de exámenes complexivos
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class AnswerDetail extends Model
{
    protected $table = "exc_resultados_det";
    public $timestamps = false;

    protected $fillable =["id_resultado_cab", "id_examen_det", "id_opcion_resp", "resp_correcta", "estado", "creado_por", "fecha_creacion"];

    public function answerHeader(){
        return $this->belongsTo('ReactivosUPS\AnswerHeader', 'id_resultado_cab');
    }

    public function examDetail(){
        return $this->belongsTo('ReactivosUPS\ExamDetail', 'id_examen_det');
    }

}
