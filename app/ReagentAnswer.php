<?php

/**
 * NOMBRE DEL ARCHIVO   ReagentAnswer.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      respuestas de reactivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentAnswer extends Model
{
    protected $table = "rea_respuestas";

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    protected $guarded = ['id', "numeral"];

    protected $fillable =["id_reactivo", "descripcion", "argumento", "opcion_correcta", 'creado_por', 'modificado_por'];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent', 'id_reactivo');
    }
}
