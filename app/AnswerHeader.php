<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class AnswerHeader extends Model
{
    protected $table = "exc_resultados_cab";
    public $timestamps = false;

    protected $fillable =["id_examen_cab", "id_usr_estudiante", "reactivos_acertados", "reactivos_errados", "estado"];

    public function examHeader(){
        return $this->belongsTo('ReactivosUPS\ExamHeader');
    }

    public function answersDetails(){
        return $this->hasMany('ReactivosUPS\AnswerDetail');
    }

}
