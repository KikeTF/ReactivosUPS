<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class AnswerHeader extends Model
{
    protected $table = "exc_resultados_cab";
    public $timestamps = false;

    protected $fillable =["id_examen_cab", "cedula", "nombres", "apellidos", "correo_institucional", "reactivos_acertados", "reactivos_errados", "estado"];

    public function examHeader(){
        return $this->belongsTo('ReactivosUPS\ExamHeader', 'id_examen_cab');
    }

    public function answersDetails(){
        return $this->hasMany('ReactivosUPS\AnswerDetail', 'id_resultado_cab');
    }

}
