<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = "gen_carrera";
    protected $primaryKey = 'cod_carrera';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = ['cod_carrera'];
    protected $fillable =["descripcion", "estado"];

    public function mentions(){
        return $this->hasMany('ReactivosUPS\Career');
    }
}
