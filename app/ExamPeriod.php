<?php

/**
 * NOMBRE DEL ARCHIVO   ExamPeriod.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      periodos de exámenes complexivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamPeriod extends Model
{
    protected $table = "exc_periodos_examen";
    public $timestamps = false;

    protected $fillable =["id_examen_cab", "id_periodo_sede"];

    public function examHeader(){
        return $this->belongsTo('ReactivosUPS\ExamHeader', 'id_examen_cab');
    }

    public function periodLocation(){
        return $this->belongsTo('ReactivosUPS\PeriodLocation', 'id_periodo_sede');
    }

}
