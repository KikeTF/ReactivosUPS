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

            $distributive = $distributive->whereIn('id_materia_carrera', $mattersCareers->pluck('id')->toArray())->get();
        }
        else
        {
            $reagents = $reagents->where('creado_por', \Auth::id());
            $distributive = $distributive->where('id_usuario', \Auth::id())->get();
            $mattersCareers = $distributive->pluck('mattercareer');
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
        }

        $MattersChartData = $this->reagentsByMatterChart($mattersCareers, $reagents);
        $TeachersChartData = $this->reagentsByTeacherChart($distributive);
        $StatesChartData = $this->reagentsByStateChart($mattersCareers, $reagents);

        return view('dashboard.index')
            ->with('filters', $filters)
            ->with('campusList', $this->getCampuses())
            ->with('locationPeriodsList', $this->getLocationPeriods())
            ->with('MattersChartData', $MattersChartData)
            ->with('TeachersChartData', $TeachersChartData)
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

        $TeachersChartData['categories'] = $bardata_categories;
        $TeachersChartData['target_series'] = $bardata_target;
        $TeachersChartData['real_series'] = $bardata_real;

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

}
