<?php

/**
 * NOMBRE DEL ARCHIVO   DashboardController.php
 *
 * TIPO                 Controlador
 *
 * DESCRIPCIÓN          Responde a las peticiones de información necesaria
 *                      para desplegar los indicadores en la página de
 *                      inicio de la aplicación.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\AnswerHeader;
use ReactivosUPS\Distributive;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\PeriodLocation;
use ReactivosUPS\Reagent;
use ReactivosUPS\ReagentState;
use Session;
use Log;

class DashboardController extends Controller
{
    /**
     * Muestra pagina Dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Session Data
        $aprReactivo = \Session::get('ApruebaReactivo');
        $aprExamen = \Session::get('ApruebaExamen');
        $id_Sede = (int)\Session::get('idSede');
        $ids_carreras = \Session::get('idsCarreras');
        $ids_areas = \Session::get('idsJefeAreas');

        // Request Data
        $id_campus = (isset($request['reaIdCampus']) ? (int)$request->reaIdCampus : 0);
        $id_carrera = (isset($request['reaIdCarrera']) ? (int)$request->reaIdCarrera : 0);
        $reaPeriodosSede = (isset($request['reaPeriodosSede']) ? $request->reaPeriodosSede[0] : "");
        $ids_periodos_sedes = ($reaPeriodosSede == "") ? array() : explode(",", $reaPeriodosSede);
        
        $id_campus_test = (isset($request['testIdCampus']) ? (int)$request->testIdCampus : 0);
        $id_carrera_test = (isset($request['testIdCarrera']) ? (int)$request->testIdCarrera : 0);
        $id_mencion_test = (isset($request['testIdMencion']) ? (int)$request->testIdMencion : 0);
        $testPeriodosSede = (isset($request['testPeriodosSede']) ? $request->testPeriodosSede[0] : "");
        $ids_periodos_sedes_test = ($testPeriodosSede == "") ? array() : explode(",", $testPeriodosSede);

        // Filters
        $filters = array($id_campus, $id_carrera, 0);
        $filters['periodosSede'] = $ids_periodos_sedes;
        $filters_test = array($id_campus_test, $id_carrera_test, $id_mencion_test);
        $filters_test['periodosSedeTest'] = $ids_periodos_sedes_test;

        $distributive = Distributive::query()->where('estado','A')->where('id_sede', $id_Sede);

        if(sizeof($ids_carreras) > 0)
            $distributive = $distributive->whereIn('id_carrera', $ids_carreras);

        if($aprReactivo == 'S' && $aprExamen == 'S')
        {
            $mattersCareers = MatterCareer::with('careerCampus')
                ->where('estado', 'A')
                ->where('aplica_examen', 'S')
                ->whereHas('careerCampus', function($query) use($id_campus, $id_carrera, $ids_carreras){
                    if ($id_campus > 0) $query->where('id_campus', $id_campus);
                    if ($id_carrera > 0) $query->where('id_carrera', $id_carrera);
                    elseif (sizeof($ids_carreras) > 0) $query->whereIn('id_carrera', $ids_carreras);
                });

            if(sizeof($ids_areas) > 0)
                $mattersCareers = $mattersCareers->whereIn('id_area', $ids_areas);

            $distributive = $distributive->whereIn('id_materia_carrera', $mattersCareers->get()->pluck('id')->toArray());
        }
        else
        {
            //$reagents = $reagents->where('creado_por', \Auth::id());
            $distributive = $distributive->where('id_usuario', \Auth::id());
        }

        if($id_campus > 0)
        {
            //$reagents = $reagents->where('id_campus', $id_campus);
            $distributive = $distributive->where('id_campus', $id_campus);
        }

        if($id_carrera > 0)
        {
            //$reagents = $reagents->where('id_carrera', $id_carrera);
            $distributive = $distributive->where('id_carrera', $id_carrera);
        }

        if(count($ids_periodos_sedes) > 0)
        {
            $periodLoc = PeriodLocation::query()->whereIn('id', $ids_periodos_sedes)->get();
            //$reagents = $reagents->whereIn('id_periodo', array_unique($periodLoc->pluck('id_periodo')->toArray()));
            $distributive = $distributive->whereIn('id_periodo_sede', $ids_periodos_sedes);
        }

        $distributive = $distributive->get();
        $mattersCareers = $distributive->pluck('mattercareer')->unique();
        $reagents = $distributive->pluck('reagents')->collapse()->unique();

        $MattersChartData = $this->reagentsByMatterChart($mattersCareers, $reagents);
        $StatesChartData = $this->reagentsByStateChart($mattersCareers, $reagents);
        $TeachersChartData = ($aprReactivo == 'S') ? $this->reagentsByTeacherChart($distributive) : null;
        if ($aprExamen == 'S')
        {
            $this->validateExpiredTests();
            $TestsChartData = $this->testsByStateChart($id_campus_test, $id_carrera_test, $id_mencion_test, $ids_periodos_sedes_test);
            $TestAnswersChartData = $this->testAnswersByMatterChart($id_campus_test, $id_carrera_test, $id_mencion_test, $ids_periodos_sedes_test);
        }
        else
        {
            $TestsChartData = null;
            $TestAnswersChartData = null;
        }

        return view('dashboard.index')
            ->with('filters', $filters)
            ->with('filters_test', $filters_test)
            ->with('campusList', $this->getCampuses())
            ->with('locationPeriodsList', $this->getLocationPeriods())
            ->with('MattersChartData', $MattersChartData)
            ->with('TeachersChartData', $TeachersChartData)
            ->with('TestsChartData', $TestsChartData)
            ->with('TestAnswersChartData', $TestAnswersChartData)
            ->with('StatesChartData', $StatesChartData);
    }

    /**
     * Retorna objeto con la data para generar indicador de barras
     * de Reactivos por Materia.
     *
     * @param  \ReactivosUPS\MatterCareer  $mattersCareers
     * @param  \ReactivosUPS\Reagent  $reagents
     * @return \Illuminate\Http\Response
     */
    public function reagentsByMatterChart($mattersCareers, $reagents)
    {
        try
        {
            foreach ($mattersCareers->sortBy('id_materia')->pluck('id_materia')->toArray() as $idMat)
            {
                $rea = Reagent::query()->whereIn('id', $reagents->pluck('id')->toArray());
                $contRea = $rea->where('id_estado','5')->where('id_materia', $idMat)->count();
                $bardata_real[$idMat] = $contRea;
            }

            $MattersChartData['categories'] = $mattersCareers->pluck('matter')->sortBy('id')->lists('descripcion','id')->toArray();
            $MattersChartData['target_series'] = $mattersCareers->sortBy('id_materia')->lists('nro_reactivos_mat','id_materia')->toArray();
            $MattersChartData['real_series'] = $bardata_real;
        }
        catch (\Exception $ex)
        {
            Log::error("[DashboardController][reagentsByMatterChart] Exception: " . $ex);
            $MattersChartData['categories'] = array();
            $MattersChartData['target_series'] = array();
            $MattersChartData['real_series'] = array();
        }

        return $MattersChartData;
    }

    /**
     * Retorna objeto con la data para generar indicador de barras
     * de Reactivos por Docente.
     *
     * @param  \ReactivosUPS\Distributive  $distributive
     * @return \Illuminate\Http\Response
     */
    public function reagentsByTeacherChart($distributive)
    {
        try
        {
            $users = $distributive->pluck('profileUser')->unique()->pluck('user')->sortBy('FullName');
            foreach (array_unique($users->pluck('id')->toArray()) as $idDocente)
            {
                $bardata_categories[$idDocente] = $users->where('id', $idDocente)->first()->FullName;
                $bardata_target[$idDocente] = $distributive->where('id_usuario', $idDocente)->pluck('matterCareer')->unique()->sum('nro_reactivos_mat');
                $bardata_real[$idDocente] = Reagent::query()->where('id_estado','5')->where('creado_por', $idDocente)->count();
            }

            $TeachersChartData['categories'] = isset($bardata_categories) ? $bardata_categories : array();
            $TeachersChartData['target_series'] = isset($bardata_target) ? $bardata_target : array();
            $TeachersChartData['real_series'] = isset($bardata_real) ? $bardata_real : array();
        }
        catch (\Exception $ex)
        {
            Log::error("[DashboardController][reagentsByTeacherChart] Exception: " . $ex);
            $TeachersChartData['categories'] = array();
            $TeachersChartData['target_series'] = array();
            $TeachersChartData['real_series'] = array();
        }

        return $TeachersChartData;
    }

    /**
     * Retorna objeto con la data para generar indicador de pie
     * de Reactivos por Estado.
     *
     * @param  \ReactivosUPS\MatterCareer  $mattersCareers
     * @param  \ReactivosUPS\Reagent  $reagents
     * @return \Illuminate\Http\Response
     */
    public function reagentsByStateChart($mattersCareers, $reagents)
    {
        try
        {
            $TotalReaReq = $mattersCareers->sum('nro_reactivos_mat');
            $TotalRea = $reagents->count();
            $states = ReagentState::query()->whereIn('id', array_unique($reagents->pluck('id_estado')->toArray()))->get();
            foreach ($states as $state)
            {
                $rea = Reagent::query()
                    ->whereIn('id', $reagents->pluck('id')->toArray())
                    ->where('id_estado', $state->id)->get();

                $piedata['id'] = $state->id;
                $piedata['state'] = $state->descripcion;
                $piedata['value'] = $rea->count();
                $piecolor[] = $state->color;
                $StatesChartData['series'][] = $piedata;
            }

            if($TotalReaReq > $TotalRea)
            {
                $piedata['state'] = 'Faltantes';
                $piedata['value'] = ($TotalReaReq - $TotalRea);
                $piecolor[] = '#abbac3';
                $StatesChartData['series'][] = $piedata;
            }

            if(!isset($StatesChartData['series']))
            {
                $piedata['id'] = 0;
                $piedata['state'] = 'Sin Informacion';
                $piedata['value'] = 0;
                $StatesChartData['series'][] = $piedata;
            }
            $StatesChartData['colors'] = isset($piecolor) ? $piecolor : array();
        }
        catch (\Exception $ex)
        {
            Log::error("[DashboardController][reagentsByStateChart] Exception: " . $ex);
            $StatesChartData['colors'] = array();
            $piedata['id'] = null;
            $piedata['state'] = 'Sin Informacion';
            $piedata['value'] = 0;
            $StatesChartData['series'][] = $piedata;
        }

        return $StatesChartData;
    }

    /**
     * Retorna objeto con la data para generar indicador de pie
     * de Tests por Estado.
     *
     * @param  int  $id_campus
     * @param  int  $id_carrera
     * @param  int  $id_mencion
     * @param  int[]  $ids_periodos_sedes
     * @return \Illuminate\Http\Response
     */
    public function testsByStateChart($id_campus, $id_carrera, $id_mencion, $ids_periodos_sedes)
    {
        try
        {
            $states = ['P', 'R', 'E', 'C', 'A'];

            foreach ($states as $state)
            {
                switch ($state) {
                    case "A":
                        $desc = "En proceso";
                        $color = "#478fca";
                        break;
                    case "P":
                        $desc = "Aprobado";
                        $color = "#87B87F";
                        break;
                    case "R":
                        $desc = "Reprobado";
                        $color = "#dd5a43";
                        break;
                    case "C":
                        $desc = "Cancelado";
                        $color = "#abbac3";
                        break;
                    case "E":
                        $desc = "Tiempo Agotado";
                        $color = "#f9e7af";
                        break;
                    default:
                        $desc = "No definido";
                        $color = "#848484";
                }

                $tests = AnswerHeader::with('examHeader')
                    ->where('estado', $state)
                    ->whereHas('examHeader', function($query) use($id_campus, $id_carrera, $ids_periodos_sedes){
                        if ($id_campus > 0) $query->where('id_campus', $id_campus);
                        if ($id_carrera > 0) $query->where('id_carrera', $id_carrera);
                        if (sizeof($ids_periodos_sedes) > 0) $query->whereIn('id_periodo', $ids_periodos_sedes);
                    })->get();

                if ($id_mencion > 1)
                    $tests = $tests->where('id_mencion', $id_mencion);

                if ($tests->count() > 0)
                {
                    $piedata['id'] = $state;
                    $piedata['state'] = $desc;
                    $piedata['value'] = $tests->count();
                    $piecolor[] = $color;
                    $StatesChartData['series'][] = $piedata;
                }

            }

            $StatesChartData['colors'] = isset($piecolor) ? $piecolor : array();
            if (!isset($StatesChartData['series']))
            {
                $piedata['id'] = null;
                $piedata['state'] = 'Sin Informacion';
                $piedata['value'] = 0;
                $StatesChartData['series'][] = $piedata;
            }
        }
        catch (\Exception $ex)
        {
            Log::error("[DashboardController][testsByStateChart] Exception: " . $ex);
            $StatesChartData['colors'] = array();
            $piedata['id'] = null;
            $piedata['state'] = 'Sin Informacion';
            $piedata['value'] = 0;
            $StatesChartData['series'][] = $piedata;
        }

        return $StatesChartData;
    }

    /**
     * Retorna objeto con la data para generar indicador de barras
     * de Respuestas de Tests por Materia.
     *
     * @param  int  $id_campus
     * @param  int  $id_carrera
     * @param  int  $id_mencion
     * @param  int[]  $ids_periodos_sedes
     * @return \Illuminate\Http\Response
     */
    public function testAnswersByMatterChart($id_campus, $id_carrera, $id_mencion, $ids_periodos_sedes)
    {
        try
        {
            $states = ['P', 'R', 'E', 'C', 'A'];

            $tests = AnswerHeader::with('examHeader')
                ->whereIn('estado', $states)
                ->whereHas('examHeader', function($query) use($id_campus, $id_carrera, $ids_periodos_sedes){
                    if ($id_campus > 0) $query->where('id_campus', $id_campus);
                    if ($id_carrera > 0) $query->where('id_carrera', $id_carrera);
                    if (sizeof($ids_periodos_sedes) > 0) $query->whereIn('id_periodo', $ids_periodos_sedes);
                })->get();

            if ($id_mencion > 1)
                $tests = $tests->where('id_mencion', $id_mencion);

            $answers = $tests->pluck('answersDetails')->collapse();

            foreach ($answers as $answer)
            {
                $matter = $answer->examDetail->reagent->distributive->matterCareer->matter;
                $idMat = $matter->id;
                if (!isset($bardata_categ[$idMat])) $bardata_categ[$idMat] = $matter->descripcion;
                $bardata_real[$idMat] = ((isset($bardata_real[$idMat])) ? (int)$bardata_real[$idMat] : 0) + (($answer->resp_correcta == "S") ? 1 : 0);
                $bardata_target[$idMat] = (isset($bardata_target[$idMat]) ? ((int)$bardata_target[$idMat] + 1) : 1);
            }

            if (isset($bardata_categ)) ksort($bardata_categ);
            if (isset($bardata_real)) ksort($bardata_real);
            if (isset($bardata_target)) ksort($bardata_target);

            $AnswersChartData['categories'] = isset($bardata_categ) ? $bardata_categ : array();
            $AnswersChartData['target_series'] = isset($bardata_target) ? $bardata_target : array();
            $AnswersChartData['real_series'] = isset($bardata_real) ? $bardata_real : array();
        }
        catch (\Exception $ex)
        {
            Log::error("[DashboardController][testAnswersByMatterChart] Exception: " . $ex);
            $AnswersChartData['categories'] = array();
            $AnswersChartData['target_series'] = array();
            $AnswersChartData['real_series'] = array();
        }

        return $AnswersChartData;
    }

    /**
     * Valida y actualiza los Test que se encuentren en estado
     * "En Proceso" y con tiempo expirado.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateExpiredTests()
    {
        try
        {
            $tests = AnswerHeader::query()->where('estado', 'A')->get();
            if ($tests->count() > 0)
            {
                foreach ($tests as $test)
                {
                    $limitTime = (float)$test->parameter->duracion_examen;
                    $startTime = strtotime($test->fecha_inicio);
                    $currentTime = strtotime(date('Y-m-d H:i:s'));
                    $time = round(($currentTime - $startTime)/60, 2);

                    // Valida si tiempo esta expirado
                    if($time > $limitTime)
                        $expiredIds[] = $test->id;
                }

                if (isset($expiredIds))
                {
                    AnswerHeader::whereIn('id', $expiredIds)
                        ->update(['estado' => 'E', 'modificado_por' => 0, 'fecha_modificacion' => date('Y-m-d H:i:s')]);
                }
            }
        }
        catch (\Exception $ex)
        {
            Log::error("[DashboardController][validateExpiredTests] Exception: ".$ex);
        }
    }
}
