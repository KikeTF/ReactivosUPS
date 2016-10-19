<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = "gen_periodos";
    public $timestamps = false;

    protected $fillable =["cod_periodo", "descripcion", "fecha_inicio", "fecha_fin", "estado"];

    public function location(){
        return $this->belongsTo('ReactivosUPS\Period');
    }
}
