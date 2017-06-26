<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

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

        if($aprReactivo == 'S')
        {
            if($id_campus > 0 && $id_carrera > 0)
                $mattersCareers = $this->getMatterParameters(0, $id_carrera, $id_campus);
            else
                $mattersCareers = $this->getMattersCareers()->where('estado', 'A')->where('aplica_examen', 'S');

            if($id_area)
                $mattersCareers = $mattersCareers->where('id_area', $id_area);
        }
        else
        {
            $dist = Distributive::query()
                ->where('estado','A')
                ->where('id_sede', $id_Sede)
                ->where('id_usuario', \Auth::id());

            if($id_campus > 0 && $id_carrera > 0)
                $dist = $dist->where('id_carrera', $id_carrera)->where('id_campus', $id_campus);

            $mattersCareers = $dist->get()->pluck('mattercareer');
        }

        $reagents = Reagent::query()->where('id_sede', $id_sede)->where('id_estado', '!=', '7');

        if($id_campus > 0)
            $reagents = $reagents->where('id_campus', $id_campus);

        if($id_carrera > 0)
            $reagents = $reagents->where('id_carrera', $id_carrera);

        if(count($ids_periodos_sedes) > 0)
        {
            $periodLoc = PeriodLocation::query()->whereIn('id', $ids_periodos_sedes)->get();
            $reagents = $reagents->whereIn('id_periodo', array_unique($periodLoc->pluck('id_periodo')->toArray()));
        }

        foreach ($mattersCareers->sortBy('id_materia')->pluck('id_materia')->toArray() as $idMat)
        {
            $rea = Reagent::query()->whereIn('id', $reagents->get()->pluck('id')->toArray());
            $contRea = $rea->where('id_estado','5')->where('id_materia', $idMat)->count();
            $bardata_real[$idMat] = $contRea;
        }

        $BarChartData['categories'] = $mattersCareers->pluck('matter')->sortBy('id')->lists('descripcion','id')->toArray();
        $BarChartData['target_series'] = $mattersCareers->sortBy('id_materia')->lists('nro_reactivos_mat','id_materia')->toArray();
        $BarChartData['real_series'] = $bardata_real;

        $reagents = $reagents->where('id_estado', '!=', '7');
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
            $PieChartData['series'][] = $piedata;
        }

        if($TotalReaReq > $TotalRea)
        {
            $piedata['state'] = 'Faltantes';
            $piedata['value'] = ($TotalReaReq - $TotalRea);
            $piecolor[] = '#abbac3';
            $PieChartData['series'][] = $piedata;
        }

        $PieChartData['colors'] = $piecolor;

        return view('dashboard.index')
            ->with('filters', $filters)
            ->with('campusList', $this->getCampuses())
            ->with('locationPeriodsList', $this->getLocationPeriods())
            ->with('BarChartData', $BarChartData)
            ->with('PieChartData', $PieChartData);
    }

}
