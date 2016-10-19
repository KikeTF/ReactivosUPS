<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    protected $table = "gen_menciones";
    protected $primaryKey = 'cod_mencion';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = ['cod_mencion'];
    protected $fillable =["cod_carrera","descripcion", "estado"];

    public function career(){
        return $this->belongsTo('ReactivosUPS\Mention');
    }
}
