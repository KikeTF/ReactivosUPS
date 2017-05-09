<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class AnswerDetail extends Model
{
    protected $table = "exc_resultados_det";
    public $timestamps = false;

    protected $fillable =["id_resultado_cab", "id_examen_det", "id_opcion_resp", "resp_correcta", "estado"];

    public function answerHeader(){
        return $this->belongsTo('ReactivosUPS\AnswerHeader', 'id_resultado_cab');
    }

    public function examDetail(){
        return $this->belongsTo('ReactivosUPS\ExamDetail', 'id_examen_det');
    }

}
