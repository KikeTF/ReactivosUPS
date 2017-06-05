<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentState extends Model
{
    protected $table = "rea_estados";
    public $timestamps = false;

    protected $fillable =["descripcion","etiqueta","color","estado",'creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'id_estado');
    }

    public function comments(){
        return $this->hasMany('ReactivosUPS\ReagentComment', 'id_estado_nuevo');
    }

    public function user(){
        return $this->belongsTo('ReactivosUPS\User', 'creado_por');
    }
}
