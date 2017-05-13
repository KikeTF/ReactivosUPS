<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\AnswerDetail;
use ReactivosUPS\AnswerHeader;
use ReactivosUPS\ExamDetail;
use ReactivosUPS\ExamHeader;
use ReactivosUPS\ExamParameter;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use Log;
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
        $id_examen = isset($request['id_examen']) ? $request['id_examen'] : 0;
        //$comment->creado_por = \Auth::id();
        //$comment->fecha_creacion = date('Y-m-d h:i:s');
        $id_examen= 1;
        $examDet = ExamHeader::find(1)->examsDetails()->orderByRaw("RAND()")->get()->pluck('id')->toArray();

    }

    public function question($id, Request $request)
    {
        
        $question = AnswerDetail::find($id);
        $test = AnswerHeader::find($question->id_resultado_cab);
        $reagent = $question->examDetail->reagent;
        $parameters = ExamParameter::query()->where('estado', 'A')->orderBy('id', 'desc')->first();


        return view('test.question')
            ->with('test', $test)
            ->with('question', $question)
            ->with('reagent', $reagent)
            ->with('parameters', $parameters);
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
                dd('Examen Finalizado');
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
            $id_sede = (isset($request['id_sede']) ? (int)$request->id_sede : 0);
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);

            $campusList = $this->getCampuses();
            if($id_sede > 0)
                $html = View::make('shared.optionlists._campuslist')
                    ->with('campusList', $campusList)
                    //->with('careerFilter', $id_carrera)
                    ->render();

                /*
            $id_careerCampus = CareerCampus::query()
                ->where('estado','A')
                ->where('id_campus', $id_campus)->first()->id;

            $dist = MatterCareer::filter($id_careerCampus, $id_mencion, 0)->get();

                if($dist->count() > 0)
                {
                    foreach ($dist as $car)
                    {
                        $ids[] = $car->id_carrera;
                    }
                }

            $careersList = Career::query();

            if(isset($ids))
                $careersList = $careersList->whereIn('id',$ids);

            $careersList = $careersList->where('estado','A')->orderBy('descripcion','asc')->lists('descripcion','id');

                */

        } catch (\Exception $ex) {
            Log::error("[MattersCareersController][getFormat] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
            $html = View::make('shared.optionlists._careerslist')->render();
        }
        return \Response::json(['html' => $html]);
    }
}
