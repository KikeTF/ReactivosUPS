<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamComment extends Model
{
    protected $table = "exc_comentarios";
    public $timestamps = false;

    protected $fillable =["id_examen_cab", "comentario", "id_estado_anterior", "id_estado_nuevo",  "creado_por", "fecha_creacion"];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\ExamHeader', 'id_examen_cab');
    }

    public function user(){
        return $this->belongsTo('ReactivosUPS\User', 'creado_por');
    }
}
