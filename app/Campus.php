<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected  $table = "GEN_CAMPUS";

    protected $fillable = ['DESC_CAMPUS', 'ESTADO', 'COD_SEDE'];

    public function sede(){
        return $this->belongsTo('ReactivosUPS\Sede');
    }
}
