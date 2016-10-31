<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class MatterCareer extends Model
{
    protected $table = "gen_materias_carreras";
    public $timestamps = false;

    protected $fillable =["id_carrera_campus", "id_materia", "id_area", "id_mencion", "nivel", "tipo",
                        "nro_reactivos_mat", "aplica_examen", "nro_reactivos_exam", "id_usr_responsable",
                        "estado", "creado_por", "fecha_creacion", "modificado_por", "fecha_modificacion"];

    public function careerCampus(){
        return $this->belongsTo('ReactivosUPS\CareerCampus');
    }

    public function matter(){
        return $this->belongsTo('ReactivosUPS\Matter');
    }

    public function area(){
        return $this->belongsTo('ReactivosUPS\Area');
    }

    public function mention(){
        return $this->belongsTo('ReactivosUPS\Mention');
    }

    public function contentsHeaders(){
        return $this->hasMany('ReactivosUPS\ContentHeader');
    }

    public function distributives(){
        return $this->hasMany('ReactivosUPS\Distributive');
    }

    public function scopeFilter($query, $id_carrera_campus, $id_mencion, $id_area){
        return $query
            ->where('id_carrera_campus', $id_carrera_campus)
            ->where('id_mencion', $id_mencion)
            ->where('id_area', $id_area);
    }

    public function scopeFilter2($query, $id_carrera_campus, $id_mencion){
        return $query
            ->where('id_carrera_campus', $id_carrera_campus)
            ->where('id_mencion', $id_mencion);
    }

}
