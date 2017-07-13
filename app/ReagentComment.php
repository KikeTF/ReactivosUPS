<?php

/**
 * NOMBRE DEL ARCHIVO   ReagentComment.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      observaciones de reactivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentComment extends Model
{
    protected $table = "rea_comentarios";
    public $timestamps = false;

    protected $fillable =["id_reactivo", "comentario", "id_estado_anterior", "id_estado_nuevo",  "creado_por", "fecha_creacion"];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent', 'id_reactivo');
    }

    public function user(){
        return $this->belongsTo('ReactivosUPS\User', 'creado_por');
    }

    public function state(){
        return $this->belongsTo('ReactivosUPS\ReagentState', 'id_estado_nuevo');
    }
}
