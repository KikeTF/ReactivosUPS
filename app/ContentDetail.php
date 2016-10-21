<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ContentDetail extends Model
{
    protected $table = "gen_contenido_det";
    public $timestamps = false;

    protected $fillable =["id_contenido_cab", "cod_contenido_det", "cod_contenido_cab", "capitulo", "tema", "estado"];

    public function contentHeader(){
        return $this->belongsTo('ReactivosUPS\ContentHeader');
    }

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent');
    }
}
