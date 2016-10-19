<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "gen_areas";
    protected $primaryKey = 'cod_area';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = ['cod_area'];
    protected $fillable =["descripcion", "estado"];
}
