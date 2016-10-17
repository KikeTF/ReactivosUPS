<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = "gen_periodos";
    protected $primaryKey = 'cod_periodo';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = ['cod_periodo'];
    protected $fillable =["cod_sede", "descripcion","fecha_inicio","fecha_fin", "estado"];

    public function location(){
        return $this->belongsTo('ReactivosUPS\Period');
    }
}
