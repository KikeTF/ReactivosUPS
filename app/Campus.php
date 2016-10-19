<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $table = "gen_campus";
    public $timestamps = false;

    protected $fillable =["cod_campus", "cod_sede", "descripcion", "estado"];

    public function location(){
        return $this->belongsTo('ReactivosUPS\Campus');
    }
}
