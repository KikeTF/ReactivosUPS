<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Career;
use ReactivosUPS\Campus;
use ReactivosUPS\ContentDetail;
use ReactivosUPS\ContentHeader;
use ReactivosUPS\Format;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use ReactivosUPS\ReagentAnswer;
use ReactivosUPS\Distributive;
use ReactivosUPS\ReagentComment;
use Log;
use ReactivosUPS\ReagentQuestionConcept;
use ReactivosUPS\ReagentQuestionProperty;
use View;
use Illuminate\Support\Facades\Event;
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
        try {
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
            $id_estado = (isset($request['id_estado']) ? (int)$request->id_estado : 0);

            $filters = array($id_campus, $id_carrera, $id_materia, $id_estado);

            if ($id_campus > 0 && $id_carrera > 0 && $id_materia > 0) {
                $ids[] = $this->getDistributive($id_materia, $id_carrera, $id_campus)->first()->id;
                if ($id_estado == 0)
                    $reagents = Reagent::filter($ids)->where('id_estado', '!=', 7);
                else
                    $reagents = Reagent::filter2($ids, $id_estado)->where('id_estado', '!=', 7);
            } else
            {
                $idsDist = Distributive::query()->where('id_usuario', \Auth::id())->where('estado', 'A')->get()->pluck('id')->toArray();
                $reagents = Reagent::query()
                    ->where('id_estado', '!=', 7)
                    ->whereIn('id_distributivo', array_unique($idsDist));
            }

            $reagents = $reagents->orderBy('id', 'desc')->get();

            return view('reagent.reagents.index')
                ->with('reagents', $reagents)
                ->with('campusList', $this->getCampuses())
                //->with('careersList', $this->getCareers())
                //->with('matters', $this->getMatters($id_campus, $id_carrera, 0, 0))
                ->with('states', $this->getReagentsStates())
                ->with('statesLabels', $this->getReagentsStatesLabel())
                ->with('filters', $filters);
        } catch (\Exception $ex) {
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
        try {
            return view('reagent.reagents.create')
                ->with('campusList', $this->getCampuses())
                //->with('careers', $this->getCareers())
                //->with('matters', $this->getMatters(0, 0, 0, 0))
                //->with('mentions', $this->getMentions())
                //->with('contents', $this->getContentsModel())
                ->with('fields', $this->getFields())
                ->with('formats', $this->getFormats());
        } catch (\Exception $ex) {
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
            $id_periodo = (int)Session::get('idPeriodo');
            $id_sede = (int)Session::get('idSede');

            $reagent = new Reagent($request->all());
            $reagent->id_periodo = (int)Session::get('idPeriodo');
            $reagent->id_sede = (int)Session::get('idSede');
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
                $answer['opcion_correcta'] = (($i+1) == $request->input('opcion_correcta')) ? 'S' : 'N';
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

            $reagent->fecha_creacion = date('Y-m-d h:i:s');

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
        try {
            $reagent = Reagent::find($id);

            return view('reagent.reagents.show')
                ->with('reagent', $reagent);
            
        } catch (\Exception $ex) {
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
        try {
            $reagent = Reagent::find($id);
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
                        $reaAnswer->opcion_correcta = (($i+1) == $request->input('opcion_correcta')) ? 'S' : 'N';
                        $reaAnswer->modificado_por = \Auth::id();
                        $reaAnswer->fecha_modificacion = date('Y-m-d h:i:s');
                    }
                    elseif (isset($reqAnswer['descripcion']) && isset($reqAnswer['argumento']))
                    {
                        Log::debug("Reagent update: new answer create");
                        $answer['id_reactivo'] = $id;
                        //$answer['numeral'] = $reqAnswer['numeral'];
                        $answer['descripcion'] = $reqAnswer['descripcion'];
                        $answer['argumento'] = $reqAnswer['argumento'];
                        $answer['opcion_correcta'] = ($reqAnswer['numeral'] = $request->input('opcion_correcta')) ? 'S' : 'N';
                        $answer['opcion_correcta'] = (($i+1) == $request->input('opcion_correcta')) ? 'S' : 'N';
                        $answer['creado_por'] = \Auth::id();
                        $answer['fecha_creacion'] = date('Y-m-d h:i:s');
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
                        $reaQuestionConc->fecha_modificacion = date('Y-m-d h:i:s');
                    }
                    elseif (isset($reqQuestion['concepto']))
                    {
                        Log::debug("Reagent update: new question concept create");
                        $question['id_reactivo'] = $id;
                        //$question['numeral'] = $reqQuestion['numeral'];
                        $question['concepto'] = $reqQuestion['concepto'];
                        $question['creado_por'] = \Auth::id();
                        $question['fecha_creacion'] = date('Y-m-d h:i:s');
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
                        $reaQuestionProp->fecha_modificacion = date('Y-m-d h:i:s');
                    }
                    elseif (isset($reqQuestion['propiedad']))
                    {
                        Log::debug("Reagent update: new question property create");
                        $question['id_reactivo'] = $id;
                        //$question['literal'] = $reqQuestion['literal'];
                        $question['propiedad'] = $reqQuestion['propiedad'];
                        $question['creado_por'] = \Auth::id();
                        $question['fecha_creacion'] = date('Y-m-d h:i:s');
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
            $reagent->fecha_modificacion = date('Y-m-d h:i:s');

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
        $reagent = Reagent::find($id);
        try {
            $reagent->id_estado = 7;
            $reagent->modificado_por = \Auth::id();
            $reagent->fecha_modificacion = date('Y-m-d h:i:s');
            $reagent->save();
        } catch (\Exception $ex) {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ReagentsController][destroy] Datos: id=" . $id . ". Exception: " . $ex);
        }
        return redirect()->route('reagent.reagents.index');
    }


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
}

