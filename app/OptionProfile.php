<?php

/**
 * NOMBRE DEL ARCHIVO   OptionProfile.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      menu de opciones por perfil.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class OptionProfile extends Model
{
    protected $table = "seg_opciones_perfiles";
    public $timestamps = false;

    protected $fillable =["id_opcion", "id_perfil","creado_por","fecha_creacion"];

    public function option(){
        return $this->belongsTo('ReactivosUPS\Option', 'id_opcion');
    }

    public function profile(){
        return $this->belongsTo('ReactivosUPS\Profile', 'id_perfil');
    }
}
