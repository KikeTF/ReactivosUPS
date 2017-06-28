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
    public function index(Request $request)
    {
        try
        {
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $filters = array($id_campus, $id_carrera, 0, 0);

            $parameter = ExamParameter::query()->where('estado', 'A');
            if($id_carrera > 0 && $id_campus > 0)
            {
                $id_careerCampus = $this->getCareersCampuses()
                    ->where('id_carrera', $id_carrera)
                    ->where('id_campus', $id_campus)
                    ->first()->id;

                $parameter = $parameter->where('id_carrera_campus', $id_careerCampus);
            }

            $parameter = $parameter->orderBy('id', 'desc');

            //dd($parameter);

            if( $parameter->orderBy('id', 'desc')->get()->count() == 0 )
                return redirect()->route('exam.parameters.create');
            else
                return view('exam.parameters.index')
                    ->with('history', $parameter->get())
                    ->with('parameter', $parameter->first())
                    ->with('campusList', $this->getCampuses())
                    ->with('filters', $filters);

        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ExamParametersController][index] Exception: ".$ex);
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
        return view('exam.parameters.create')
            ->with('campusList', $this->getCampuses());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_careerCampus = 0;

            if($id_carrera > 0 && $id_campus > 0)
            {
                $id_careerCampus = $this->getCareersCampuses()
                    ->where('id_carrera', $id_carrera)
                    ->where('id_campus', $id_campus)
                    ->first()->id;
            }

            if ($id_careerCampus > 0) {
                $parameter = new ExamParameter($request->all());
                $parameter->id_carrera_campus = $id_careerCampus;
                $parameter->id_examen_real = 0;
                $parameter->estado = 'A';
                $parameter->creado_por = \Auth::id();
                $parameter->fecha_creacion = date('Y-m-d H:i:s');
                $parameter->save();

                flash('Transacci&oacuten realizada existosamente', 'success');
            }
            else
                flash("No se pudo realizar la transacci&oacuten", 'danger')->important();

        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ExamParametersController][store] Exception: ".$ex);
            return redirect()->route('exam.parameters.index');
        }

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
        return redirect()->route('index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('index');
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
        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->route('index');
    }
}
