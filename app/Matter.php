<?php

/**
 * NOMBRE DEL ARCHIVO   Matter.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      materias.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Matter extends Model
{
    protected $table = "gen_materias";
    public $timestamps = false;

    protected $fillable =["cod_materia", "descripcion", "abreviatura", "estado"];

    public function mattersCareers(){
        return $this->hasMany('ReactivosUPS\MatterCareer', 'id_materia');
    }
}
