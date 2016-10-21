<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class PeriodLocation extends Model
{
    protected $table = "gen_periodos_sedes";
    public $timestamps = false;

    protected $fillable =["id_periodo", "id_sede", "estado"];

    public function period(){
        return $this->belongsTo('ReactivosUPS\Period');
    }

    public function location(){
        return $this->belongsTo('ReactivosUPS\Location');
    }
}
