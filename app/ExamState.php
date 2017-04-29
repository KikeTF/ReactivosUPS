<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ExamState extends Model
{
    protected $table = "exc_estados";
    public $timestamps = false;

    protected $fillable =["descripcion","etiqueta","estado",'creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function examsHeaders(){
        return $this->hasMany('ReactivosUPS\ExamHeader', 'id_estado');
    }
}
