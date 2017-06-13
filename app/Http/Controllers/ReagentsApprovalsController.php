<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

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
            $aprReactivo = \Session::get('ApruebaReactivo');
            if($aprReactivo == 'S')
            {
                $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
                $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
                $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
                $id_careerCampus = 0;
                $filters = array($id_campus, $id_carrera, $id_materia);
                $area = Area::query()->where('estado','A')->where('id_usuario_resp',\Auth::id());
                $id_area = ($area->count() > 0) ? $area->first()->id : 0;

                if($id_campus > 0 && $id_carrera > 0 && $id_materia > 0)
                {
                    $distributivo = $this->getDistributive($id_materia, $id_carrera, $id_campus);
                    $idsDist = array_unique($distributivo->pluck('id')->toArray());
                    $reagents = Reagent::filter($idsDist)->where('id_estado', '!=', 7);
                }
                else
                {
                    if($id_campus > 0 && $id_carrera > 0)
                        $id_careerCampus = CareerCampus::query()
                            ->where('estado','A')
                            ->where('id_carrera', $id_carrera)
                            ->where('id_campus', $id_campus)->first()->id;

                    $matters = MatterCareer::filter($id_careerCampus, 0, $id_area)->get();
                    $idsMat = array_unique($matters->pluck('id_materia')->ToArray());
                    $reagents = Reagent::query()->where('id_estado','!=',7)->whereIn('id_materia', $idsMat);
                }
            }
            else
            {
                flash("Su perfil no esta autorizado para esta opci&oacute;n!", 'warning')->important();
                return redirect()->route('dashboard.index');
            }

            if(isset($reagents))
            {
                $reagents = $reagents->orderBy('id', 'asc')->get();
                
                if($reagents->count() == 0)
                    flash("No se encontro informaci&oacute;n!", 'warning');
                
                return view('reagent.approvals.index')
                    ->with('reagents', $reagents)
                    ->with('campusList', $this->getCampuses())
                    ->with('filters', $filters);
            }
            else
                return view('reagent.approvals.index')
                    ->with('campusList', $this->getCampuses())
                    ->with('filters', $filters);

        }catch(\Exception $ex)
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
                $comment->fecha_creacion = date('Y-m-d h:i:s');

                if( isset( $request['id_estado'] ) ){
                    $reagent->id_estado = (int)$request->id_estado;
                    $reagent->modificado_por = \Auth::id();
                    $reagent->fecha_modificacion = date('Y-m-d h:i:s');
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
