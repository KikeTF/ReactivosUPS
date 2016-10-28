<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\ExamParameter;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use Datatables;

class ExamParametersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameter = ExamParameter::query()->where('estado', 'A')->orderBy('id', 'desc')->first();

        if( is_null($parameter) ){
            return view('exam.parameters.create');
        }else{
            return view('exam.parameters.index')->with('parameter', $parameter);
        }
    }

    public function history()
    {
        $parameter = ExamParameter::query()->where('estado', 'A')->get();
        return view('exam.parameters.history')->with('parameter', $parameter);
    }

    public function data()
    {
        $parameters = ExamParameter::query()->where('estado','A')->get();
        //dd($mattersCareers);
        return Datatables::of($parameters)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //si
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parameter = new ExamParameter($request->all());

        if( !isset( $request['estado'] ) )
            $parameter->estado = 'I';

        $parameter->creado_por = \Auth::id();
        $parameter->fecha_creacion = date('Y-m-d h:i:s');
        $parameter->save();


        return redirect()->route('exam.parameters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //si
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parameter = ExamParameter::find($id);
        return view('exam.parameters.edit')->with('parameter', $parameter);
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
        dd($request->all());
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
