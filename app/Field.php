<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'rea_campos';
    public $timestamps = false;

    protected $fillable = ['nombre','descripcion','estado','creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'id_campo');
    }
}
