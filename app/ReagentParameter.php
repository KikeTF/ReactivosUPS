<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ReagentParameter extends Model
{
    protected $table = "rea_parametros";
    public $timestamps = false;

    protected $fillable =["nro_opciones_resp_min", "nro_opciones_resp_max", "estado"];
}
