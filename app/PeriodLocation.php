<?php

/**
 * NOMBRE DEL ARCHIVO   PeriodLocation.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      periodos por sedes.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class PeriodLocation extends Model
{
    protected $table = "gen_periodos_sedes";
    public $timestamps = false;

    protected $fillable =["id_periodo", "id_sede", "estado"];

    public function period(){
        return $this->belongsTo('ReactivosUPS\Period', 'id_periodo');
    }

    public function location(){
        return $this->belongsTo('ReactivosUPS\Location', 'id_sede');
    }

    public function distributives(){
        return $this->hasMany('ReactivosUPS\Distributive', 'id_distributivo');
    }

    public function ExamsHeaders(){
        return $this->hasMany('ReactivosUPS\ExamHeader', 'id_periodo_sede');
    }

    public function ExamsPeriods(){
        return $this->hasMany('ReactivosUPS\ExamPeriod', 'id_periodo_sede');
    }
}
