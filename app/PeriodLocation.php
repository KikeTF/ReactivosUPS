<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class PeriodLocation extends Model
{
    protected $table = "gen_periodos_sedes";
    public $timestamps = false;

    protected $fillable =["id_periodo", "id_sede", "estado"];

    public function period(){
        return $this->belongsTo('ReactivosUPS\Period', 'id_periodo');
    }

    public function location(){
        return $this->belongsTo('ReactivosUPS\Location', 'id_sede');
    }

    public function distributives(){
        return $this->hasMany('ReactivosUPS\Distributive');
    }

    public function ExamsHeaders(){
        return $this->hasMany('ReactivosUPS\ExamHeader', 'id_periodo_sede');
    }

    public function ExamsPeriods(){
        return $this->hasMany('ReactivosUPS\ExamPeriod', 'id_periodo_sede');
    }
}
