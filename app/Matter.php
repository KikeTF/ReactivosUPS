<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Matter extends Model
{
    protected $table = "gen_materias";
    public $timestamps = false;

    protected $fillable =["cod_materia", "descripcion", "abreviatura", "estado"];

}
