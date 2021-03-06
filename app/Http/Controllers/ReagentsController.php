<?php

/**
 * NOMBRE DEL ARCHIVO   ReagentsController.php
 *
 * TIPO                 Controlador
 *
 * DESCRIPCIÓN          Gestiona la consulta, creación, modificación
 *                      y eliminación de reactivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\ContentHeader;
use ReactivosUPS\Format;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use ReactivosUPS\ReagentAnswer;
use ReactivosUPS\Distributive;
use ReactivosUPS\Report;
use Log;
use ReactivosUPS\ReagentQuestionConcept;
use ReactivosUPS\ReagentQuestionProperty;
use View;
use Illuminate\Support\Facades\File;
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
        try
        {
            // Variables de Session
            $id_Sede = (int)\Session::get('idSede');
            $ids_carreras = \Session::get('idsCarreras');
            $aprReactivo = \Session::get('ApruebaReactivo');

            // Valida si tiene acceso a la pagina
            if( ($aprReactivo == 'S') )
            {
                flash("Su perfil no esta autorizado para esta opci&oacute;n!", 'warning')->important();
                return redirect()->route('index');
            }

            // Datos del $request enviado desde la vista
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
            $id_estado = (isset($request['id_estado']) ? (int)$request->id_estado : 0);

            $reagents = Reagent::with('distributive')
                ->where('id_estado', '!=', 7)
                ->where('creado_por', \Auth::id())
                ->whereHas('distributive', function($query) use($id_Sede, $id_campus, $id_carrera, $ids_carreras, $id_materia){
                    $query->where('id_Sede', $id_Sede);
                    if ($id_campus > 0) $query->where('id_campus', $id_campus);
                    if ($id_carrera > 0) $query->where('id_carrera', $id_carrera);
                    elseif (sizeof($ids_carreras) > 0) $query->whereIn('id_carrera', $ids_carreras);
                    if ($id_materia > 0) $query->where('id_materia', $id_materia);
                });

            if ($id_estado > 0)
                $reagents = $reagents->where('id_estado', $id_estado);

            $reagents = $reagents->orderBy('id', 'desc')->get();

            $filters = array($id_campus, $id_carrera, $id_materia, $id_estado);

            return view('reagent.reagents.index')
                ->with('reagents', $reagents)
                ->with('campusList', $this->getCampuses())
                ->with('states', $this->getReagentsStates())
                ->with('statesLabels', $this->getReagentsStatesLabel())
                ->with('filters', $filters);
        }
        catch (\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsController][index] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
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
        try 
        {
            return view('reagent.reagents.create')
                ->with('campusList', $this->getCampuses())
                ->with('fields', $this->getFields())
                ->with('formats', $this->getFormats());
        } 
        catch (\Exception $ex) 
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsController][create] Exception: " . $ex);
            return redirect()->route('reagent.reagents.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            // Variables de Session
            $id_periodo = (int)Session::get('idPeriodo');
            $id_sede = (int)Session::get('idSede');

            $reagent = new Reagent($request->all());
            $reagent->id_periodo = $id_periodo;
            $reagent->id_sede = $id_sede;
            $reagent->creado_por = \Auth::id();

            $reagent->id_distributivo = Distributive::query()
                ->where('estado','A')
                ->where('id_periodo', $id_periodo)
                ->where('id_carrera', $request->id_carrera)
                ->where('id_campus', $request->id_campus)
                ->where('id_sede', $id_sede)
                ->where('id_materia', $request->id_materia)
                ->where('id_usuario', \Auth::id())
                ->first()->id;

            Log::debug("Reagent create: answers create");
            $reaAnswers = array();
            for ($i = 0; $i < sizeof($request->answers); $i++)
            {
                $reqAnswer = $request->answers[$i];
                //$answer['numeral'] = $reqAnswer['numeral'];
                $answer['descripcion'] = $reqAnswer['descripcion'];
                $answer['argumento'] = $reqAnswer['argumento'];
                $answer['opcion_correcta'] = ($this->abc[$i] == $request->input('opcion_correcta')) ? 'S' : 'N';
                $answer['creado_por'] = \Auth::id();
                $reaAnswer = new ReagentAnswer($answer);
                $reaAnswers[] = $reaAnswer;
            }

            Log::debug("Reagent create: questions concepts create");
            $reaQuestionsConc = array();
            for ($i = 0; $i < sizeof($request->questionsConc); $i++)
            {
                $reqQuestion = $request->questionsConc[$i];
                //$question['numeral'] = $reqQuestion['numeral'];
                $question['concepto'] = $reqQuestion['concepto'];
                $question['creado_por'] = \Auth::id();
                $reaQuestion = new ReagentQuestionConcept($question);
                $reaQuestionsConc[] = $reaQuestion;
            }

            Log::debug("Reagent create: questions properties create");
            $reaQuestionsProp = array();
            for ($i = 0; $i < sizeof($request->questionsProp); $i++)
            {
                $reqQuestion = $request->questionsProp[$i];
                //$question['literal'] = $reqQuestion['literal'];
                $question['propiedad'] = $reqQuestion['propiedad'];
                $question['creado_por'] = \Auth::id();
                $reaQuestion = new ReagentQuestionProperty($question);
                $reaQuestionsProp[] = $reaQuestion;
            }

            $reagent->imagen = 'N';
            $isValidImage = (bool)false;
            if ( isset($request['file']) && $request->hasFile('file') )
            {
                $file = $request->file('file');
                if ( $file->isValid() )
                {
                    $reagent->imagen = 'S';
                    $isValidImage = (bool)true;
                }
            }

            $reagent->fecha_creacion = date('Y-m-d H:i:s');

            \DB::beginTransaction(); //Start transaction!

            Log::debug("Reagent create: save reagent model");
            $reagent->save();

            Log::debug("Reagent create: save reagent answers model");
            //Reagent::find($reagent->id)
            $reagent->answers()->saveMany($reaAnswers);


            Log::debug("Reagent create: save questions concepts model");
            $reagent->questionsConcepts()->saveMany($reaQuestionsConc);

            Log::debug("Reagent create: save questions properties model");
            $reagent->questionsProperties()->saveMany($reaQuestionsProp);

            Log::debug("Reagent create: save reagent right answer id");
            $reagent->id_opcion_correcta = $reagent->answers()->where('opcion_correcta', 'S')->first()->id;
            $reagent->save();

            if ( $isValidImage )
            {
                $fileName = 'UPS-REA-'.$reagent->id.'.'.$request->file('file')->getClientOriginalExtension();
                $request->file('file')->move(base_path().'/storage/files/reagents/', $fileName);
            }

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            //failed logic here
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ReagentsController][store] Exception: " . $ex);
            return redirect()->route('reagent.reagents.create');
        }
        finally
        {
            \DB::commit();
        }

        return redirect()->route('reagent.reagents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try 
        {
            $reagent = Reagent::find($id);

            return view('reagent.reagents.show')
                ->with('reagent', $reagent);
            
        } 
        catch (\Exception $ex) {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsController][show] id=" . $id . ". Exception: " . $ex);
            return redirect()->route('reagent.reagents.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try 
        {
            $reagent = Reagent::find($id);

            if ( !in_array($reagent->id_estado, array(1, 4)) )
            {
                flash("Este reactivo no puede ser modificado!", 'warning');
                return redirect()->route('reagent.reagents.show', $reagent->id);
            }

            $matterContent = ContentHeader::query()
                ->where('estado','A')
                ->where('id_materia_carrera', $reagent->distributive->id_materia_carrera)
                ->first()->contentsDetails
                    ->where('estado','A')
                    ->sortBy('capitulo')
                    ->lists('ContentDescription', 'id');

            return view('reagent.reagents.edit')
                ->with('reagent', $reagent)
                ->with('questionsConc', $reagent->questionsConcepts)
                ->with('questionsProp', $reagent->questionsProperties)
                ->with('answers', $reagent->answers)
                ->with('format', $reagent->format)
                ->with('contents', $matterContent)
                ->with('fields', $this->getFields())
                ->with('abc', $this->abc);

        } 
        catch (\Exception $ex) 
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsController][edit] id=" . $id . ". Exception: " . $ex);
            return redirect()->route('reagent.reagents.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $reagent = Reagent::find($id);

            Log::debug("Reagent update: fill request");
            $reagent->fill($request->all());

            if ( isset($request->answers) )
            {
                Log::debug("Reagent update: answers update");
                foreach($request->answers as $i => $reqAnswer)
                {
                    $reaAnswer = (isset($reqAnswer['id']) && ($reqAnswer['id'] != "")) ? ReagentAnswer::find($reqAnswer['id']) : null;
                    if ($reaAnswer != null)
                    {
                        Log::debug("Reagent update: answer update id: ".$reqAnswer['id']);
                        //$reaAnswer->numeral = $reqAnswer['numeral'];
                        $reaAnswer->descripcion = $reqAnswer['descripcion'];
                        $reaAnswer->argumento = $reqAnswer['argumento'];
                        //$reaAnswer->opcion_correcta = ($reqAnswer['numeral'] == $request->input('opcion_correcta')) ? 'S' : 'N';
                        $reaAnswer->opcion_correcta = ($this->abc[$i] == $request->input('opcion_correcta')) ? 'S' : 'N';
                        $reaAnswer->modificado_por = \Auth::id();
                        $reaAnswer->fecha_modificacion = date('Y-m-d H:i:s');
                    }
                    elseif (isset($reqAnswer['descripcion']) && isset($reqAnswer['argumento']))
                    {
                        Log::debug("Reagent update: new answer create");
                        $answer['id_reactivo'] = $id;
                        //$answer['numeral'] = $reqAnswer['numeral'];
                        $answer['descripcion'] = $reqAnswer['descripcion'];
                        $answer['argumento'] = $reqAnswer['argumento'];
                        //$answer['opcion_correcta'] = ($reqAnswer['numeral'] = $request->input('opcion_correcta')) ? 'S' : 'N';
                        $answer['opcion_correcta'] = ($this->abc[$i] == $request->input('opcion_correcta')) ? 'S' : 'N';
                        $answer['creado_por'] = \Auth::id();
                        $answer['fecha_creacion'] = date('Y-m-d H:i:s');
                        $reaAnswer = new ReagentAnswer($answer);
                    }

                    if(isset($reaAnswer))
                        $reaAnswers[] = $reaAnswer;
                }
            }

            if ( isset($request->questionsConc) )
            {
                Log::debug("Reagent update: questions concepts update");
                foreach($request->questionsConc as $i => $reqQuestion)
                {
                    $reaQuestionConc = (isset($reqQuestion['id']) && ($reqQuestion['id'] != "")) ? ReagentQuestionConcept::find($reqQuestion['id']) : null;
                    if ($reaQuestionConc != null)
                    {
                        Log::debug("Reagent update: question concept update id: ".$reqQuestion['id']);
                        //$reaQuestion->numeral = $reqQuestion['numeral'];
                        $reaQuestionConc->concepto = $reqQuestion['concepto'];
                        $reaQuestionConc->modificado_por = \Auth::id();
                        $reaQuestionConc->fecha_modificacion = date('Y-m-d H:i:s');
                    }
                    elseif (isset($reqQuestion['concepto']))
                    {
                        Log::debug("Reagent update: new question concept create");
                        $question['id_reactivo'] = $id;
                        //$question['numeral'] = $reqQuestion['numeral'];
                        $question['concepto'] = $reqQuestion['concepto'];
                        $question['creado_por'] = \Auth::id();
                        $question['fecha_creacion'] = date('Y-m-d H:i:s');
                        $reaQuestionConc = new ReagentQuestionConcept($question);
                    }

                    if(isset($reaQuestionConc))
                        $reaQuestionsConc[] = $reaQuestionConc;
                }
            }

            if ( isset($request->questionsProp) )
            {
                Log::debug("Reagent update: questions properties update");
                foreach($request->questionsProp as $i => $reqQuestion)
                {
                    $reaQuestionProp = (isset($reqQuestion['id']) && ($reqQuestion['id'] != "")) ? ReagentQuestionProperty::find($reqQuestion['id']) : null;
                    if ($reaQuestionProp != null)
                    {
                        Log::debug("Reagent update: question property update id: ".$reqQuestion['id']);
                        //$reaQuestion->literal = $reqQuestion['literal'];
                        $reaQuestionProp->propiedad = $reqQuestion['propiedad'];
                        $reaQuestionProp->modificado_por = \Auth::id();
                        $reaQuestionProp->fecha_modificacion = date('Y-m-d H:i:s');
                    }
                    elseif (isset($reqQuestion['propiedad']))
                    {
                        Log::debug("Reagent update: new question property create");
                        $question['id_reactivo'] = $id;
                        //$question['literal'] = $reqQuestion['literal'];
                        $question['propiedad'] = $reqQuestion['propiedad'];
                        $question['creado_por'] = \Auth::id();
                        $question['fecha_creacion'] = date('Y-m-d H:i:s');
                        $reaQuestionProp = new ReagentQuestionProperty($question);
                    }

                    if(isset($reaQuestionProp))
                        $reaQuestionsProp[] = $reaQuestionProp;
                }
            }

            $isValidImage = (bool)false;
            if ( isset($request['file']) && $request->hasFile('file') )
            {
                $file = $request->file('file');
                if ( $file->isValid() )
                {
                    $reagent->imagen = 'S';
                    $isValidImage = (bool)true;
                }
            }

            $reagent->modificado_por = \Auth::id();
            $reagent->fecha_modificacion = date('Y-m-d H:i:s');

            \DB::beginTransaction(); //Start transaction!

            Log::debug("Reagent update: save reagent model");
            $reagent->save();

            if(isset($reaAnswers))
            {
                Log::debug("Reagent update: save reagent answers model");
                $reagent->answers()->saveMany($reaAnswers);
                $reagent->answers()->whereNotIn('id', array_pluck($reaAnswers, 'id'))->delete();
            }

            if(isset($reaQuestionsConc))
            {
                Log::debug("Reagent update: save questions concepts model");
                $reagent->questionsConcepts()->saveMany($reaQuestionsConc);
                $reagent->questionsConcepts()->whereNotIn('id', array_pluck($reaQuestionsConc, 'id'))->delete();
            }

            if(isset($reaQuestionsProp))
            {
                Log::debug("Reagent update: save questions properties model");
                $reagent->questionsProperties()->saveMany($reaQuestionsProp);
                $reagent->questionsProperties()->whereNotIn('id', array_pluck($reaQuestionsProp, 'id'))->delete();
            }

            Log::debug("Reagent create: save reagent right answer id");
            $reagent->id_opcion_correcta = $reagent->answers()->where('opcion_correcta', 'S')->first()->id;
            $reagent->save();

            if ( $isValidImage )
            {
                $fileName = 'UPS-REA-'.$reagent->id.'.'.$request->file('file')->getClientOriginalExtension();
                $request->file('file')->move(base_path().'/storage/files/reagents/', $fileName);
            }
            elseif ($reagent->imagen == 'N')
            {
                $extensionList = array('gif','png','jpg','jpeg','bmp');
                foreach ($extensionList as $ext)
                {
                    $file = storage_path('files/reagents/UPS-REA-'.$id.'.'.$ext);
                    if ( File::exists($file) ) {
                        File::delete($file);
                        break;
                    }
                }
            }

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            //failed logic here
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ReagentsController][update] id=" . $id . "; Exception: " . $ex);
            return redirect()->route('reagent.reagents.edit', $id);
        }
        finally
        {
            \DB::commit();
        }

        return redirect()->route('reagent.reagents.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try
        {
            $reagent = Reagent::find($id);

            if ( !in_array($reagent->id_estado, array(1, 4)) )
            {
                flash("Este reactivo no puede ser eliminado!", 'warning');
                return redirect()->route('reagent.reagents.show', $reagent->id);
            }

            $reagent->id_estado = 7;
            $reagent->modificado_por = \Auth::id();
            $reagent->fecha_modificacion = date('Y-m-d H:i:s');
            $reagent->save();
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ReagentsController][destroy] Datos: id=" . $id . ". Exception: " . $ex);
        }

        return redirect()->route('reagent.reagents.index');
    }

    /**
     * Valida si existe archivo de contenidos de la materia.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function matterContent(Request $request)
    {
        try
        {
            // Obtiene datos enviados desde la pagina
            $id_campus = isset($request['id_campus']) ? (int)$request->id_campus : 0; 
            $id_carrera = isset($request['id_carrera']) ? (int)$request->id_carrera : 0;
            $id_materia = isset($request['id_materia']) ? (int)$request->id_materia : 0;
            
            if($id_materia > 0 && $id_carrera > 0 && $id_campus > 0)
            {
                $matterCareer = MatterCareer::with('careerCampus')
                    ->where('id_materia', $id_materia)
                    ->whereHas('careerCampus', function($query) use($id_carrera, $id_campus){
                        $query->where('id_campus', $id_campus);
                        $query->where('id_carrera', $id_carrera);
                    })->first();

                $file = storage_path().'/files/matters/UPS-MAT-'.$matterCareer->id.'.pdf';

                if ( file_exists($file) )
                    $message = 'OK';
                else
                    $message = 'Archivo no encontrado o no existe!';
            }
            else
                $message = 'Debe seleccionar una materia para continuar!';
        }
        catch(\Exception $ex)
        {
            Log::error("[ReagentsController][matterContent] Exception: ".$ex);
            $message = 'Problemas al descargar el archivo. Consulte con el administrador!';
        }

        $headers = array('Content-Type: application/json',);
        return \Response::json(['message' => $message], 200, $headers);
    }

    /**
     * Obtiene la seccion de registro de reactivo de acuerdo al formato seleccionado.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getFormat(Request $request)
    {
        try {
            $id_formato = $request->id_formato;
            $format = Format::find($id_formato);
            $html = View::make('reagent.reagents._format')
                ->with('format', $format)
                ->with('abc', $this->abc)->render();
        } catch (\Exception $ex) {
            $html = "Informaci&oacute;n no disponibles";
            Log::error("[ReagentsController][getFormat] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
        }
        return \Response::json(['html' => $html]);
    }

    /**
     * Imprime reporte de reactivos en PDF.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function printReport(Request $request, $id)
    {
        try
        {
            $ids = ($id > 0) ? array($id) : (isset($request->ids) ? explode(",", substr($request->ids,1,strlen($request->ids)-2)) : array());

            $pdf = new Report();
            $pdf->headerTitle = 'REACTIVOS';
            $pdf->headerSubtitle = '';
            $pdf->headerSubtitle2 = '';
            $pdf->SetTitle('Reactivos');
            $pdf->AliasNbPages();
            $pdf->SetMargins(2,3);
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);

            //$pdf->Ln(0.5);

            foreach ($ids as $iRea => $ReaId)
            {
                $reagent = Reagent::find($ReaId);

                if ($reagent == null)
                {
                    flash("No se pudo cargar el reporte", 'danger')->important();
                    return redirect()->route('reagent.reagents.index');
                }

                //$pdf->SetFont('Arial', 'B', 14);
                //$pdf->Cell(17, 0.7, "REACTIVO NO. ".$reagent->id, 0, 1, 'L');

                //$pdf->Ln(0.3);

                $AnchoCol1 = 4;
                $AnchoCol2 = 17-$AnchoCol1;

                $pdf->SetFont('Arial', 'B', 10);
                $posX = $pdf->GetX();
                $posY = $pdf->GetY();
                $pdf->MultiCell($AnchoCol1, 0.7, 'MATERIA', 1, 'L');
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetXY($posX+$AnchoCol1, $posY);
                $pdf->MultiCell($AnchoCol2, 0.7, $reagent->distributive->matterCareer->matter->descripcion, 1, 'L');

                $pdf->SetFont('Arial', 'B', 10);
                $posX = $pdf->GetX();
                $posY = $pdf->GetY();
                $pdf->MultiCell($AnchoCol1, 0.7, 'RESPONSABLE', 1, 'L');
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetXY($posX+$AnchoCol1, $posY);
                $pdf->MultiCell($AnchoCol2, 0.7, $reagent->user->FullName, 1, 'L');

                $pdf->SetFont('Arial', 'B', 10);
                $posX = $pdf->GetX();
                $posY = $pdf->GetY();
                $pdf->MultiCell($AnchoCol1, 0.7, 'ESTADO', 1, 'L');
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetXY($posX+$AnchoCol1, $posY);
                $pdf->MultiCell($AnchoCol2, 0.7, $reagent->state->descripcion, 1, 'L');

                $pdf->SetFont('Arial', 'B', 10);
                $posX = $pdf->GetX();
                $posY = $pdf->GetY();
                $pdf->MultiCell($AnchoCol1, 0.7, 'FORMATO', 1, 'L');
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetXY($posX+$AnchoCol1, $posY);
                $pdf->MultiCell($AnchoCol2, 0.7, $reagent->format->nombre, 1, 'L');

                $posX = $pdf->GetX();
                $posY = $pdf->GetY();
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetXY($posX+$AnchoCol1, $posY);
                $pdf->MultiCell($AnchoCol2, 0.7, $reagent->contentDetail->ContentDescription, 1, 'L');
                $newAncho = $pdf->GetY()-$posY;
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetXY($posX, $posY);
                $pdf->MultiCell($AnchoCol1, $newAncho, 'CONTENIDO', 1, 'L');

                $pdf->SetFont('Arial', '', 10);
                $pdf->Ln(0.5);

                $pdf->SetFont('Arial', 'B', 10);
                $pdf->MultiCell(17, 0.7, 'PLANTEAMIENTO', 1, 'L');
                $pdf->SetFont('Arial', '', 10);
                $pdf->Ln(0.2);
                $pdf->MultiCell(17, 0.5, $reagent->planteamiento, 0, 'J');

                $pdf->Ln(0.3);

                if ($reagent->imagen == 'S')
                {
                    $extensionList = array('gif','png','jpg','jpeg','bmp');
                    $isValidPath = (bool)false;

                    foreach ($extensionList as $ext)
                    {
                        $path = storage_path('files/reagents/UPS-REA-'.$ReaId.'.'.$ext);
                        if ( File::exists($path) ) {
                            $isValidPath = (bool)true;
                            break;
                        }
                    }

                    $posY = $pdf->GetY();
                    if ($isValidPath)
                    {
                        //dd(getimagesize($path));
                        list($w, $h) = getimagesize($path);
                        $posX = (17-($w*10/$h))/2+2;
                        $whDiff = $w/$h-1;
                        if ($whDiff > 0.7)
                            $pdf->MultiCell(17, 10, $pdf->Image($path, $posX+0.9, $posY, 16, 0), 0, 'C');
                        else
                            $pdf->MultiCell(17, 10, $pdf->Image($path, $posX, $posY, 0, 10), 0, 'C');
                    }
                }

                $posY = $pdf->GetY();
                if($posY > 26.5)
                    $pdf->AddPage();

                $maxOpPreg = max($reagent->questionsConcepts->count(), $reagent->questionsProperties->count());

                if($maxOpPreg > 0)
                {
                    $pdf->Ln(0.5);
                    $y1 = $pdf->GetY();
                    $y2 = $y1;
                    for($i = 0; $i < $maxOpPreg; $i++)
                    {
                        $currentPage = $pdf->PageNo();

                        if($y1 > 26.5 && $y2 > 26.5)
                        {
                            $pdf->AddPage();
                            $y1 = $pdf->GetY();
                            $y2 = $y1;
                        }

                        if($reagent->questionsConcepts->count() > $i)
                        {
                            $conc = $reagent->questionsConcepts[$i];
                            $x1 = $pdf->GetX();
                            $pdf->SetXY($x1,$y1);
                            $pdf->MultiCell(1, 0.5, $conc->numeral.'.', 0, 'R');
                            $pdf->SetXY($x1+1,$y1);
                            $pdf->MultiCell(6.5, 0.5, $conc->concepto, 0, 'J');
                            $y1 = $pdf->GetY();
                        }

                        if($currentPage != $pdf->PageNo())
                        {
                            $y2 = 3.5;
                            $currentPage = $pdf->PageNo();
                        }

                        if($reagent->questionsProperties->count() > $i)
                        {
                            $prop = $reagent->questionsProperties[$i];
                            $pdf->SetXY(10,$y2);
                            $x2 = $pdf->GetX();
                            $pdf->MultiCell(1, 0.5, $prop->literal.')', 0, 'R');
                            $pdf->SetXY($x2+1,$y2);
                            $pdf->MultiCell(6.5, 0.5, $prop->propiedad, 0, 'J');
                            $y2 = $pdf->GetY();
                        }

                        if($currentPage != $pdf->PageNo())
                            $y1 = 3.5;
                    }
                }

                $pdf->Ln(0.5);

                $pdf->SetFont('Arial', 'B', 10);
                $pdf->MultiCell(17, 0.7, 'OPCIONES DE RESPUESTA', 1, 'L');
                $pdf->SetFont('Arial', '', 10);
                $pdf->Ln(0.2);

                foreach($reagent->answers as $answ)
                {
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    if($y > 26.5)
                    {
                        $pdf->AddPage();
                        $y = $pdf->GetY();
                    }

                    $pdf->MultiCell(1, 0.5, $answ->numeral.')', 0, 'R');
                    $pdf->SetXY($x+1,$y);
                    $pdf->MultiCell(15, 0.5, $answ->descripcion, 0, 'J');

                    $pdf->SetTextColor(0, 0, 0);
                }

                $pdf->Ln(0.5);
                $pdf->SetXY($pdf->GetX()+0.5,$pdf->GetY());
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->MultiCell(15, 0.7, 'RESPUESTA CORRECTA: OPCIÓN '.$reagent->answers->where('opcion_correcta', 'S')->first()->numeral, 0, 'L');
                $pdf->SetFont('Arial', '', 10);

                //$posY = $pdf->GetY();
                if($iRea < count($ids)-1)
                    $pdf->AddPage();

            }
            $pdf->Output();
            exit;
        }
        catch(\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            $ids = ($id > 0) ? $id : (isset($request->ids) ? $request->ids : "");
            Log::error("[ReagentsController][printReport] $ids=".$ids."; Exception: ".$ex);
            return redirect()->route('reagent.reagents.index');
        }
    }
}

