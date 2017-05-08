<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = "gen_periodos";
    public $timestamps = false;

    protected $fillable =["cod_periodo", "descripcion", "fecha_inicio", "fecha_fin", "estado"];

    public function getFullDescriptionAttribute(){
        return '('.$this->attributes['cod_periodo'] .') '. $this->attributes['descripcion'];
    }

    public function location(){
        return $this->belongsTo('ReactivosUPS\Period');
    }

    public function periodsLocations(){
        return $this->hasMany('ReactivosUPS\PeriodLocation', 'id_periodo');
    }

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'id_periodo');
    }
}
