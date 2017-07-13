<?php

/**
 * NOMBRE DEL ARCHIVO   Distributive.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      distributivo.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Distributive extends Model
{
    protected $table = "gen_distributivo";
    public $timestamps = false;

    protected $fillable =["id_periodo_sede", "id_materia_carrera", "id_perfil_usuario", "estado"];

    public function periodLocation(){
        return $this->belongsTo('ReactivosUPS\PeriodLocation');
    }

    public function matterCareer(){
        return $this->belongsTo('ReactivosUPS\MatterCareer', 'id_materia_carrera');
    }

    public function profileUser(){
        return $this->belongsTo('ReactivosUPS\ProfileUser', 'id_perfil_usuario');
    }

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'id_distributivo');
    }
}
