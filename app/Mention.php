<?php

/**
 * NOMBRE DEL ARCHIVO   Mention.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      menciones.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    protected $table = "gen_menciones";
    public $timestamps = false;

    protected $fillable =["cod_mencion", "id_carrera", "descripcion", "estado"];

    public function career(){
        return $this->belongsTo('ReactivosUPS\Career');
    }

    public function mattersCareers(){
        return $this->hasMany('ReactivosUPS\MatterCareer', 'id_mencion');
    }

    public function ExamsHeaders(){
        return $this->hasMany('ReactivosUPS\ExamHeader');
    }
}
