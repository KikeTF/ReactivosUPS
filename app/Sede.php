<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected  $table = "GEN_SEDES";

    protected $fillable = ['DESC_SEDE', 'ESTADO'];

    public function campus(){
        return $this->$this->hasMany('ReactivosUPS\Campus');
    }
}
