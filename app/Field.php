<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'rea_campos';
    protected $primaryKey = 'cod_campo';
    public $timestamps = false;

    protected $guarded = ['cod_campo'];
    protected $fillable = ['nombre','descripcion','estado','creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

}
