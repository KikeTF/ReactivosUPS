<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class OptionProfile extends Model
{
    protected $table = "seg_opciones_perfiles";
    public $timestamps = false;

    protected $fillable =["id_opcion", "id_perfil"];

    public function option(){
        return $this->belongsTo('ReactivosUPS\Option', 'id_opcion');
    }

    public function profile(){
        return $this->belongsTo('ReactivosUPS\Profile', 'id_perfil');
    }
}
