<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "gen_areas";
    public $timestamps = false;

    protected $fillable =["cod_area", "descripcion", "estado"];
}
