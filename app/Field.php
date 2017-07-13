<?php

/**
 * NOMBRE DEL ARCHIVO   Field.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      campos de conocimiento de reactivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'rea_campos';
    public $timestamps = false;

    protected $fillable = ['nombre','descripcion','estado','creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'id_campo');
    }
}
