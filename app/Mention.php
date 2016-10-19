<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    protected $table = "gen_menciones";
    public $timestamps = false;

    protected $fillable =["cod_mencion", "id_carrera", "descripcion", "estado"];

    public function career(){
        return $this->belongsTo('ReactivosUPS\Mention');
    }
}
