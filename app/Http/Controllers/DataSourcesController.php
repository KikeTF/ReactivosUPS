<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\DataSource;
use Maatwebsite\Excel\Facades\Excel;
use Log;
use Input;

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

    public function import(Request $request)
    {
        try
        {
            $destinationPath = '';
            $fileName = '';
            $isValidFile = (bool)false;
            if ( isset($request['csvFile']) && $request->hasFile('csvFile') )
            {
                $file = $request->file('csvFile');
                if ( $file->isValid() )
                {
                    $isValidFile = (bool)true;
                    if ($request->type == 'D')
                    {
                        $destinationPath = storage_path()."/files/distributive";
                        $fileName = "UPS-DISTRIBUTIVE-".date('Ymd-His').".csv";
                    }
                    elseif ($request->type == 'B')
                    {
                        $destinationPath = storage_path()."/files/bibliography";
                        $fileName = "UPS-BIBLIOGRAPHY-".date('Ymd-His').".csv";
                    }
                }
                else
                {
                    flash("El archivo excede el tamaño m&aacute;ximo permitido!", 'warning')->important();
                    Log::warning("DataSourcesController][import] Reason: El archivo excede el tamanio maximo permitido!");
                }
            }
            else
            {
                flash("No se encontro archivo de importaci&oacute;n!", 'warning')->important();
                Log::warning("DataSourcesController][import] Reason: No se encontro archivo de importacion!");
            }

            if( $isValidFile )
            {
                Log::debug("DataSourcesController][import] El archivo existe y es valido.");

                $csvPath = $request->file('csvFile')->move($destinationPath, $fileName);
                //$request->file('file')->move(base_path().'/storage/files/reagents/', $fileName);
                Log::debug("DataSourcesController][import] Archivo cargado en la ruta: ".$csvPath);

                if ($request->type == 'D')
                {
                    //Limpia tabla previo a importacion de datos
                    \DB::statement("TRUNCATE TABLE org_datos");

                    //Query de importacion
                    $statement = "LOAD DATA LOCAL INFILE '%s' ".
                        "INTO TABLE org_datos ".
                        "CHARACTER SET utf8 ".
                        "FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ".
                        "LINES TERMINATED BY '\\r\\n' ".
                        "IGNORE 1 LINES ".
                        "(pr_cod_persona, pr_nombre, pr_apellido, email, pr_tipo, pr_cedula, pe_cod_perfil, pe_desc_perfil, ".
                        "se_cod_sede, se_desc_sede, se_cod_persona_admin, se_cod_persona_acad, cm_cod_campus, cm_desc_campus, ".
                        "ca_cod_carrera, ca_desc_carrera, ar_cod_area, ar_desc_area, ar_cod_docente, ar_estado, ".
                        "ma_cod_materia, ma_desc_materia, ma_abrev_materia, mc_nivel, pd_cod_periodo, pd_desc_periodo, ".
                        "pd_fecha_inicio, pd_fecha_fin, di_cod_distributivo, cn_cod_contenido_cab, ".
                        "cd_cod_contenido_det, cd_capitulo, cd_tema)";

                    $query = sprintf($statement, addslashes($csvPath));

                    Log::debug("DataSourcesController][import] Inicio de importacion de distributivo. Consulta: ".$query);

                    //Importacion de datos
                    $rows = \DB::connection()->getpdo()->exec($query);

                    Log::debug("DataSourcesController][import] Distributivo importado correctamente. Registros cargados: ".$rows);

                    $this->loadDistributive();
                }
                elseif ($request->type == 'B')
                {
                    \DB::statement("TRUNCATE TABLE org_bibliografia");

                    //Query de importacion
                    $statement = "LOAD DATA LOCAL INFILE '%s' ".
                        "INTO TABLE org_bibliografia ".
                        "CHARACTER SET utf8 ".
                        "FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ".
                        "LINES TERMINATED BY '\\r\\n' ".
                        "IGNORE 1 LINES ".
                        "(cn_cod_contenido_cab, cn_cod_carrera, cn_cod_materia, cn_cod_campus, ".
                        "cn_bibliografia_base, cn_bibliografia_complementaria)";

                    $query = sprintf($statement, addslashes($csvPath));

                    Log::debug("DataSourcesController][import] Inicio de importacion de bibliografia. Consulta: ".$query);

                    //Importacion de datos
                    $rows = \DB::connection()->getpdo()->exec($query);

                    Log::debug("DataSourcesController][import] Bibliografia importada correctamente. Registros cargados: ".$rows);

                    $this->loadBibliography();
                }

                //Limpia tabla al finalizar el proceso de importacion
                //\DB::statement("TRUNCATE TABLE org_datos");

                flash('Proceso ejecutado correctamente. Registros importados: '.$rows, 'success');
            }
        }
        catch (\Exception $ex)
        {
            flash("No se pudo importar los datos!", 'danger')->important();
            Log::error("DataSourcesController][import] Exception: ".$ex);

        }

        //Elimina archivo de public folder si existe
        if( \Storage::disk('uploads')->exists($fileName) )
            \Storage::disk('uploads')->delete($fileName);

        return redirect()->route('general.datasource.index');
    }

    public function loadDistributive()
    {
        $stmt = 'call sp_org_carga_datos('.\Auth::id().')';
        \DB::connection()->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        $sp = \DB::connection()->getpdo()->prepare($stmt);
        $sp->execute();
        $result = $sp->fetchAll(\DB::connection()->getFetchMode());
        $sp->closeCursor();

        if(strcmp(strtoupper($result[0]->return_message), "OK") !== 0) {
            Log::error("[DataSourceController][loadDistributive] Procedure=" . $result[0]->procedure . "; Error=" . $result[0]->return_message);
            flash('No fue posible completar la transaccion. Proceso: (' . $result[0]->procedure . ')', 'danger')->important();
            return redirect()->route('general.datasource.index');
        }
    }

    public function loadBibliography()
    {
        $stmt = 'call sp_gen_carga_bibliografia('.\Auth::id().')';
        \DB::connection()->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        $sp = \DB::connection()->getpdo()->prepare($stmt);
        $sp->execute();
        $result = $sp->fetchAll(\DB::connection()->getFetchMode());
        $sp->closeCursor();

        if(strcmp(strtoupper($result[0]->return_message), "OK") !== 0) {
            Log::error("[DataSourceController][loadDistributive] Procedure=" . $result[0]->procedure . "; Error=" . $result[0]->return_message);
            flash('No fue posible completar la transaccion. Proceso: (' . $result[0]->procedure . ')', 'danger')->important();
            return redirect()->route('general.datasource.index');
        }
    }

}
