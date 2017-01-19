<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentAnswer extends Model
{
    protected $table = "rea_respuestas";
    //public $timestamps = false;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    protected $guarded = ['id', "numeral"];

    protected $fillable =["id_reactivo", "descripcion", "argumento", "opcion_correcta", 'creado_por', 'modificado_por'];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent', 'id_reactivo');
    }
}
