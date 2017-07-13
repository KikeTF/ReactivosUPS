<?php

/**
 * NOMBRE DEL ARCHIVO   Format.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      formatos de reactivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'rea_formatos';
    public $timestamps = false;

    protected $fillable = ['nombre','descripcion','opciones_resp_min','opciones_resp_max','opciones_pregunta',
                            'concepto_propiedad','opciones_preg_min','opciones_preg_max','opciones_prop_min','opciones_prop_max',
                            'imagenes','estado','creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'id_formato');
    }
}
