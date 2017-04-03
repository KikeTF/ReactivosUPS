<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\ExamHeader;
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

    public function detail(Request $request, $id, $id_matter)
    {
        $exam = ExamHeader::find($id);
        //$matters = Matter::query()->where('estado','A')->orderBy('descripcion', 'asc')->get();
        //$id_materia = (isset($request['id_materia']) ? (int)$request->id_carrera : 0);

        $reagents = Reagent::query()
            //->where('id_estado','5')
            ->where('id_sede', $exam->id_sede)
            ->where('id_periodo', $exam->id_periodo)
            ->where('id_campus', $exam->id_campus)
            ->where('id_carrera', $exam->id_carrera);
        
        foreach ($reagents->get() as $mat)
        {
            $ids[] = $mat->id_materia;
        }

        if(isset($ids))
        {
            array_unique($ids);
            $mattersList = Matter::query()->whereIn('id',$ids)->where('estado','A')->orderBy('descripcion','asc')->get();
        }
        
        if($id_matter > 0)
        {
            $reagents = $reagents->where('id_materia', $id_matter)->get();
            $exam->matter = Matter::find($id_matter)->descripcion;
        }



        return view('exam.exams.detail')
            ->with('matters', $mattersList)
            ->with('reagents', $reagents)
            ->with('exam', $exam);
    }

    public function getReagentsByMatter($id_exam, $id_matter)
    {
        $exam = ExamHeader::find($id_exam);

        $reagents = Reagent::query()
            //->where('id_estado','5')
            ->where('id_sede', $exam->id_sede)
            ->where('id_periodo', $exam->id_periodo)
            ->where('id_campus', $exam->id_campus)
            ->where('id_carrera', $exam->id_carrera)
            ->where('id_materia', $id_matter)
            ->get();

        foreach ($reagents as $mat)
        {
            $ids[] = $mat->id_materia;
        }

        if(isset($ids))
        {
            array_unique($ids);
            $mattersList = Matter::query()->whereIn('id',$ids)->where('estado','A')->orderBy('descripcion','asc')->get();
        }

        return view('exam.exams.detail')
            ->with('matters', $mattersList)
            ->with('reagents', $reagents)
            ->with('exam', $exam);

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_careerCampus = $this->getCareersCampuses()->where('id_carrera', $id_carrera)->where('id_campus', $id_campus)->first()->id;

            $exam = new ExamHeader($request->all());
            $exam->es_prueba = !isset( $request['es_prueba'] ) ? 'N' : 'S';
            $exam->estado = 'A';
            $exam->id_sede = (int)\Session::get('idSede');
            $exam->id_periodo = (int)\Session::get('idPeriodo');
            $exam->id_periodo_sede = (int)\Session::get('idPeriodoSede');
            $exam->id_carrera_campus = $id_careerCampus;
            $exam->creado_por = \Auth::id();
            $exam->fecha_creacion = date('Y-m-d h:i:s');

            $exam->save();
            return redirect()->route('exam.exams.detail',['id' => $exam->id, 'id_matter' => 0]);
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ExamsController][store] Request=". implode(", ", $request->all()) ."; Exception: ".$ex);
            return redirect()->route('exam.exams.create');
        }

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
