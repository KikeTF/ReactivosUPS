<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Reagent extends Model
{
    protected $table = "rea_reactivos";
    public $timestamps = false;

    protected $fillable =["id_distributivo", "id_contenido_det", "id_formato", "id_campo", "descripcion", "planteamiento",
                            "id_opcion_correcta", "dificultad", "puntaje", "referencia", "estado"];

    public function distributive(){
        return $this->belongsTo('ReactivosUPS\Distributive', 'id_distributivo');
    }

    public function contentDetail(){
        return $this->belongsTo('ReactivosUPS\ContentDetail', 'id_contenido_det');
    }

    public function format(){
        return $this->belongsTo('ReactivosUPS\Format', 'id_formato');
    }

    public function field(){
        return $this->belongsTo('ReactivosUPS\Field', 'id_campo');
    }

    public function reagentsQuestions(){
        return $this->hasMany('ReactivosUPS\ReagentQuestion', 'id_reactivo');
    }

    public function reagentsAnswers(){
        return $this->hasMany('ReactivosUPS\ReagentAnswer', 'id_reactivo');
    }

    public function ExamsDetails(){
        return $this->hasMany('ReactivosUPS\ExamDetail');
    }

    public function scopeFilter($query, $id_distributivo){
        return $query
            ->where('id_distributivo', $id_distributivo);
    }
}
