<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Matter extends Model
{
    protected $table = "gen_materias";
    protected $primaryKey = 'cod_materia';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = ['cod_materia'];
    protected $fillable =["descripcion","abreviatura","estado", "creado_por", "fecha_creacion", "estado","modificado_por","fecha_modificacion"];


}
