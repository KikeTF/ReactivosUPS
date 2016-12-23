<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentAnswer extends Model
{
    protected $table = "rea_opciones_resp";
    public $timestamps = false;

    protected $fillable =["id_reactivo", "secuencia", "descripcion", "argumento", "estado", 'creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent', 'id_reactivo');
    }
}
