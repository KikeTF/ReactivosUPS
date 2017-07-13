<?php

/**
 * NOMBRE DEL ARCHIVO   CareerProfile.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      carreras por perfil.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class CareerProfile extends Model
{
    protected $table = "seg_carreras_perfiles";
    public $timestamps = false;

    protected $fillable =["id_carrera", "id_perfil"];

    public function career(){
        return $this->belongsTo('ReactivosUPS\Career', 'id_carrera');
    }

    public function profile(){
        return $this->belongsTo('ReactivosUPS\Profile', 'id_perfil');
    }
}
