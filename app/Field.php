<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'rea_campos';
    protected $primaryKey = 'COD_CAMPO';
    public $timestamps = false;

    protected $guarded = ['cod_campo'];
    protected $fillable = ['nombre','descripcion','activo','creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

}
