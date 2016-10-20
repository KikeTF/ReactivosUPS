<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Profileuser extends Model
{
    protected $table = "seg_perfiles_usuarios";
    public $timestamps = false;

    protected $fillable =["id_perfil", "id_usuario", "estado"];

    public function profile(){
        return $this->belongsTo('ReactivosUPS\Profile');
    }

    public function user(){
        return $this->belongsTo('ReactivosUPS\User');
    }

    public function optionsusers(){
        return $this->hasMany('ReactivosUPS\Optionuser');
    }
}
