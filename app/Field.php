<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'rea_campos';
    protected $primaryKey = 'cod_campo';
    public $timestamps = false;

    protected $fillable = ['nombre','descripcion','activo','creado_por','fecha_creacion'];

}
