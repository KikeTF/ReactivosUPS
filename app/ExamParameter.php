<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamParameter extends Model
{
    protected $table = "exc_parametros";
    public $timestamps = false;

    protected $fillable =["nro_preguntas", "duracion_examen", "cod_examen_act", "editar_respuestas", "estado"];
}
