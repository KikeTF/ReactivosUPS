<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Distributive;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Area;
use ReactivosUPS\Campus;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use ReactivosUPS\Career;
use ReactivosUPS\ReagentQuestion;
use ReactivosUPS\ReagentAnswer;
use ReactivosUPS\ReagentComment;
use ReactivosUPS\CareerCampus;
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
        try
        {
            $id_Sede = (int)\Session::get('idSede');
            $ids_carreras = \Session::get('idsCarreras');
            $ids_JefeAreas = \Session::get('idsJefeAreas');
            $aprReactivo = \Session::get('ApruebaReactivo');

            if( !($aprReactivo == 'S') )
            {
                flash("Su perfil no esta autorizado para esta opci&oacute;n!", 'warning')->important();
                return redirect()->route('index');
            }

            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
            $ids_areas = (sizeof($ids_JefeAreas) > 0) ? $ids_JefeAreas : (isset($request['id_area']) ? [(int)$request->id_area] : []);

            $mattersCareers = MatterCareer::with('careerCampus')
                ->whereHas('careerCampus', function($query) use($id_campus, $id_carrera, $ids_carreras){
                    if ($id_campus > 0) $query->where('id_campus', $id_campus);
                    if ($id_carrera > 0) $query->where('id_carrera', $id_carrera);
                    if (sizeof($ids_carreras) > 0) $query->whereIn('id_carrera', $ids_carreras);
                });

            if (sizeof($ids_areas) > 0)
                $mattersCareers = $mattersCareers->whereIn('id_area', $ids_areas);

            $ids_materias_carreras = $mattersCareers->get()->pluck('id')->toArray();

            $reagents = Reagent::with('distributive')
                ->where('id_estado', '!=', 7)
                ->whereHas('distributive', function($query) use($id_Sede, $id_campus, $id_carrera, $ids_carreras, $id_materia, $ids_materias_carreras){
                    $query->where('id_Sede', $id_Sede);
                    if ($id_campus > 0) $query->where('id_campus', $id_campus);
                    if ($id_carrera > 0) $query->where('id_carrera', $id_carrera);
                    elseif (sizeof($ids_carreras) > 0) $query->whereIn('id_carrera', $ids_carreras);
                    if ($id_materia > 0) $query->where('id_materia', $id_materia);
                    elseif (sizeof($ids_materias_carreras) > 0) $query->whereIn('id_materia_carrera', $ids_materias_carreras);
                })->orderBy('id', 'desc')->get();

            $filters = array($id_campus, $id_carrera, $id_materia);

            return view('reagent.approvals.index')
                ->with('reagents', $reagents)
                ->with('campusList', $this->getCampuses())
                ->with('filters', $filters);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsApprovalsController][index] Exception: ".$ex);
            return redirect()->route('reagent.approvals.index');
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
            $reagent->desc_contenido = $reagent->contentDetail->capitulo . " " . $reagent->contentDetail->tema;
            $reagent->usr_responsable = $this->getUserName($reagent->id_usr_responsable);
            $reagent->dificultad = ($reagent->dificultad == 'B') ? 'Baja' : ($reagent->dificultad == 'M') ? 'Media' : 'Alta';
            $reagent->desc_estado = $reagent->state->descripcion;
            $reagent->creado_por = $this->getUserName($reagent->creado_por);
            $reagent->modificado_por = $this->getUserName($reagent->modificado_por);

            return view('reagent.approvals.show')
                ->with('reagent', $reagent)
                //->with('questions', $reagentQuestions)
                //->with('answers', $reagentAnswers)
                //->with('comments', $reagentComments)
                ->with('states', $this->getReagentsStates())
                ->with('users', $this->getUsers());
                //->with('formatParam', $reagent->format);
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
        try
        {
            $ids = ($id > 0) ? array($id) : $request->ids;

            \DB::beginTransaction(); //Start transaction!

            foreach ($ids as $ReaId)
            {
                $reagent = Reagent::find($ReaId);

                $comment = new ReagentComment();
                $comment->id_reactivo = $ReaId;
                $comment->id_estado_anterior = $reagent->id_estado;
                $comment->id_estado_nuevo = !isset( $request['id_estado'] ) ? $reagent->id_estado : (int)$request->id_estado;
                $comment->comentario = $request->comentario;
                $comment->creado_por = \Auth::id();
                $comment->fecha_creacion = date('Y-m-d H:i:s');

                if( isset( $request['id_estado'] ) ){
                    $reagent->id_estado = (int)$request->id_estado;
                    $reagent->modificado_por = \Auth::id();
                    $reagent->fecha_modificacion = date('Y-m-d H:i:s');
                }

                $reagent->save();
                $comment->save();
            }

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch(\Exception $ex)
        {
            //failed logic here
            \DB::rollback();
            $valid = false;
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ReagentsApprovalsController][comment] id=".$id."; Exception: ".$ex);
        }

        \DB::commit();
        return array("valid"=>$valid);
    }
}
