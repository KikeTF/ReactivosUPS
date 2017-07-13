<?php

/**
 * NOMBRE DEL ARCHIVO   Option.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      menu de opciones.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = "seg_opciones";
    public $timestamps = false;

    protected $fillable =["descripcion", "id_padre", "ruta", "orden", "estado"];

    public function optionsUsers(){
        return $this->hasMany('ReactivosUPS\OptionUser', 'id_opcion');
    }

    public function optionsProfiles(){
        return $this->hasMany('ReactivosUPS\OptionProfile', 'id_opcion');
    }


}
