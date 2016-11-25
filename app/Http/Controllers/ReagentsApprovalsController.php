<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Matter;
use ReactivosUPS\Campus;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use Datatables;

class ReagentsApprovalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
        $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
        //$id_area = (isset($request['id_area']) ? (int)$request->id_area : 0);
        $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);

        $filters = array($id_campus, $id_carrera, $id_materia);

        if($id_campus > 0 && $id_carrera > 0 && $id_materia > 0){
            $id_distributivo = $this->getDistributive($id_materia, $id_carrera, $id_campus)->id;
            $reagents = Reagent::filter($id_distributivo)->where('id_estado','!=',7)->get();
        }else
            $reagents = Reagent::query()->where('id_estado','!=',7)->get();

        return view('reagent.approvals.index')
            ->with('reagents', $reagents)
            ->with('campuses', $this->getCampuses())
            ->with('careers', $this->getCareers())
            ->with('matters', $this->getMatters())
            ->with('states', $this->getReagentsStates())
            ->with('statesLabels', $this->getReagentsStatesLabel())
            ->with('filters', $filters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
