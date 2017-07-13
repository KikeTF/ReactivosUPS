<?php

/**
 * NOMBRE DEL ARCHIVO   MatterCareer.php
 *
 * TIPO                 Modelo
 *
 * DESCRIPCIÓN          Gestiona el acceso a la información de
 *                      materias por carrera.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class MatterCareer extends Model
{
    protected $table = "gen_materias_carreras";
    public $timestamps = false;

    protected $fillable =["id_carrera_campus", "id_materia", "id_area", "id_mencion", "nivel", "tipo",
                        "nro_reactivos_mat", "aplica_examen", "nro_reactivos_exam", "id_usr_responsable",
                        "estado", "archivo_contenido", "creado_por", "fecha_creacion", "modificado_por", "fecha_modificacion"];

    public function careerCampus(){
        return $this->belongsTo('ReactivosUPS\CareerCampus', 'id_carrera_campus');
    }

    public function matter(){
        return $this->belongsTo('ReactivosUPS\Matter', 'id_materia');
    }

    public function area(){
        return $this->belongsTo('ReactivosUPS\Area', 'id_area');
    }

    public function mention(){
        return $this->belongsTo('ReactivosUPS\Mention', 'id_mencion');
    }

    public function contentsHeaders(){
        return $this->hasMany('ReactivosUPS\ContentHeader', 'id_materia_carrera');
    }

    public function distributives(){
        return $this->hasMany('ReactivosUPS\Distributive', 'id_materia_carrera');
    }

    public function scopeFilter($query, $id_carrera_campus, $id_mencion, $id_area){
        if($id_carrera_campus > 0 )
            $query = $query->where('id_carrera_campus', $id_carrera_campus);

        if($id_mencion > 0 )
            $query = $query->where('id_mencion', $id_mencion);

        if($id_area > 0 )
            $query = $query->where('id_area', $id_area);
        
        return $query->where('estado', '!=', 'E');
    }

    public function getMatterDescriptionAttribute(){
        return $this->matter->descripcion;
    }
}
