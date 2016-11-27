<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentComment extends Model
{
    protected $table = "rea_comentarios";
    public $timestamps = false;

    protected $fillable =["id_reactivo", "comentario", "id_estado_anterior", "id_estado_nuevo",  "creado_por", "fecha_creacion"];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent', 'id_reactivo');
    }
}
