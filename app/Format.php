<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'rea_formatos';
    public $timestamps = false;

    protected $fillable = ['nombre','descripcion','estado','creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent');
    }
}
