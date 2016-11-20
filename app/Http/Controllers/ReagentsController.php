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

    public function format()
    {
        dd("ok");
        //return json_encode("ok");
        //$this->layout->content = View::make('home.user')->with('id', $id);
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
        $reagent = new Reagent($request->all());

        $reagent->id_distributivo = $this->getDistributive((int)$request->id_materia, (int)$request->id_carrera, (int)$request->id_campus)->id;

        //$reagent->planteamiento= "Prueba";
        //$reagent->pregunta_opciones= "Prueba";
        //$reagent->id_opcion_correcta= 1;
        //$reagent->puntaje = 9 ;
        //$reagent->referencia= "Prueba";

        $reagent->estado = !isset( $request['estado'] ) ? "I" : "A";
        $reagent->creado_por = \Auth::id();
        $reagent->fecha_creacion = date('Y-m-d h:i:s');
        //$reagent->reagentsAnswers($answers);

        //dd($reagent);

        $nroOpRespMax = $this->getFormatParameters($reagent->id_formato)->nro_opciones_resp_max;
        $answers = array();

        for($i = 1; $i <= $nroOpRespMax; $i++)
        {
            if( isset( $request['desc_op_resp_'.$i] ) )
            {
                $answer['secuencia'] = $i;
                $answer['descripcion'] = $request->input('desc_op_resp_'.$i);
                $answer['argumento'] = $request->input('arg_op_resp_'.$i);
                $answer['estado'] = 'A';
                $answer['creado_por'] = \Auth::id();
                $answer['fecha_creacion'] = date('Y-m-d h:i:s');
                $answers[] = new ReagentAnswer($answer);
            }
            //id
            //id_reactivo,
        }

        \DB::beginTransaction(); //Start transaction!

        try
        {
            $reagent->save();
            Reagent::find($reagent->id)->reagentsAnswers()->saveMany($answers);
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
