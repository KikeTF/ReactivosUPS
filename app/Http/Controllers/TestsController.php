<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\AnswerDetail;
use ReactivosUPS\AnswerHeader;
use ReactivosUPS\Campus;
use ReactivosUPS\CareerCampus;
use ReactivosUPS\ExamDetail;
use ReactivosUPS\ExamHeader;
use ReactivosUPS\ExamParameter;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use Log;
use ReactivosUPS\Location;
use ReactivosUPS\Mention;
use View;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_examen = isset($request['id_examen']) ? $request['id_examen'] : 0;


        return view('test.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('test.create')
            ->with('locationsList', $this->getLocations());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_firstQuestion = 0;
        try
        {
            $id_campus = isset($request['id_campus']) ? $request['id_campus'] : 0;
            $id_carrera = isset($request['id_carrera']) ? $request['id_carrera'] : 0;

            $test = new AnswerHeader($request->all());

            $id_careerCampus = CareerCampus::query()
                ->where('id_carrera', $id_carrera)
                ->where('id_campus', $id_campus)
                ->where('estado', 'A')
                ->first()->id;

            $id_examen_test = ExamParameter::query()
                ->where('id_carrera_campus', $id_careerCampus)
                ->where('estado', 'A')
                ->orderBy('id', 'desc')->first()->id_examen_test;

            $test->id_examen_cab = $id_examen_test;
            $test->creado_por = 0;
            $test->fecha_creacion = date('Y-m-d h:i:s');

            $idsExamDet = ExamHeader::find($id_examen_test)->examsDetails()
                ->orderByRaw("RAND()")->get()->pluck('id')->toArray();

            foreach ($idsExamDet as $idDet)
            {
                $det["id_examen_det"] = $idDet;
                $det["creado_por"] = 0;
                $det["fecha_creacion"] = date('Y-m-d h:i:s');
                $testDet[] = new AnswerDetail($det);
            }

            if ( isset($testDet) )
            {
                \DB::beginTransaction(); //Start transaction!

                $test->save();
                $test->answersDetails()->saveMany($testDet);

                $id_firstQuestion = $test->answersDetails->first()->id;
            }
            else
            {
                flash("No se pudo procesar la solicitud", 'danger')->important();
                return redirect()->route('test.index');
            }
        }
        catch(\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            \DB::rollback();
            Log::error("[TestsController][store] Request: ".implode(',', $request->all())."; Exception: ".$ex);
            return redirect()->route('test.index');
        }
        finally
        {
            \DB::commit();
        }

        return redirect()->route('test.question', $id_firstQuestion);
    }

    public function question($id, Request $request)
    {
        $question = AnswerDetail::find($id);
        $test = AnswerHeader::find($question->id_resultado_cab);

        if($test->estado != 'A')
            return redirect()->route('test.index');

        $reagent = $question->examDetail->reagent;
        $parameters = ExamParameter::query()
            ->where('id_carrera_campus', $test->examHeader->id_carrera_campus)
            ->where('estado', 'A')
            ->orderBy('id', 'desc')->first();

        return view('test.question')
            ->with('test', $test)
            ->with('question', $question)
            ->with('reagent', $reagent)
            ->with('parameters', $parameters);
    }

    public function result($id)
    {
        $test = AnswerHeader::find($id);

        //Validar Tiempo
        
        return view('test.result')
            ->with('test', $test);
        //->with('question', $question)
        //  ->with('reagent', $reagent)
        //  ->with('parameters', $parameters);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $id_nextQuestion = isset($request['id_nextQuestion']) ? (int)$request['id_nextQuestion'] : 0;
            $id_opcion_resp = isset($request['id_opcion_resp']) ? (int)$request['id_opcion_resp'] : 0;
            $question = AnswerDetail::find($id);

            if ( $id_opcion_resp > 0 )
            {
                $question->id_opcion_resp = $id_opcion_resp;
                $question->resp_correcta = ($question->examDetail->reagent->id_opcion_correcta == $id_opcion_resp) ? 'S' : 'N';
                $question->save();
            }

            if ( $id_nextQuestion > 0 )
                return redirect()->route('test.question', $id_nextQuestion);
            else
            {
                $question->answerHeader->estado = 'F';
                $question->answerHeader->modificado_por = \Auth::id();
                $question->answerHeader->fecha_modificacion = date('Y-m-d h:i:s');
                $question->answerHeader->save();

                return redirect()->route('test.result', $question->answerHeader->id);
            }

        }
        catch(\Exception $ex)
        {
            flash("No se pudo procesar la respuesta!", 'danger')->important();
            Log::error("[TestsController][update] id: ".$id);
            return redirect()->route('test.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //throw
    }

    public function getLists(Request $request)
    {
        //dd($request->all());
        try
        {
            $lista = (isset($request['lista']) ? $request->lista : "");
            $id_sede = (isset($request['id_sede']) ? (int)$request->id_sede : 0);
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);

            //$locations = Location::find($id_sede);


            if ($lista == "campus")
            {
                $route = 'shared.optionlists._campuslist';

                $campusList = Campus::query()
                    ->where('id_sede', $id_sede)
                    ->where('estado','A')
                    ->orderBy('descripcion', 'asc')
                    ->lists('descripcion','id');

                $html = View::make($route)
                    ->with('campusList', $campusList)
                    ->render();
            }
            elseif ($lista == "carrera")
            {
                $route = 'shared.optionlists._careerslist';

                $careersList = CareerCampus::query()
                    ->where('estado','A')
                    ->where('id_campus', $id_campus)
                    ->get()->pluck('career')
                    ->sortBy('descripcion')
                    ->lists('descripcion','id');

                $html = View::make($route)
                    ->with('careersList', $careersList)
                    ->with('careerFilter', null)
                    ->render();

            }
            elseif ($lista == "mencion")
            {
                $route = 'shared.optionlists._mentionslist';

                $mentionsList = Mention::query()
                    ->where('id_carrera', $id_carrera)
                    ->where('id', '!=', 1)
                    ->where('estado', 'A')
                    ->lists('descripcion','id');

                if($mentionsList->count() > 0)
                    $html = View::make($route)
                        ->with('mentionsList', $mentionsList)
                        ->with('mentionFilter', $id_mencion)
                        ->render();
                else
                    $html = View::make($route)->render();
            }

        } catch (\Exception $ex) {
            Log::error("[TestsController][getList] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
            if (isset($route))
                $html = View::make($route)->render();
            else
                $html = '<select></select>';
        }
        return \Response::json(['html' => $html]);
    }
}
