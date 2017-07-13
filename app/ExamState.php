<?php

/**
 * NOMBRE DEL ARCHIVO   ExamState.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      estados de exámenes complexivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamState extends Model
{
    protected $table = "exc_estados";
    public $timestamps = false;

    protected $fillable =["descripcion","etiqueta","estado",'creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function examsHeaders(){
        return $this->hasMany('ReactivosUPS\ExamHeader', 'id_estado');
    }
}
