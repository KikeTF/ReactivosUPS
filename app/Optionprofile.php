<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Optionprofile extends Model
{
    protected $table = "seg_opciones_perfiles";
    public $timestamps = false;

    protected $fillable =["id_opcion", "id_perfil", "estado"];

    public function option(){
        return $this->belongsTo('ReactivosUPS\Option');
    }

    public function profile(){
        return $this->belongsTo('ReactivosUPS\Profile');
    }
}
