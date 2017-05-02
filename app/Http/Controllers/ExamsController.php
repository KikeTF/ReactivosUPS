<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\ExamComment;
use ReactivosUPS\ExamDetail;
use ReactivosUPS\ExamHeader;
use ReactivosUPS\ExamPeriod;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Matter;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Mention;
use ReactivosUPS\Period;
use ReactivosUPS\PeriodLocation;
use ReactivosUPS\Reagent;
use ReactivosUPS\Report;
use Log;
use Ghidev\Fpdf\Fpdf;

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

            $exams = ExamHeader::query()->where('id_estado', '!=', 5)->get();

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
            $id_sede = (int)\Session::get('idSede');
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_periodo_sede = (isset($request['id_periodo_sede']) ? (int)$request->id_periodo_sede : 0);
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
                    $msg = "Existen materias que no cumplen con la cantidad de reactivos requeridos, por favor verificar: ";
                    $msg = $msg."<br/><small>".$spValResult[0]->message_detail."</small>";
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
            $exam->id_estado = 1;
            $exam->id_sede = $id_sede;
            $exam->id_periodo = PeriodLocation::find($id_periodo_sede)->id_periodo;
            $exam->id_periodo_sede = $id_periodo_sede;
            $exam->id_carrera_campus = $id_careerCampus;
            $exam->creado_por = \Auth::id();
            $exam->fecha_creacion = date('Y-m-d h:i:s');

            $periodsexam = array();
            foreach ($request->periodosSede as $periodLocation) {
                $periodExam['id_periodo_sede'] = $periodLocation;
                $periodsexam[] = new ExamPeriod($periodExam);
            }

            $comment = new ExamComment();
            $comment->id_estado_anterior = 1;
            $comment->id_estado_nuevo = 1;
            $comment->comentario = 'Examen creado: '.(isset($request['es_automatico']) ? 'Proceso Automatico' : 'Proceso Manual');
            $comment->creado_por = \Auth::id();
            $comment->fecha_creacion = date('Y-m-d h:i:s');

            \DB::beginTransaction();

            $exam->save();
            $exam->examPeriods()->saveMany($periodsexam);
            $comment->id_examen_cab = $exam->id;
            $comment->save();

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
        try
        {
            $exam = ExamHeader::find($id);
            $mentionsList = Mention::query()->where('id_carrera', $exam->id_carrera)->where('estado', 'A')->lists('descripcion','id');
            
            return view('exam.exams.show')
                ->with('mentionsList', $mentionsList)
                ->with('exam', $exam);
        }
        catch (\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsController][show] Exception: " . $ex);
            return redirect()->route('exam.exams.index');
        }
    }

    public function history($id)
    {
        try
        {
            $exam = ExamHeader::find($id);

            return view('exam.exams.history')
                ->with('states', $this->getReagentsStates())
                ->with('exam', $exam);
        }
        catch (\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsController][history] Exception: " . $ex);
            return redirect()->route('exam.exams.index');
        }
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
            $exam->modificado_por = \Auth::id();
            $exam->fecha_modificacion = date('Y-m-d h:i:s');

            $comment = new ExamComment();
            $comment->id_examen_cab = $exam->id;
            $comment->id_estado_anterior = $exam->id_estado;
            $comment->id_estado_nuevo = $exam->id_estado;
            $comment->comentario = 'Examen modificado: Informacion General.';
            $comment->creado_por = \Auth::id();
            $comment->fecha_creacion = date('Y-m-d h:i:s');

            \DB::beginTransaction();

            $exam->save();
            $comment->save();

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

        return redirect()->route('exam.exams.show', $id);
    }

    public function updateDetail(Request $request, $id)
    {
        $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
        $desc_materia = Matter::find($id_materia)->descripcion;
        $rea_nuevos = '';
        $rea_eliminados = '';

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
                    $rea_nuevos = implode(',', $newIdsDet);
                    $rea_eliminados = implode(',', $delIdsDet);

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
                        $comment = new ExamComment();
                        $comment->id_examen_cab = $exam->id;
                        $comment->id_estado_anterior = $exam->id_estado;
                        $comment->id_estado_nuevo = $exam->id_estado;
                        $comment->comentario = 'Examen modificado: Reactivos '.$desc_materia.'. Nuevos: '.$rea_nuevos.'; Eliminados: '.$rea_eliminados;
                        $comment->creado_por = \Auth::id();
                        $comment->fecha_creacion = date('Y-m-d h:i:s');

                        \DB::beginTransaction();
                        $exam->modificado_por = \Auth::id();
                        $exam->fecha_modificacion = date('Y-m-d h:i:s');
                        $exam->save();
                        $exam->examsDetails()->saveMany($examDetails);
                        $comment->save();
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
        try
        {
            $exam = ExamHeader::find($id);
            $comment = new ExamComment();

            $comment->id_examen_cab = $exam->id;
            $comment->id_estado_anterior = $exam->id_estado;
            $comment->id_estado_nuevo = 5;
            $comment->comentario = 'Examen eliminado.';
            $comment->creado_por = \Auth::id();
            $comment->fecha_creacion = date('Y-m-d h:i:s');

            $exam->id_estado = 6;
            $exam->modificado_por = \Auth::id();
            $exam->fecha_modificacion = date('Y-m-d h:i:s');

            \DB::beginTransaction();

            $exam->save();
            $comment->save();
        }
        catch (\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ExamsController][destroy] [id: $id]; Exception: " . $ex);
        }
        finally
        {
            \DB::commit();
        }

        return redirect()->route('exam.exams.index');
        
    }

    public function comment(Request $request, $id)
    {
        $valid = true;

        \DB::beginTransaction(); //Start transaction!

        try
        {
            $exam = ExamHeader::find($id);

            $comment = new ExamComment();
            $comment->id_examen_cab = $id;
            $comment->id_estado_anterior = $exam->id_estado;
            $comment->id_estado_nuevo = !isset( $request['id_estado'] ) ? $exam->id_estado : (int)$request->id_estado;
            $comment->comentario = $request->comentario;
            $comment->creado_por = \Auth::id();
            $comment->fecha_creacion = date('Y-m-d h:i:s');

            if( isset( $request['id_estado'] ) ){
                $exam->id_estado = (int)$request->id_estado;
                $exam->modificado_por = \Auth::id();
                $exam->fecha_modificacion = date('Y-m-d h:i:s');
            }

            $exam->save();
            $comment->save();
            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch(\Exception $ex)
        {
            //failed logic here
            \DB::rollback();
            $valid = false;
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ExamsController][comment] Request=". implode(", ", $request->all()) ."; id=".$id."; Exception: ".$ex);
        }

        \DB::commit();
        return array("valid"=>$valid);
    }
    
    public function printReport($id)
    {
        $exam = ExamHeader::find($id);
        $title = utf8_decode('UNIVERSIDAD POLITÉCNICA SALESIANA SEDE '.$exam->periodLocation->location->descripcion);
        $subtitle = utf8_decode('EXAMEN COMPLEXIVO');

        $pdf = new Report();
        //$pdf = new Fpdf();
        $pdf->AliasNbPages();
        $pdf->SetMargins(2,3);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(17, 0.7, $title, 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(17, 0.7, utf8_decode($exam->careerCampus->career->descripcion), 0, 1, 'C');
        $pdf->Cell(17, 0.7, $subtitle, 0, 1, 'C');
        $pdf->Cell(17, 0.7, utf8_decode($exam->periodLocation->period->descripcion), 0, 1, 'C');
        $pdf->Ln(1);

        $mattersIds = $exam->examsDetails->pluck('reagent')->pluck('id_materia');
        foreach($mattersIds as $id)
            $idsMat[] = $id;

        $mattersCareers = MatterCareer::query()->whereIn('id_materia', array_unique($idsMat))->get();

        foreach($mattersCareers as $matCar)
        {
            $matter = $matCar->matter;
            $arrCountRea = array_count_values($exam->examsDetails->pluck('reagent')->pluck('id_materia')->toArray());
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(17, 0.7, utf8_decode($matter->descripcion).' ('.$arrCountRea[$matter->id].')', 0, 1, 'L');

            $pdf->Ln(0.5);
            foreach ($exam->examsDetails as $det)
            {
                if($det->reagent->id_materia == $matter->id)
                {
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->MultiCell(17, 0.5 , $det->reagent->planteamiento, 0, 'J');

                    $maxOpPreg = max($det->reagent->questionsConcepts->count(), $det->reagent->questionsProperties->count());

                    if($maxOpPreg > 0)
                    {
                        $pdf->Ln(0.5);
                        for($i = 0; $i < $maxOpPreg; $i++)
                        {
                            if($det->reagent->questionsConcepts->count() > $i)
                            {
                                $conc = $det->reagent->questionsConcepts[$i];
                                $x = $pdf->GetX();
                                $y = $pdf->GetY();
                                $pdf->MultiCell(1, 0.5, $conc->numeral.'.', 0, 'R');
                                $pdf->SetXY($x+1,$y);

                                $x = $pdf->GetX();
                                $y = $pdf->GetY();
                                $pdf->MultiCell(6.5, 0.5, utf8_decode($conc->concepto), 0, 'J');
                                $pdf->SetXY($x+7.5,$y);
                            }

                            if($det->reagent->questionsProperties->count() > $i)
                            {
                                $prop = $det->reagent->questionsProperties[$i];
                                $x2 = $pdf->GetX();
                                $y2 = $pdf->GetY();
                                $pdf->MultiCell(1, 0.5, $prop->literal.'.', 0, 'R');
                                $pdf->SetXY($x2+1,$y2);

                                $x2 = $pdf->GetX();
                                $y2 = $pdf->GetY();
                                $pdf->MultiCell(6.5, 0.5, utf8_decode($prop->propiedad), 0, 'J');
                                //$pdf->SetXY($x,$y);
                            }

                            $pdf->Ln(0.5);
                        }
                    }

                    $pdf->Ln(0.5);
                    foreach($det->reagent->answers as $answ)
                        $pdf->Cell(17, 0.5, $answ->descripcion, 0, 1, 'L');

                    $pdf->Ln(1);
                }
            }

            $pdf->Ln(0.5);
        }

        $pdf->Output();
        exit;
    }
}
