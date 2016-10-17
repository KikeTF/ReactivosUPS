<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "gen_sedes";
    protected $primaryKey = 'cod_sede';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = ['cod_sede'];
    protected $fillable =["descripcion", "estado"];

    public function periods(){
        return $this->hasMany('ReactivosUPS\Location');
    }

    public function campus(){
        return $this->hasMany('ReactivosUPS\Location');
    }
}
