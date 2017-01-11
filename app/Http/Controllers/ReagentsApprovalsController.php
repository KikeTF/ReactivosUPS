<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Matter;
use ReactivosUPS\Campus;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use ReactivosUPS\Career;
use ReactivosUPS\ReagentQuestion;
use ReactivosUPS\ReagentAnswer;
use ReactivosUPS\ReagentComment;
use Datatables;
use Log;

class ReagentsApprovalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            //$id_area = (isset($request['id_area']) ? (int)$request->id_area : 0);
            $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);

            $filters = array($id_campus, $id_carrera, $id_materia);

            if($id_campus > 0 && $id_carrera > 0 && $id_materia > 0){
                $id_distributivo = $this->getDistributive($id_materia, $id_carrera, $id_campus)->id;
                $reagents = Reagent::filter($id_distributivo)->where('id_estado','!=',7);
            }else
                $reagents = Reagent::query()->where('id_estado','!=',7);

            $reagents = $reagents->orderBy('id', 'desc')->get();

            return view('reagent.approvals.index')
                ->with('reagents', $reagents)
                ->with('campuses', $this->getCampuses())
                ->with('careers', $this->getCareers())
                ->with('matters', $this->getMatters())
                ->with('states', $this->getReagentsStates())
                ->with('statesLabels', $this->getReagentsStatesLabel())
                ->with('filters', $filters);
        }catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsApprovalsController][index] Request=".implode(", ", $request->all())."; Exception: ".$ex);
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
        return redirect()->route('reagent.approvals.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('reagent.approvals.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
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

            return view('reagent.approvals.show')
                ->with('reagent', $reagent)
                ->with('questions', $reagentQuestions)
                ->with('answers', $reagentAnswers)
                ->with('comments', $reagentComments)
                ->with('states', $this->getReagentsStates())
                ->with('users', $this->getUsers())
                ->with('formatParam', $reagent->format);
        }catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsApprovalsController][show] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('reagent.approvals.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return redirect()->route('reagent.approvals.index');
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
        return redirect()->route('reagent.approvals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->route('reagent.approvals.index');
    }

    public function comment(Request $request, $id)
    {
        $valid = true;
        $reagent = Reagent::find($id);

        \DB::beginTransaction(); //Start transaction!

        try
        {
            $comment = new ReagentComment();
            $comment->id_reactivo = $id;
            $comment->id_estado_anterior = $reagent->id_estado;
            $comment->id_estado_nuevo = !isset( $request['id_estado'] ) ? $reagent->id_estado : (int)$request->id_estado;
            $comment->comentario = $request->comentario;
            $comment->creado_por = \Auth::id();
            $comment->fecha_creacion = date('Y-m-d h:i:s');

            if( isset( $request['id_estado'] ) ){
                $reagent->id_estado = (int)$request->id_estado;
                $reagent->modificado_por = \Auth::id();
                $reagent->fecha_modificacion = date('Y-m-d h:i:s');
            }

            $reagent->save();
            $comment->save();
            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch(\Exception $ex)
        {
            //failed logic here
            \DB::rollback();
            $valid = false;
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ReagentsApprovalsController][comment] Request=". implode(", ", $request->all()) ."; id=".$id."; Exception: ".$ex);
        }

        \DB::commit();
        return array("valid"=>$valid);
    }
}
