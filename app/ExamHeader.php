<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamHeader extends Model
{
    protected $table = "exc_examen_cab";
    public $timestamps = false;

    protected $fillable =["id_periodo_sede", "id_mencion", "descripcion", "cantidad_reactivos", "fecha_activacion",
        "es_prueba", "estado"];

    public function periodLocation(){
        return $this->belongsTo('ReactivosUPS\PeriodLocation');
    }

    public function mention(){
        return $this->belongsTo('ReactivosUPS\Mention');
    }

    public function ExamsDetails(){
        return $this->hasMany('ReactivosUPS\ExamDetail');
    }
}
