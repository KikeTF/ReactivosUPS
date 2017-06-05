<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "gen_notificaciones";
    public $timestamps = false;

    protected $fillable =["id_usuario", "fecha", "tipo", "estado", "veces"];

    public function users(){
        return $this->hasMany('ReactivosUPS\User', 'id_usuario');
    }
}
