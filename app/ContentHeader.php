<?php

/**
 * NOMBRE DEL ARCHIVO   ContentHeader.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      contenidos de materias.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ContentHeader extends Model
{
    protected $table = "gen_contenido_cab";
    public $timestamps = false;

    protected $fillable =["cod_contenido_cab", "id_materia_carrera", "estado"];

    public function matterCareer(){
        return $this->belongsTo('ReactivosUPS\MatterCareer', 'id_materia_carrera');
    }

    public function contentsDetails(){
        return $this->hasMany('ReactivosUPS\ContentDetail', 'id_contenido_cab');
    }
}
