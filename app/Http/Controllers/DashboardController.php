<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\AnswerDetail;
use ReactivosUPS\AnswerHeader;
use ReactivosUPS\Area;
use ReactivosUPS\Distributive;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\PeriodLocation;
use ReactivosUPS\Reagent;
use ReactivosUPS\ReagentState;
use Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Session Data
        $aprReactivo = \Session::get('ApruebaReactivo');
        $aprExamen = \Session::get('ApruebaExamen');
        $id_Sede = (int)\Session::get('idSede');

        // Request Data
        $id_sede = (int)Session::get('idSede');
        $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
        $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
        $ids_periodos_sedes = (isset($request['periodosSede']) ? $request->periodosSede : array());

        // Filters
        $filters = array($id_campus, $id_carrera, 0);
        $filters['periodosSede'] = $ids_periodos_sedes;

        // ID de Jefe de Area
        $area = Area::query()->where('estado','A')->where('id_usuario_resp',\Auth::id());
        $id_area = ($area->count() > 0) ? $area->first()->id : 0;

        $distributive = Distributive::query()->where('estado','A')->where('id_sede', $id_Sede);
        $reagents = Reagent::query()->where('id_estado', '!=', '7')->where('id_sede', $id_sede);

        if($aprReactivo == 'S')
        {
            if($id_campus > 0 && $id_carrera > 0)
                $mattersCareers = $this->getMatterParameters(0, $id_carrera, $id_campus);
            else
                $mattersCareers = $this->getMattersCareers()->where('estado', 'A')->where('aplica_examen', 'S');

            if($id_area)
                $mattersCareers = $mattersCareers->where('id_area', $id_area);

            $distributive = $distributive->whereIn('id_materia_carrera', $mattersCareers->pluck('id')->toArray());
        }
        else
        {
            $reagents = $reagents->where('creado_por', \Auth::id());
            $distributive = $distributive->where('id_usuario', \Auth::id());
            $mattersCareers = $distributive->get()->pluck('mattercareer');
        }

        if($id_campus > 0)
        {
            $reagents = $reagents->where('id_campus', $id_campus);
            $distributive = $distributive->where('id_campus', $id_campus);
        }

        if($id_carrera > 0)
        {
            $reagents = $reagents->where('id_carrera', $id_carrera);
            $distributive = $distributive->where('id_carrera', $id_carrera);
        }

        if(count($ids_periodos_sedes) > 0)
        {
            $periodLoc = PeriodLocation::query()->whereIn('id', $ids_periodos_sedes)->get();
            $reagents = $reagents->whereIn('id_periodo', array_unique($periodLoc->pluck('id_periodo')->toArray()));
            $distributive = $distributive->whereIn('id_periodo_sede', $ids_periodos_sedes);
        }

        $distributive = $distributive->get();

        $MattersChartData = $this->reagentsByMatterChart($mattersCareers, $reagents);
        $StatesChartData = $this->reagentsByStateChart($mattersCareers, $reagents);
        $TeachersChartData = ($aprReactivo == 'S') ? $this->reagentsByTeacherChart($distributive) : null;
        $TestsChartData = ($aprExamen == 'S') ? $this->testsByStateChart() : null;
        $TestAnswersChartData = ($aprExamen == 'S') ? $this->testAnswersByMatterChart() : null;

        return view('dashboard.index')
            ->with('filters', $filters)
            ->with('campusList', $this->getCampuses())
            ->with('locationPeriodsList', $this->getLocationPeriods())
            ->with('MattersChartData', $MattersChartData)
            ->with('TeachersChartData', $TeachersChartData)
            ->with('TestsChartData', $TestsChartData)
            ->with('TestAnswersChartData', $TestAnswersChartData)
            ->with('StatesChartData', $StatesChartData);
    }

    public function reagentsByMatterChart($mattersCareers, $reagents)
    {
        foreach ($mattersCareers->sortBy('id_materia')->pluck('id_materia')->toArray() as $idMat)
        {
            $rea = Reagent::query()->whereIn('id', $reagents->get()->pluck('id')->toArray());
            $contRea = $rea->where('id_estado','5')->where('id_materia', $idMat)->count();
            $bardata_real[$idMat] = $contRea;
        }

        $MattersChartData['categories'] = $mattersCareers->pluck('matter')->sortBy('id')->lists('descripcion','id')->toArray();
        $MattersChartData['target_series'] = $mattersCareers->sortBy('id_materia')->lists('nro_reactivos_mat','id_materia')->toArray();
        $MattersChartData['real_series'] = $bardata_real;

        return $MattersChartData;
    }

    public function reagentsByTeacherChart($distributive)
    {
        $users = $distributive->pluck('profileUser')->pluck('user')->sortBy('apellidos');
        foreach (array_unique($users->pluck('id')->toArray()) as $idDocente)
        {
            $bardata_categories[$idDocente] = $users->where('id', $idDocente)->first()->FullName;
            $bardata_target[$idDocente] = $distributive->where('id_usuario', $idDocente)->pluck('matterCareer')->sum('nro_reactivos_mat');
            $bardata_real[$idDocente] = Reagent::query()->where('id_estado','5')->where('creado_por', $idDocente)->count();
        }

        $TeachersChartData['categories'] = isset($bardata_categories) ? $bardata_categories : array();
        $TeachersChartData['target_series'] = isset($bardata_target) ? $bardata_target : array();
        $TeachersChartData['real_series'] = isset($bardata_real) ? $bardata_real : array();

        return $TeachersChartData;
    }

    public function reagentsByStateChart($mattersCareers, $reagents)
    {
        $TotalReaReq = $mattersCareers->sum('nro_reactivos_mat');
        $TotalRea = $reagents->count();
        $states = ReagentState::query()->whereIn('id', array_unique($reagents->get()->pluck('id_estado')->toArray()))->get();
        foreach ($states as $state)
        {
            $rea = Reagent::query()
                ->whereIn('id', $reagents->get()->pluck('id')->toArray())
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

        $StatesChartData['colors'] = $piecolor;

        return $StatesChartData;
    }

    public function testsByStateChart()
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

            $tests = AnswerHeader::query()->where('estado', $state)->get();

            $piedata['id'] = $state;
            $piedata['state'] = $desc;
            $piedata['value'] = $tests->count();
            $piecolor[] = $color;
            $StatesChartData['series'][] = $piedata;
        }

        $StatesChartData['colors'] = isset($piecolor) ? $piecolor : array();

        return $StatesChartData;
    }

    public function testAnswersByMatterChart()
    {
        $answers = AnswerDetail::query()->get();

        foreach ($answers as $answer)
        {
            $matter = $answer->examDetail->reagent->distributive->matterCareer->matter;
            $idMat = $matter->id;
            if (!isset($bardata_categ[$idMat])) $bardata_categ[$idMat] = $matter->descripcion;
            $bardata_real[$idMat] = ((isset($bardata_real[$idMat])) ? (int)$bardata_real[$idMat] : 0) + (($answer->resp_correcta == "S") ? 1 : 0);
            $bardata_target[$idMat] = (isset($bardata_target[$idMat]) ? ((int)$bardata_target[$idMat] + 1) : 1);
        }

        ksort($bardata_categ);
        ksort($bardata_real);
        ksort($bardata_target);

        $AnswersChartData['categories'] = isset($bardata_categ) ? $bardata_categ : array();
        $AnswersChartData['target_series'] = isset($bardata_target) ? $bardata_target : array();
        $AnswersChartData['real_series'] = isset($bardata_real) ? $bardata_real : array();

        return $AnswersChartData;
    }

}
