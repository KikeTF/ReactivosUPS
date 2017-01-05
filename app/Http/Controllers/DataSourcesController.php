<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\DataSource;
use Maatwebsite\Excel\Facades\Excel;

class DataSourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('general.datasource.index');
    }

    public function import()
    {
        $valid = false;
        try
        {
            \DB::statement("TRUNCATE TABLE org_datos");

            $csv = "C:/wamp/www/ReactivosUPS/public/datos.csv";
            $statement = "LOAD DATA LOCAL INFILE '%s' ".
                        "INTO TABLE org_datos ".
                        "CHARACTER SET utf8 ".
                        "FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ".
                        "LINES TERMINATED BY '\\r\\n' ".
                        "IGNORE 1 LINES ".
                        "(pr_cod_persona, pr_nombre, pr_apellido, email, pr_tipo, pr_cedula, pe_cod_perfil, pe_desc_perfil, pe_referencia, ".
                        "se_cod_sede, se_desc_sede, se_cod_persona_admin, se_cod_persona_acad, cm_cod_campus, cm_desc_campus, ".
                        "ca_cod_carrera, ca_desc_carrera, ca_cod_persona_admin, ca_cod_persona_acad, cc_cod_persona, ar_cod_area, ".
                        "ar_desc_area, ar_cod_docente, ma_cod_materia, ma_desc_materia, ma_abrev_materia, mc_nivel, pd_cod_periodo, ".
                        "pd_desc_periodo, pd_fecha_inicio, pd_fecha_fin, di_cod_distributivo, cn_cod_contenido_cab, ".
                        "cd_cod_contenido_det, cd_capitulo, cd_tema)";
            $query = sprintf($statement, addslashes($csv));
            $rows = \DB::connection()->getpdo()->exec($query);

            $valid = true;
            flash($rows. ' registros importados correctamente. ', 'success');
        }catch (\Exception $ex){
            flash("Error al importa archivo csv!", 'danger')->important();
            Log::error("DataSourcesController][import] Exception: ".$ex);
        }

        return array("valid"=>$valid);
    }
}
