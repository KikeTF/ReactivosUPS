<?php

/**
 * NOMBRE DEL ARCHIVO   Period.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      periodos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = "gen_periodos";
    public $timestamps = false;

    protected $fillable =["cod_periodo", "descripcion", "fecha_inicio", "fecha_fin", "estado"];

    public function getFullDescriptionAttribute(){
        return '('.$this->attributes['cod_periodo'] .') '. $this->attributes['descripcion'];
    }

    public function location(){
        return $this->belongsTo('ReactivosUPS\Period');
    }

    public function periodsLocations(){
        return $this->hasMany('ReactivosUPS\PeriodLocation', 'id_periodo');
    }

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'id_periodo');
    }
}
