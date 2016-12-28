<?php

namespace ReactivosUPS;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
    protected $table = "org_datos_prueba";
    public $timestamps = false;

    protected $fillable =["pr_cod_persona","cn_descripcion","cd_capitulo","cd_tema"];

   /* protected $fillable =["pr_cod_persona","pr_nombre","pr_apellido","email","pr_tipo","pr_cedula","pe_cod_perfil",
        "pe_desc_perfil","se_cod_sede","se_desc_sede","se_cod_persona_admin","se_cod_persona_acad","cm_cod_campus","cm_desc_campus",
        "ca_cod_carrera","ca_desc_carrera","ca_cod_persona_admin","ca_cod_persona_acad","cc_cod_persona","ar_cod_area",
        "ar_desc_area","ar_cod_docente","ma_cod_materia","ma_desc_materia","ma_abrev_materia","pd_cod_periodo","pd_desc_periodo",
        "pd_fecha_inicio","pd_fecha_fin","cn_cod_contenido_cab","cn_descripcion","cd_cod_contenido_det","cd_capitulo",
        "cd_tema","creado_por","fecha_creacion"];*/
}
