<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Reagent extends Model
{
    protected $table = "rea_reactivos";
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $fillable =["id_distributivo", "id_contenido_det", "id_formato", "id_campo", "descripcion", "planteamiento",
                            "id_opcion_correcta", "dificultad", "puntaje", "referencia", "id_estado", "imagen"];

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

    public function questionsConcepts(){
        return $this->hasMany('ReactivosUPS\ReagentQuestionConcept', 'id_reactivo');
    }

    public function questionsProperties(){
        return $this->hasMany('ReactivosUPS\ReagentQuestionProperty', 'id_reactivo');
    }

    public function answers(){
        return $this->hasMany('ReactivosUPS\ReagentAnswer', 'id_reactivo');
    }

    public function comments(){
        return $this->hasMany('ReactivosUPS\ReagentComment', 'id_reactivo');
    }

    public function examsDetails(){
        return $this->hasMany('ReactivosUPS\ExamDetail');
    }

    public function state(){
        return $this->belongsTo('ReactivosUPS\ReagentState', 'id_estado');
    }

    public function scopeFilter($query, $id_distributivo){
        return $query
            ->where('id_distributivo', $id_distributivo);
    }

    public function scopeFilter2($query, $id_distributivo, $id_estado){
        return $query
            ->where('id_distributivo', $id_distributivo)
            ->where('id_estado', $id_estado);
    }
}
