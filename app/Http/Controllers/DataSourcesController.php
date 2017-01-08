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
        $isValidFile = false;
        $destinationPath = public_path()."\\uploads";
        $fileName = "datos.csv";
        try
        {
            if( $request->hasFile('csvFile') ){
                if( $request->file('csvFile')->isValid() ){
                    $isValidFile = true;
                }else{
                    flash("El archivo excede el tamaño m&aacute;ximo permitido!", 'warning')->important();
                    Log::warning("DataSourcesController][import] Reason: El archivo excede el tamanio maximo permitido!");
                }
            }else{
                flash("No se encontro archivo de importaci&oacute;n!", 'warning')->important();
                Log::warning("DataSourcesController][import] Reason: No se encontro archivo de importacion!");
            }

            if( $isValidFile )
            {
                Log::debug("DataSourcesController][import] El archivo existe y es valido.");

                $csvPath = $request->file('csvFile')->move($destinationPath, $fileName);
                Log::debug("DataSourcesController][import] Archivo cargado en la ruta: ".$csvPath);

                //Limpia tabla previo a importacion de datos
                \DB::statement("TRUNCATE TABLE org_datos");

                //Query de importacion
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
                $query = sprintf($statement, addslashes($csvPath));

                Log::debug("DataSourcesController][import] Inicio de importacion de los datos. Consulta: ".$query);

                //Importacion de datos
                $rows = \DB::connection()->getpdo()->exec($query);

                Log::debug("DataSourcesController][import] Datos importados correctamente. Registros cargados: ".$rows);

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

}
