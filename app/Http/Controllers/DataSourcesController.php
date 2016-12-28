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
        try
        {
            Excel::load('Datos.csv', function($reader) {
                foreach ($reader->get() as $datasource) {
                    DataSource::create([

                        'pr_cod_persona' => $datasource->pr_cod_persona,
                        'cn_descripcion' =>$datasource->cn_descripcion,
                        'cd_capitulo' =>$datasource->cd_capitulo,
                        'cd_tema' =>$datasource->cd_tema

                        /*'pr_cod_persona' => $data->PR_COD_PERSONA,
                        'pr_nombre' => $data->PR_NOMBRE,
                        'pr_apellido' => $data->PR_APELLIDO,
                        'email' => $data->EMAIL,
                        'pr_tipo' => $data->PR_TIPO,
                        'pr_cedula' => $data->PR_CEDULA,
                        'pe_cod_perfil' => $data->PE_COD_PERFIL,
                        'pe_desc_perfil' => $data->PE_DESC_PERFIL,
                        'se_cod_sede' => $data->SE_COD_SEDE,
                        'se_desc_sede' => $data->SE_DESC_SEDE,
                        'se_cod_persona_admin' => $data->SE_COD_PERSONA_ADMIN,
                        'se_cod_persona_acad' => $data->SE_COD_PERSONA_ACAD,
                        'cm_cod_campus' => $data->CM_COD_CAMPUS,
                        'cm_desc_campus' => $data->CM_DESC_CAMPUS,
                        'ca_cod_carrera' => $data->CA_COD_CARRERA,
                        'ca_desc_carrera' => $data->CA_DESC_CARRERA,
                        'ca_cod_persona_admin' => $data->CA_COD_PERSONA_ADMIN,
                        'ca_cod_persona_acad' => $data->CA_COD_PERSONA_ACAD,
                        'cc_cod_persona' => $data->CC_COD_PERSONA,
                        'ar_cod_area' => $data->AR_COD_AREA,
                        'ar_desc_area' => $data->AR_DESC_AREA,
                        'ar_cod_docente' => $data->AR_COD_DOCENTE,
                        'ma_cod_materia' => $data->MA_COD_MATERIA,
                        'ma_desc_materia' => $data->MA_DESC_MATERIA,
                        'ma_abrev_materia' => $data->MA_ABREV_MATERIA,
                        'pd_cod_periodo' => $data->PD_COD_PERIODO,
                        'pd_desc_periodo' => $data->PD_DESC_PERIODO,
                        'pd_fecha_inicio' => $data->PD_FECHA_INICIO,
                        'pd_fecha_fin' => $data->PD_FECHA_FIN,
                        'di_cod_distributivo' => $data->DI_COD_DISTRIBUTIVO,
                        'cn_cod_contenido_cab' => $data->CN_COD_CONTENIDO_CAB,
                        'cd_cod_contenido_det' => $data->CD_COD_CONTENIDO_DET,
                        'cd_capitulo' => $data->CD_CAPITULO,
                        'cd_tema' => $data->CD_TEMA,
                        'creado_por' => \Auth::id(),
                        'fecha_creacion' => date('Y-m-d h:i:s')*/
                    ]);
                }
            });
        }catch (\Exception $e){
            dd("error");
        }

        return DataSource::all();
        //dd("ok");
    }
}
