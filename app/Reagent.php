<?php

/**
 * NOMBRE DEL ARCHIVO   Reagent.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      reactivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Reagent extends Model
{
    protected $table = "rea_reactivos";
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $fillable =["id_distributivo", "id_contenido_det", "id_formato", "id_campo", "descripcion", "planteamiento",
                            "id_opcion_correcta", "dificultad", "puntaje", "referencia", "id_estado", "imagen",
                            "id_materia", "id_carrera", "id_campus", "id_periodo", "id_sede"];

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
        return $this->hasMany('ReactivosUPS\ExamDetail', 'id_reactivo');
    }

    public function state(){
        return $this->belongsTo('ReactivosUPS\ReagentState', 'id_estado');
    }

    public function user(){
        return $this->belongsTo('ReactivosUPS\User', 'creado_por');
    }

    public function updaterUser(){
        return $this->belongsTo('ReactivosUPS\User', 'modificado_por');
    }

    public function period(){
        return $this->belongsTo('ReactivosUPS\Period', 'id_periodo');
    }

    public function scopeFilter($query, $idDist){
        return $query
            ->whereIn('id_distributivo', $idDist);
    }

    public function scopeFilter2($query, $id_distributivo, $id_estado){
        return $query
            ->where('id_distributivo', $id_distributivo)
            ->where('id_estado', $id_estado);
    }
}
