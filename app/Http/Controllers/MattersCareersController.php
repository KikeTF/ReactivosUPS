<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Career;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Matter;
use ReactivosUPS\Campus;
use ReactivosUPS\MatterCareer;
use Datatables;

class MattersCareersController extends Controller
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
        $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);
        $id_area = (isset($request['id_area']) ? (int)$request->id_area : 0);

        if($id_mencion > 0 && $id_carrera > 0 && $id_campus > 0){
            $careersCampuses = $this->getCareersCampuses();
            $id_careerCampus = $careersCampuses
                ->where('id_carrera', $id_carrera)
                ->where('id_campus', $id_campus)
                ->first()->id;

            if( $id_area > 0 )
                $mattersCareers = MatterCareer::filter($id_careerCampus, $id_mencion, $id_area)->where('estado', '!=', 'E')->get();
            else
                $mattersCareers = MatterCareer::filter2($id_careerCampus, $id_mencion)->where('estado', '!=', 'E')->get();
        }else
            $mattersCareers = MatterCareer::query()->where('estado', '!=', 'E')->get();

        $filters = array($id_campus, $id_carrera, $id_mencion, $id_area);

        return view('general.matterscareers.index')
            ->with('mattersCareers', $mattersCareers)
            ->with('campuses', $this->getCampuses())
            ->with('careers', $this->getCareers())
            ->with('areas', $this->getAreas())
            ->with('mentions', $this->getMentions())
            ->with('filters', $filters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("No disponible!");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd("No disponible!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mattercareer = MatterCareer::find($id);
        $mattercareer->desc_campus = Campus::find($mattercareer->careerCampus->id_campus)->descripcion;
        $mattercareer->desc_carrera = Career::find($mattercareer->careerCampus->id_carrera)->descripcion;
        $mattercareer->desc_mencion = $mattercareer->mention->descripcion;
        $mattercareer->desc_area = $mattercareer->area->descripcion;
        $mattercareer->desc_materia = $mattercareer->matter->descripcion;
        $mattercareer->usr_responsable = $this->getUserName($mattercareer->id_usr_responsable);
        $mattercareer->estado = ($mattercareer->estado == 'A') ? 'Activo' : 'Inactivo';
        $mattercareer->aplica_examen = ($mattercareer->aplica_examen == 'S') ? 'Si' : 'No';
        $mattercareer->creado_por = $this->getUserName($mattercareer->creado_por);
        $mattercareer->modificado_por = $this->getUserName($mattercareer->modificado_por);

        return view('general.matterscareers.show')->with('mattercareer', $mattercareer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mattercareer = MatterCareer::find($id);
        $mattercareer->desc_campus = Campus::find($mattercareer->careerCampus->id_campus)->descripcion;
        $mattercareer->desc_carrera = Career::find($mattercareer->careerCampus->id_carrera)->descripcion;
        $mattercareer->desc_mencion = $mattercareer->mention->descripcion;
        $mattercareer->desc_area = $mattercareer->area->descripcion;
        $mattercareer->desc_materia = $mattercareer->matter->descripcion;

        return view('general.matterscareers.edit')->with('mattercareer', $mattercareer);
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
        $matterCareer = MatterCareer::find($id);

        $matterCareer->nro_reactivos_mat = $request->nro_reactivos_mat;
        $matterCareer->nro_reactivos_exam = $request->nro_reactivos_exam;
        $matterCareer->aplica_examen = !isset( $request['aplica_examen'] ) ? 'N' : 'S';
        $matterCareer->estado = !isset( $request['estado'] ) ? 'I' : 'A';
        $matterCareer->modificado_por = \Auth::id();
        $matterCareer->fecha_modificacion = date('Y-m-d h:i:s');
        $matterCareer->save();

        return redirect()->route('general.matterscareers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matterCareer = MatterCareer::find($id);

        $matterCareer->estado = 'E';
        $matterCareer->modificado_por = \Auth::id();
        $matterCareer->fecha_modificacion = date('Y-m-d h:i:s');
        $matterCareer->save();

        return redirect()->route('reagent.formats.index');
    }
}
