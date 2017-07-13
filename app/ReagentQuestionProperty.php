<?php

/**
 * NOMBRE DEL ARCHIVO   ReagentQuestionProperty.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      propiedades de preguntas de reactivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentQuestionProperty extends Model
{
    protected $table = "rea_preguntas_prop";
    //public $timestamps = false;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    protected $guarded = ['id', "literal"];

    protected $fillable =["id_reactivo", "propiedad", 'creado_por','modificado_por'];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent', 'id_reactivo');
    }
}
