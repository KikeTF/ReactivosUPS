<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'rea_formatos';
    protected $primaryKey = 'cod_formato';
    public $timestamps = false;

    protected $guarded = ['cod_formato'];
    protected $fillable = ['nombre','descripcion','activo','creado_por','fecha_creacion','modificado_por','fecha_modificacion'];
}
