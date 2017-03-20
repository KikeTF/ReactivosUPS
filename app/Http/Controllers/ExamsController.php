<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Matter;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use Log;

class ExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
            $id_estado = (isset($request['id_estado']) ? (int)$request->id_estado : 0);

            $filters = array($id_campus, $id_carrera, $id_materia, $id_estado);

            if ($id_campus > 0 && $id_carrera > 0 && $id_materia > 0) {
                $id_distributivo = $this->getDistributive($id_materia, $id_carrera, $id_campus)->id;
                if ($id_estado == 0)
                    $reagents = Reagent::filter($id_distributivo)->where('id_estado', '!=', 7);
                else
                    $reagents = Reagent::filter2($id_distributivo, $id_estado)->where('id_estado', '!=', 7);
            } else
                $reagents = Reagent::query()->where('id_estado', '!=', 7);

            $reagents = $reagents->orderBy('id', 'desc')->get();

            return view('exam.exams.index')
                ->with('reagents', $reagents)
                ->with('campuses', $this->getCampuses())
                ->with('careers', $this->getCareers())
                ->with('matters', $this->getMatters(0, 0, 0, 0))
                ->with('states', $this->getReagentsStates())
                ->with('statesLabels', $this->getReagentsStatesLabel())
                ->with('filters', $filters);
        } catch (\Exception $ex) {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ExamsController][index] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
            return redirect()->route('index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('exam.exams.create')
                ->with('campusList', $this->getCampuses())
                //->with('careers', $this->getCareers())
                ->with('matters', $this->getMatters(0, 0, 0, 0))
                ->with('mentions', $this->getMentions())
                ->with('contents', $this->getContentsModel())
                ->with('fields', $this->getFields())
                ->with('formats', $this->getFormats());
        } catch (\Exception $ex) {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsController][create] Exception: " . $ex);
            return redirect()->route('reagent.reagents.index');
        }
    }

    public function detail(Request $request)
    {
        $matters = Matter::query()->where('estado','A')->orderBy('descripcion', 'asc')->get();
        $id_materia = (isset($request['id_materia']) ? (int)$request->id_carrera : 0);

        $reagents = Reagent::query()->where('id_estado','5')->get();

        return view('exam.exams.detail')
            ->with('matters', $matters)
            ->with('reagents', $reagents);
    }

    public function getReagentsByMatter($id_matter, $id_career, $id_campus)
    {
        $id_location = (int)\Session::get('idSede');
        $matters = Matter::query()->where('estado','A')->orderBy('descripcion', 'asc')->get();
        //$id_materia = (isset($request['id_materia']) ? (int)$request->id_carrera : 0);
        //$matterSCareers = MatterCareer::query()->where('id_materia', $id_matter)->first()->id;
        //dd($matterSCareers);
        $reagents = Reagent::query()
            ->where('id_carrera', $id_career)
            ->where('id_campus', $id_campus)
            ->where('id_sede', $id_location)
            ->where('id_materia', $id_matter)
            ->get();//->where('id_estado','5')

        return view('exam.exams.detail')
            ->with('matters', $matters)
            ->with('reagents', $reagents);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
