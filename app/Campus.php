<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $table = "gen_campus";
    protected $primaryKey = 'cod_campus';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = ['cod_campus'];
    protected $fillable =["cod_sede", "descripcion", "estado"];

    public function location(){
        return $this->belongsTo('ReactivosUPS\Campus');
    }
}
