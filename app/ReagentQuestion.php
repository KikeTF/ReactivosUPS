<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentQuestion extends Model
{
    protected $table = "rea_opciones_preg";
    public $timestamps = false;

    protected $fillable =["id_reactivo", "secuencia", "concepto", "propiedad", "estado"];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent', 'id_reactivo');
    }
}
