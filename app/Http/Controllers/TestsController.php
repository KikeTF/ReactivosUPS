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
        //
    }
}
