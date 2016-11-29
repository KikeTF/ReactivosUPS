<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Career;
use ReactivosUPS\Campus;
use ReactivosUPS\Format;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use ReactivosUPS\ReagentAnswer;
use ReactivosUPS\ReagentQuestion;
use ReactivosUPS\ReagentComment;
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
        $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
        $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
        $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
        $id_estado = (isset($request['id_estado']) ? (int)$request->id_estado : 0);

        $filters = array($id_campus, $id_carrera, $id_materia, $id_estado);

        if($id_campus > 0 && $id_carrera > 0 && $id_materia > 0){
            $id_distributivo = $this->getDistributive($id_materia, $id_carrera, $id_campus)->id;
            if($id_estado == 0)
                $reagents = Reagent::filter($id_distributivo)->where('id_estado','!=',7)->get();
            else
                $reagents = Reagent::filter2($id_distributivo, $id_estado)->where('id_estado','!=',7)->get();
        }else
            $reagents = Reagent::query()->where('id_estado','!=',7)->get();

        return view('reagent.reagents.index')
            ->with('reagents', $reagents)
            ->with('campuses', $this->getCampuses())
            ->with('careers', $this->getCareers())
            ->with('matters', $this->getMatters())
            ->with('states', $this->getReagentsStates())
            ->with('statesLabels', $this->getReagentsStatesLabel())
            ->with('filters', $filters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reagent.reagents.create')
            ->with('campuses', $this->getCampuses())
            ->with('careers', $this->getCareers())
            ->with('matters', $this->getMatters())
            ->with('mentions', $this->getMentions())
            ->with('contents', $this->getContents())
            ->with('fields', $this->getFields())
            ->with('formats', $this->getFormats());
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
        $reagent->creado_por = \Auth::id();
        $reagent->fecha_creacion = date('Y-m-d h:i:s');

        $prefix = "f".$request->id_formato."_";

        $reagent->id_opcion_correcta = $request->input($prefix.'id_opcion_correcta');
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
            if( isset( $request[$prefix.'conc_op_preg_'.$i] ) or isset( $request[$prefix.'prop_op_preg_'.$i] ) )
            {
                $question['secuencia'] = $i;
                $question['concepto'] = is_null($request->input($prefix.'conc_op_preg_'.$i)) ? "" : $request->input($prefix.'conc_op_preg_'.$i);
                $question['propiedad'] = is_null($request->input($prefix.'prop_op_preg_'.$i)) ? "" : $request->input($prefix.'prop_op_preg_'.$i);
                $question['estado'] = 'A';
                $question['creado_por'] = \Auth::id();
                $question['fecha_creacion'] = date('Y-m-d h:i:s');
                $questionsArray[] = new ReagentQuestion($question);
            }

        \DB::beginTransaction(); //Start transaction!

        try
        {
            $reagent->save();
            Reagent::find($reagent->id)->answers()->saveMany($answersArray);
            Reagent::find($reagent->id)->questions()->saveMany($questionsArray);
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
        $reagent = Reagent::find($id);
        $mattercareer = MatterCareer::find($reagent->distributive->id_materia_carrera);

        $reagent->desc_campus = Campus::find($mattercareer->careerCampus->id_campus)->descripcion;
        $reagent->desc_carrera = Career::find($mattercareer->careerCampus->id_carrera)->descripcion;
        $reagent->desc_mencion = $mattercareer->mention->descripcion;
        $reagent->desc_materia = $mattercareer->matter->descripcion;
        $reagent->desc_formato = $reagent->format->nombre;
        $reagent->desc_campo = $reagent->field->nombre;
        $reagent->desc_contenido = $reagent->contentDetail->capitulo." ".$reagent->contentDetail->tema;
        $reagent->usr_responsable = $this->getUserName($reagent->id_usr_responsable);
        $reagent->dificultad = ($reagent->dificultad == 'B') ? 'Baja' : ($reagent->dificultad == 'M') ? 'Media' : 'Alta';
        $reagent->desc_estado = $reagent->state->descripcion;
        $reagent->creado_por = $this->getUserName($reagent->creado_por);
        $reagent->modificado_por = $this->getUserName($reagent->modificado_por);

        $reagentQuestions = ReagentQuestion::query()->where('id_reactivo', $reagent->id)->orderBy('secuencia','asc')->get();
        $reagentAnswers = ReagentAnswer::query()->where('id_reactivo', $reagent->id)->orderBy('secuencia','asc')->get();
        $reagentComments = ReagentComment::query()->where('id_reactivo', $reagent->id)->orderBy('id','desc')->get();

        return view('reagent.reagents.show')
            ->with('reagent', $reagent)
            ->with('questions', $reagentQuestions)
            ->with('answers', $reagentAnswers)
            ->with('comments', $reagentComments)
            ->with('states', $this->getReagentsStates())
            ->with('users', $this->getUsers())
            ->with('formatParam', $reagent->format);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reagent = Reagent::find($id);
        $mattercareer = MatterCareer::find($reagent->distributive->id_materia_carrera);

        $reagent->desc_campus = Campus::find($mattercareer->careerCampus->id_campus)->descripcion;
        $reagent->desc_carrera = Career::find($mattercareer->careerCampus->id_carrera)->descripcion;
        $reagent->desc_mencion = $mattercareer->mention->descripcion;
        $reagent->desc_materia = $mattercareer->matter->descripcion;
        $reagent->desc_estado = $reagent->state->descripcion;
        $reagent->desc_formato = $reagent->format->nombre;
        $reagent->desc_campo = $reagent->field->nombre;
        $reagent->desc_contenido = $reagent->contentDetail->capitulo." ".$reagent->contentDetail->tema;
        $reagent->usr_responsable = $this->getUserName($reagent->id_usr_responsable);
        $reagent->creado_por = $this->getUserName($reagent->creado_por);
        $reagent->modificado_por = $this->getUserName($reagent->modificado_por);

        $reagentQuestions = ReagentQuestion::query()->where('id_reactivo', $reagent->id)->orderBy('secuencia','asc')->get();
        $reagentAnswers = ReagentAnswer::query()->where('id_reactivo', $reagent->id)->orderBy('secuencia','asc')->get();
        $reagentComments = ReagentComment::query()->where('id_reactivo', $reagent->id)->orderBy('id','desc')->get();

        return view('reagent.reagents.edit')
            ->with('reagent', $reagent)
            ->with('questions', $reagentQuestions)
            ->with('answers', $reagentAnswers)
            ->with('comments', $reagentComments)
            ->with('states', $this->getReagentsStates())
            ->with('users', $this->getUsers())
            ->with('formatParam', $reagent->format)
            ->with('contents', $this->getContents())
            ->with('fields', $this->getFields());
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
        $reagent = Reagent::find($id);

        $reagent->id_contenido_det = $request->id_contenido_det;
        $reagent->planteamiento = $request->planteamiento;
        $reagent->imagen = $request->imagen;
        $reagent->id_opcion_correcta = $request->id_opcion_correcta;
        $reagent->id_campo = $request->id_campo;
        $reagent->descripcion = $request->descripcion;
        $reagent->referencia = $request->referencia;
        $reagent->modificado_por = \Auth::id();
        $reagent->fecha_modificacion = date('Y-m-d h:i:s');

        $formatParam = Format::find($reagent->id_formato);

        $nroOpRespMax = $formatParam->opciones_resp_max;
        $answersUpdateArray = array();
        $answersCreateArray = array();
        for($i = 1; $i <= $nroOpRespMax; $i++)
            if( isset( $request['desc_op_resp_'.$i] ) )
            {
                if($answer = ReagentAnswer::find($request->input('id_resp_'.$i))){
                    $answer->secuencia = $i;
                    $answer->descripcion = $request->input('desc_op_resp_'.$i);
                    $answer->argumento = $request->input('arg_op_resp_'.$i);
                    $answer->modificado_por = \Auth::id();
                    $answer->fecha_modificacion = date('Y-m-d h:i:s');
                    $answersUpdateArray[] = $answer;
                }else{
                    $answer['secuencia'] = $i;
                    $answer['descripcion'] = $request->input('desc_op_resp_'.$i);
                    $answer['argumento'] = $request->input('arg_op_resp_'.$i);
                    $answer['estado'] = 'A';
                    $answer['creado_por'] = \Auth::id();
                    $answer['fecha_creacion'] = date('Y-m-d h:i:s');
                    $answersCreateArray[] = new ReagentAnswer($answer);
                }
            }

        $nroOpPregMax = $formatParam->opciones_preg_max;
        $questionsUpdateArray = array();
        $questionsCreateArray = array();
        for($i = 1; $i <= $nroOpPregMax; $i++)
            if( isset( $request['conc_op_preg_'.$i] ) or isset( $request['prop_op_preg_'.$i] ) )
            {
                if($question = ReagentQuestion::find($request->input('id_preg_'.$i))){
                    $question->secuencia = $i;
                    $question->concepto = is_null($request->input('conc_op_preg_'.$i)) ? "" : $request->input('conc_op_preg_'.$i);
                    $question->propiedad = is_null($request->input('prop_op_preg_'.$i)) ? "" : $request->input('prop_op_preg_'.$i);
                    $question->modificado_por = \Auth::id();
                    $question->fecha_modificacion = date('Y-m-d h:i:s');
                    $questionsUpdateArray[] = $question;
                }else{
                    $question['secuencia'] = $i;
                    $question['concepto'] = is_null($request->input('conc_op_preg_'.$i)) ? "" : $request->input('conc_op_preg_'.$i);
                    $question['propiedad'] = is_null($request->input('prop_op_preg_'.$i)) ? "" : $request->input('prop_op_preg_'.$i);
                    $question['estado'] = 'A';
                    $question['creado_por'] = \Auth::id();
                    $question['fecha_creacion'] = date('Y-m-d h:i:s');
                    $questionsCreateArray[] = new ReagentQuestion($question);
                }

            }

        \DB::beginTransaction(); //Start transaction!

        try
        {
            $reagent->save();
            Reagent::find($reagent->id)->answers()->saveMany($answersUpdateArray);
            Reagent::find($reagent->id)->questions()->saveMany($questionsUpdateArray);
            Reagent::find($reagent->id)->answers()->saveMany($answersCreateArray);
            Reagent::find($reagent->id)->questions()->saveMany($questionsCreateArray);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reagent = Reagent::find($id);

        $reagent->id_estado = 7;
        $reagent->modificado_por = \Auth::id();
        $reagent->fecha_modificacion = date('Y-m-d h:i:s');
        $reagent->save();

        return redirect()->route('reagent.reagents.index');
    }
}
