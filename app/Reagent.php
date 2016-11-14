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
        return $this->belongsTo('ReactivosUPS\Distributive', 'id_distributivo');
    }

    public function contentDetail(){
        return $this->belongsTo('ReactivosUPS\ContentDetail', 'id_contenido_det');
    }

    public function format(){
        return $this->belongsTo('ReactivosUPS\Format', 'id_formato');
    }

    public function campus(){
        return $this->belongsTo('ReactivosUPS\Campus', 'id_campo');
    }

    public function reagentsQuestions(){
        return $this->hasMany('ReactivosUPS\ReagentQuestion');
    }

    public function reagentsAnswers(){
        return $this->hasMany('ReactivosUPS\ReagentAnswer');
    }

    public function ExamsDetails(){
        return $this->hasMany('ReactivosUPS\ExamDetail');
    }
}
