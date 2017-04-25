<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\ExamDetail;
use ReactivosUPS\ExamHeader;
use ReactivosUPS\ExamPeriod;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Matter;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Mention;
use ReactivosUPS\Period;
use ReactivosUPS\PeriodLocation;
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

            $exams = ExamHeader::query()->where('estado', '!=', 'E')->get();

            return view('exam.exams.index')
                ->with('exams', $exams);
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
                ->with('locationPeriodsList', $this->getLocationPeriods());

        } catch (\Exception $ex) {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ExamsController][create] Exception: " . $ex);
            return redirect()->route('exam.exams.index');
        }
    }

    public function detail(Request $request, $id, $id_matter)
    {
        try
        {
            $id_materia = (int)$id_matter;
            $exam = ExamHeader::find($id);

            $periodLoc = PeriodLocation::query()->whereIn('id', $exam->examPeriods->pluck('id_periodo_sede')->toArray())->get();

            $reagents = Reagent::query()
                ->where('id_estado','5')
                ->whereIn('id_sede', array_unique($periodLoc->pluck('id_sede')->toArray()))
                ->whereIn('id_periodo', array_unique($periodLoc->pluck('id_periodo')->toArray()))
                ->where('id_campus', $exam->id_campus)
                ->where('id_carrera', $exam->id_carrera)
                ->where('id_materia', $id_materia)->get();

            $mentionsList = Mention::query()->where('id_carrera', $exam->id_carrera)->where('estado', 'A')->lists('descripcion','id');
            $matterParameters = $this->getMatterParameters(0, $exam->id_carrera, $exam->id_campus);
            $cantidadReactivos = 0;

            if($id_materia > 0)
            {
                $selectedMatter = $matterParameters->where('id_materia', $id_materia)->first();

                if($selectedMatter->nro_reactivos_exam <= 0)
                {
                    flash("No se requieren reactivos para la materia seleccionada.", 'danger')->important();
                    return redirect()->route('exam.exams.detail', ['id' => $id, 'id_matter' => 0]);
                }

                if($selectedMatter->aplica_examen != 'S')
                {
                    flash("La materia seleccionada no aplica para el examen.", 'danger')->important();
                    return redirect()->route('exam.exams.detail', ['id' => $id, 'id_matter' => 0]);
                }

                foreach($exam->examsDetails as $det)
                {
                    if($det->reagent->id_materia == $id_materia)
                        $cantidadReactivos++;
                }
                //$matterParameters = $this->getMatterParameters($id_materia, $exam->id_carrera, $exam->id_campus);
                $selectedMatter->cantidad_reactivos = $cantidadReactivos;
            }

            if(!isset($selectedMatter))
            {
                $selectedMatter = new MatterCareer();
                $selectedMatter->id_materia = 0;
            }

            return view('exam.exams.detail')
                ->with('selectedMatter', $selectedMatter)
                ->with('reagents', $reagents)
                ->with('exam', $exam)
                ->with('mentionsList', $mentionsList)
                ->with('matterParameters', $matterParameters);

        }
        catch (\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsController][create] Exception: " . $ex);
            return redirect()->route('exam.exams.edit', $id);
        }
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

            $valStmt = 'CALL sp_exc_valida_reactivos('.$id_careerCampus.', '."'".implode(",", $request->periodosSede)."'".')';
            \DB::connection()->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $spVal = \DB::connection()->getpdo()->prepare($valStmt);
            $spVal->execute();
            $spValResult = $spVal->fetchAll(\DB::connection()->getFetchMode());

            if(strcmp(strtoupper($spValResult[0]->return_message), "OK") !== 0)
            {
                if(strcmp(strtoupper($spValResult[0]->return_message), "ERROR") == 0)
                {
                    $msg = "Existen materias que no cumplen con la cantidad de reactivos requeridos, por favor verificar: ".$spValResult[0]->message_detail;
                    flash($msg, 'warning')->important();
                    Log::error("[ExamsController][store][Generacion Automatica de Examen] id_carrera_campus=".$id_careerCampus."; id_periodo_sede=".implode(",", $request->periodosSede)."; Error=".$msg);
                    return redirect()->route('exam.exams.create');
                }
                else
                {
                    Log::error("[ExamsController][store][Generacion Automatica de Examen] id_carrera_campus=".$id_careerCampus."; id_periodo_sede=".implode(",", $request->periodosSede)."; Error=".$spValResult[0]->return_message);
                    flash('No fue posible completar la transaccion', 'danger')->important();
                    return redirect()->route('exam.exams.index');
                }
            }

            $exam = new ExamHeader($request->all());
            $exam->es_prueba = !isset( $request['es_prueba'] ) ? 'N' : 'S';
            $exam->estado = 'A';
            $exam->id_sede = (int)\Session::get('idSede');
            $exam->id_periodo = (int)\Session::get('idPeriodo');
            $exam->id_periodo_sede = (int)\Session::get('idPeriodoSede');
            $exam->id_carrera_campus = $id_careerCampus;
            $exam->creado_por = \Auth::id();
            $exam->fecha_creacion = date('Y-m-d h:i:s');

            $periodsexam = array();
            foreach ($request->periodosSede as $periodLocation) {
                $periodExam['id_periodo_sede'] = $periodLocation;
                $periodsexam[] = new ExamPeriod($periodExam);
            }

            \DB::beginTransaction();

            $exam->save();
            $exam->examPeriods()->saveMany($periodsexam);

            if( isset($request['es_automatico']) ){
                try
                {
                    $stmt = 'CALL sp_exc_genera_examen('.$exam->id.', '.$exam->id_carrera_campus.', '.\Auth::id().')';
                    \DB::connection()->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
                    $sp = \DB::connection()->getpdo()->prepare($stmt);
                    $sp->execute();
                    $spResult = $sp->fetchAll(\DB::connection()->getFetchMode());

                    if(strcmp(strtoupper($spResult[0]->return_message), "OK") !== 0)
                    {
                        flash("No fue posible la generaci&oacute;n autom&aacute;tica del examen.", 'warning')->important();
                        Log::error("[ExamsController][store][Generacion Automatica de Examen] id_examen=".$exam->id."; id_carrera_campus=".$exam->id_carrera_campus."; id_usuario=".\Auth::id()."; Error=".$spResult[0]->return_message);
                    }
                }
                catch (\Exception $ex)
                {
                    flash("No fue posible la generaci&oacute;n autom&aacute;tica del examen.", 'warning')->important();
                    Log::error("[ExamsController][store] Request=; Exception: ".$ex);
                }
            }

            flash('Transacci&oacuten realizada existosamente', 'success');
            return redirect()->route('exam.exams.detail',['id' => $exam->id, 'id_matter' => 0]);
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            \DB::rollback();
            Log::error("[ExamsController][store] Exception: ".$ex);
            return redirect()->route('exam.exams.create');
        }
        finally
        {
            \DB::commit();
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
        try {
            $exam = ExamHeader::find($id);

            return view('exam.exams.edit')
                ->with('exam', $exam);

        } catch (\Exception $ex) {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ExamsController][edit] Datos: [id: $id] Exception: " . $ex);
            return redirect()->route('exam.exams.index');
        }
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
        try
        {
            $exam = ExamHeader::find($id);

            $exam->descripcion = $request->descripcion;
            $exam->fecha_activacion = $request->fecha_activacion;
            $exam->es_prueba = !isset( $request['es_prueba'] ) ? 'N' : 'S';
            $exam->estado = !isset( $request['estado'] ) ? 'I' : 'A';

            \DB::beginTransaction();

            $exam->save();
            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            \DB::rollback();
            Log::error("[ExamsController][update] [id: $id]; Exception: " . $ex);
        }
        finally
        {
            \DB::commit();
        }

        return redirect()->route('exam.exams.edit', $id);
    }

    public function updateDetail(Request $request, $id)
    {
        $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);

        try
        {
            $exam = ExamHeader::find($id);

            $matterParameters = $this->getMatterParameters($id_materia, $exam->id_carrera, $exam->id_campus);
            $reaCount = isset($request->id_reactivo) ? sizeof($request->id_reactivo) : 0;
            $reaTotal = $matterParameters->nro_reactivos_exam;

            if($reaCount <= $reaTotal)
            {
                foreach($exam->examsDetails as $det)
                {
                    if($det->estado == 'A' && $det->reagent->id_materia == $id_materia)
                        $ids[] = $det->id_reactivo;
                }

                $idsDet = isset($ids) ? $ids : array();
                $idsReq = isset($request->id_reactivo) ? $request->id_reactivo : array();

                if( !($idsDet == $idsReq) )
                {
                    $newIdsDet = array_diff($idsReq, $idsDet); //nuevos
                    $delIdsDet = array_diff($idsDet, array_intersect($idsDet, $idsReq)); //eliminados

                    if(sizeof($delIdsDet) > 0)
                    {
                        foreach($delIdsDet as $det)
                        {
                            $examDet = ExamDetail::query()->where('id_examen_cab', $id)->where('id_reactivo', $det)->first();
                            $examDet->estado = 'E';
                            $examDet->modificado_por =  \Auth::id();
                            $examDet->fecha_modificacion =  date('Y-m-d h:i:s');
                            $examDetails[] = $examDet;
                        }
                    }

                    if(sizeof($newIdsDet) > 0)
                    {
                        foreach($newIdsDet as $det)
                        {
                            if(ExamDetail::query()->where('id_examen_cab', $id)->where('id_reactivo', $det)->count() > 0)
                            {
                                $examDet = ExamDetail::query()->where('id_examen_cab', $id)->where('id_reactivo', $det)->first();
                                $examDet->estado = 'A';
                                $examDet->modificado_por =  \Auth::id();
                                $examDet->fecha_modificacion =  date('Y-m-d h:i:s');
                            }
                            else
                            {
                                $detail['id_examen_cab'] = $id;
                                $detail['id_reactivo'] = $det;
                                $detail['estado'] = 'A';
                                $examDet = new ExamDetail($detail);
                                $examDet->creado_por =  \Auth::id();
                                $examDet->fecha_creacion =  date('Y-m-d h:i:s');
                            }
                            $examDetails[] = $examDet;
                        }
                    }
                }

                if(isset($examDetails))
                {
                    try
                    {
                        \DB::beginTransaction();
                        $exam->examsDetails()->saveMany($examDetails);
                        flash('Transacci&oacuten realizada existosamente', 'success');
                    }
                    catch (\Exception $ex)
                    {
                        \DB::rollback();
                        flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
                        Log::error("[ExamsController][updateDetail] [id: $id]; Exception: " . $ex);
                    }
                    finally
                    {
                        \DB::commit();
                    }
                }
                else
                    flash("No se han realizado modificaciones", 'info');
            }
            else
                flash("Ha excedido el l&iacute;mite de reactivos permitidos para esta materia. Debe seleccionar $reaTotal reactivo(s).", 'danger')->important();
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ExamsController][updateDetail] [id: $id]; Exception: " . $ex);
            return redirect()->route('exam.exams.detail', ['id' => $id, 'id_matter' => 0]);
        }

        return redirect()->route('exam.exams.detail', ['id' => $id, 'id_matter' => $id_materia]);
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
