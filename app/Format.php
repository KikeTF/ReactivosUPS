<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'rea_formatos';
    public $timestamps = false;

    protected $fillable = ['nombre','descripcion','opciones_resp_min','opciones_resp_max','opciones_pregunta',
                            'concepto_propiedad','opciones_preg_min','opciones_preg_max','imagenes','estado',
                            'creado_por','fecha_creacion','modificado_por','fecha_modificacion'];

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'id_formato');
    }
}
