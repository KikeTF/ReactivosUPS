<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentQuestion extends Model
{
    protected $table = "rea_opciones_preg";
    public $timestamps = false;

    protected $fillable =["id_reactivo", "secuencia", "concepto", "propiedad", "estado",'creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent', 'id_reactivo');
    }
}
