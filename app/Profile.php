<?php

/**
 * NOMBRE DEL ARCHIVO   Profile.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      perfiles.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "seg_perfiles";
    public $timestamps = false;

    protected $fillable =["cod_perfil", "nombre", "descripcion", "aprueba_reactivo", "aprueba_reactivos_masivo", "aprueba_examen", "restablece_password", "dashboard", "estado"];

    public function profilesUsers(){
        return $this->hasMany('ReactivosUPS\ProfileUser', 'id_perfil');
    }

    public function optionsProfiles(){
        return $this->hasMany('ReactivosUPS\OptionProfile', 'id_perfil');
    }

    public function careersProfiles(){
        return $this->hasMany('ReactivosUPS\CareerProfile', 'id_perfil');
    }
}
