<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use ReactivosUPS\ReagentAnswer;
use Session;


class ReagentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_campus = (int)$request->id_campus;
        $id_carrera = (int)$request->id_carrera;
        $id_mencion = (int)$request->id_mencion;
        $id_materia = (int)$request->id_materia;

        $campuses = $this->getCampuses();
        $careers = $this->getCareers();
        $mentions = $this->getMentions();
        $matters = $this->getMatters();

        $filters = array($id_campus, $id_carrera, $id_mencion, $id_materia);
        $reagents = Reagent::query()->get();

        return view('reagent.reagents.index')
            ->with('reagents', $reagents)
            ->with('campuses', $campuses)
            ->with('careers', $careers)
            ->with('matters', $matters)
            ->with('mentions', $mentions)
            ->with('filters', $filters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campuses = $this->getCampuses();
        $careers = $this->getCareers();
        $mentions = $this->getMentions();
        $matters = $this->getMatters();
        $fields = $this->getFields();
        $formats = $this->getFormats();
        $contents = $this->getContents();
        return view('reagent.reagents.create')
            ->with('campuses', $campuses)
            ->with('careers', $careers)
            ->with('matters', $matters)
            ->with('mentions', $mentions)
            ->with('contents', $contents)
            ->with('fields', $fields)
            ->with('formats', $formats);
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

        $reagent = new Reagent($request->all());
        $reagent->id_distributivo = $this->getDistributive((int)$request->id_materia, (int)$request->id_carrera, (int)$request->id_campus)->id;
        $reagent->estado = !isset( $request['estado'] ) ? "I" : "A";
        $reagent->creado_por = \Auth::id();
        $reagent->fecha_creacion = date('Y-m-d h:i:s');

        $prefix = "f".$request->id_formato."_";

        $reagent->imagen = $request->file($prefix.'imagen');

        $nroOpRespMax = $request->input($prefix.'format_resp_max');
        $answersArray = array();
        for($i = 1; $i <= $nroOpRespMax; $i++)
            if( isset( $request[$prefix.'desc_op_resp_'.$i] ) )
            {
                $answer['secuencia'] = $i;
                $answer['descripcion'] = $request->input($prefix.'desc_op_resp_'.$i);
                $answer['argumento'] = $request->input($prefix.'arg_op_resp_'.$i);
                $answer['estado'] = 'A';
                $answer['creado_por'] = \Auth::id();
                $answer['fecha_creacion'] = date('Y-m-d h:i:s');
                $answersArray[] = new ReagentAnswer($answer);
            }

        $nroOpPregMax = $request->input($prefix.'format_preg_max');
        $questionsArray = array();
        for($i = 1; $i <= $nroOpPregMax; $i++)
            if( isset( $request[$prefix.'desc_op_preg_'.$i] ) )
            {
                $question['secuencia'] = $i;
                $question['concepto'] = $request->input($prefix.'conc_op_resp_'.$i);
                $question['propiedad'] = $request->input($prefix.'prop_op_resp_'.$i);
                $question['estado'] = 'A';
                $question['creado_por'] = \Auth::id();
                $question['fecha_creacion'] = date('Y-m-d h:i:s');
                $questionsArray[] = new ReagentAnswer($question);
            }

        \DB::beginTransaction(); //Start transaction!

        try
        {
            $reagent->save();
            Reagent::find($reagent->id)->reagentsAnswers()->saveMany($answersArray);
            Reagent::find($reagent->id)->reagentsQuestions()->saveMany($questionsArray);
        }
        catch(\Exception $e)
        {
            //failed logic here
            \DB::rollback();
            dd($e);
        }

        \DB::commit();

        return redirect()->route('reagent.reagents.index');

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
