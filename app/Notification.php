<?php

/**
 * NOMBRE DEL ARCHIVO   Notification.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      notificaciones.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "gen_notificaciones";
    public $timestamps = false;

    protected $fillable =["id_usuario", "fecha", "tipo", "estado", "veces"];

    public function user(){
        return $this->belongsTo('ReactivosUPS\User', 'id_usuario');
    }
}
