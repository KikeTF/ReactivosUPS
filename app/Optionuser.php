<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Optionuser extends Model
{
    protected $table = "seg_opciones_usuarios";
    public $timestamps = false;

    protected $fillable =["id_opcion", "id_perfil_usuario", "estado"];

    public function option(){
        return $this->belongsTo('ReactivosUPS\Option');
    }

    public function profileuser(){
        return $this->belongsTo('ReactivosUPS\Profileuser');
    }
}
