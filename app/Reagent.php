<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Reagent extends Model
{
    protected $table = "rea_reactivos";
    public $timestamps = false;

    protected $fillable =["id_distributivo", "id_contenido_det", "id_formato", "id_campo", "descripcion", "planteamiento",
        "pregunta_opciones", "id_opcion_correcta", "dificultad", "puntaje", "referencia", "estado"];

    public function distributive(){
        return $this->belongsTo('ReactivosUPS\Distributive');
    }

    public function contentDetail(){
        return $this->belongsTo('ReactivosUPS\ContentDetail');
    }

    public function format(){
        return $this->belongsTo('ReactivosUPS\Format');
    }

    public function campus(){
        return $this->belongsTo('ReactivosUPS\Campus');
    }
}
