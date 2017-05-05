<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Reagent;

class DashboardController extends Controller
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

        $id_campus = 1;
        $id_carrera = 1;

        $mattersCareers = $this->getMatterParameters(0, $id_carrera, $id_campus);

        $data['categories'] = $mattersCareers->pluck('matter')->sortBy('id')->lists('descripcion','id')->toArray();
        $data['target_series'] = $mattersCareers->sortBy('id_materia')->lists('nro_reactivos_mat','id_materia')->toArray();

        foreach ($mattersCareers->sortBy('id_materia')->pluck('id_materia')->toArray() as $idMat)
        {
            $reagents = Reagent::query()
                ->where('id_estado','5')
                //->whereIn('id_sede', array_unique($periodLoc->pluck('id_sede')->toArray()))
                //->whereIn('id_periodo', array_unique($periodLoc->pluck('id_periodo')->toArray()))
                ->where('id_campus', $id_campus)
                ->where('id_carrera', $id_carrera)
                ->where('id_materia', $idMat)->get();

            $data_real[$idMat] = $reagents->count();
        }

        $data['real_series'] = $data_real;

        return view('dashboard.index')
            ->with('data', $data);
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
