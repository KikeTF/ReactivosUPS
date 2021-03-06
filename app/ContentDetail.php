<?php

/**
 * NOMBRE DEL ARCHIVO   ContentDetail.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      detalle de contenidos de materias.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ContentDetail extends Model
{
    protected $table = "gen_contenido_det";
    public $timestamps = false;

    protected $fillable =["id_contenido_cab", "cod_contenido_det", "cod_contenido_cab", "capitulo", "tema", "estado"];

    public function getContentDescriptionAttribute(){
        return $this->attributes['capitulo'] .'. '. $this->attributes['tema'];
    }

    public function contentHeader(){
        return $this->belongsTo('ReactivosUPS\ContentHeader', 'id_contenido_cab');
    }

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'id_contenido_det');
    }

}
