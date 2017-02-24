<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Matter;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;

class ExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('exam.exams.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $matters = Matter::query()->where('estado','A')->orderBy('descripcion', 'asc')->get();
        $id_materia = (isset($request['id_materia']) ? (int)$request->id_carrera : 0);

        $reagents = Reagent::query()->where('id_estado','5')->get();

        return view('exam.exams.create')
            ->with('matters', $matters)
            ->with('reagents', $reagents);
    }

    public function getReagentsByMatter($id_matter)
    {
        $matters = Matter::query()->where('estado','A')->orderBy('descripcion', 'asc')->get();
        $id_materia = (isset($request['id_materia']) ? (int)$request->id_carrera : 0);
        $matterSCareers = MatterCareer::query()->where('id_materia', $id_matter)->first()->id;
        dd($matterSCareers);
        $reagents = Reagent::query()->where('id_estado','5')->get();

        return view('exam.exams.create')
            ->with('matters', $matters)
            ->with('reagents', $reagents);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
