<?php

/**
 * NOMBRE DEL ARCHIVO   OptionUser.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      menu de opciones por usuario.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class OptionUser extends Model
{
    protected $table = "seg_opciones_usuarios";
    public $timestamps = false;

    protected $fillable =["id_opcion", "id_perfil_usuario", "estado"];

    public function option(){
        return $this->belongsTo('ReactivosUPS\Option', 'id_opcion');
    }

    public function profileUser(){
        return $this->belongsTo('ReactivosUPS\ProfileUser', 'id_perfil_usuario');
    }
}
