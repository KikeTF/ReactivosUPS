<?php

/**
 * NOMBRE DEL ARCHIVO   Area.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      areas.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "gen_areas";
    public $timestamps = false;

    protected $fillable = ["cod_area", "descripcion", "estado"];

    public function mattersCareers(){
        return $this->hasMany('ReactivosUPS\MatterCareer', 'id_area');
    }
}
