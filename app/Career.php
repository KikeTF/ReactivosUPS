<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = "gen_carrera";
    public $timestamps = false;

    protected $fillable =["cod_carrera", "descripcion", "estado"];

    public function mentions(){
        return $this->hasMany('ReactivosUPS\Career');
    }
}
