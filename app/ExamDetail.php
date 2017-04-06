<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamDetail extends Model
{
    protected $table = "exc_examen_det";
    public $timestamps = false;

    protected $fillable =["id_examen_cab", "id_reactivo", "estado"];

    public function examHeader(){
        return $this->belongsTo('ReactivosUPS\ExamHeader', 'id_examen_cab');
    }

    public function reagent(){
        return $this->belongsTo('ReactivosUPS\Reagent', 'id_reactivo');
    }

    public function answersDetails(){
        return $this->hasMany('ReactivosUPS\AnswerDetail');
    }
}
