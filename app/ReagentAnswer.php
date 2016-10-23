<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentAnswer extends Model
{
    protected $table = "rea_opciones_resp";
    public $timestamps = false;

    protected $fillable =["id_reactivo", "descripcion", "argumento", "estado"];

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent');
    }
}
