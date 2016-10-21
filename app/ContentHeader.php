<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class ContentHeader extends Model
{
    protected $table = "gen_contenido_cab";
    public $timestamps = false;

    protected $fillable =["cod_contenido_cab", "id_materia_carrera", "estado"];

    public function matterCareer(){
        return $this->belongsTo('ReactivosUPS\MatterCareer');
    }

    public function contentsDetails(){
        return $this->hasMany('ReactivosUPS\ContentDetail');
    }
}
